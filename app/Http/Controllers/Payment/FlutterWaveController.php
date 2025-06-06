<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Http\Helpers\MegaMailer;
use App\Models\Language;
use App\Models\PaymentGateway;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class FlutterWaveController extends Controller
{
    public $public_key;
    private $secret_key;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('flutterwave')->first();
        $paydata = $data->convertAutoData();
        $this->public_key = $paydata['public_key'];
        $this->secret_key = $paydata['secret_key'];
    }

    public function paymentProcess(Request $request, $_amount, $_email, $_item_number, $_successUrl, $_cancelUrl, $bex)
    {
        $cancel_url = $_cancelUrl;
        $notify_url = $_successUrl;
        Session::put('request', $request->all());
        Session::put('payment_id', $_item_number);

        // SET CURL

        $curl = curl_init();
        $currency = $bex->base_currency_text;
        $txref = $_item_number; // ensure you generate unique references per transaction.
        $PBFPubKey = $this->public_key; // get your public key from the dashboard.
        $redirect_url = $notify_url;
        $payment_plan = ""; // this is only required for recurring payments.


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $_amount,
                'customer_email' => $_email,
                'currency' => $currency,
                'txref' => $txref,
                'PBFPubKey' => $PBFPubKey,
                'redirect_url' => $redirect_url,
                'payment_plan' => $payment_plan
            ]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the rave API
            return redirect($cancel_url)->with('error', 'Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);
        if ($transaction->status == 'success' && !is_null(@$transaction->data->link)) {
            return redirect()->to($transaction->data->link);
        } else {
            if (!is_null(@$transaction->data->link)) {
                return redirect($cancel_url)->with('error', 'API returned error: ' . $transaction->data->message);
            }
        }
    }

    public function successPayment(Request $request)
    {
        $requestData = Session::get('request');
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;

        $cancel_url = route('membership.cancel');
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('payment_id');
        if (isset($request['txref'])) {
            $ref = $payment_id;
            $query = array(
                "SECKEY" => $this->secret_key,
                "txref" => $ref
            );
            $data_string = json_encode($query);
            $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            curl_close($ch);
            $resp = json_decode($response, true);

            if ($resp['status'] == 'error') {
                return redirect($cancel_url);
            }
            if ($resp['status'] = "success") {
                $paymentStatus = $resp['data']['status'];
                $paymentFor = Session::get('paymentFor');
                if ($resp['status'] = "success") {
                    $package = Package::find($requestData['package_id']);
                    $transaction_id = UserPermissionHelper::uniqidReal(8);
                    $transaction_details = json_encode($resp['data']);
                    if ($paymentFor == "membership") {
                        $amount = $requestData['price'];
                        $password = $requestData['password'];
                        $checkout = new CheckoutController();
                        $requestData['status'] = 1;
                        $user = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $be, $password);


                        $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
                        $activation = Carbon::parse($lastMemb->start_date);
                        $expire = Carbon::parse($lastMemb->expire_date);
                        $file_name = Common::makeInvoice($requestData, "membership", $user, $password, $amount, "Flutterwave", $requestData['phone'], $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title,1);

                        $mailer = new MegaMailer();
                        $data = [
                            'toMail' => $user->email,
                            'toName' => $user->fname,
                            'username' => $user->username,
                            'package_title' => $package->title,
                            'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                            'activation_date' => $activation->toFormattedDateString(),
                            'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                            'membership_invoice' => $file_name,
                            'website_title' => $bs->website_title,
                            'templateType' => 'registration_with_premium_package',
                            'type' => 'registrationWithPremiumPackage'
                        ];
                        $mailer->mailFromAdmin($data);


                        session()->flash('success', __('successful_payment'));
                        Session::forget('request');
                        Session::forget('paymentFor');
                        return redirect()->route('success.page');
                    } elseif ($paymentFor == "extend") {
                        $amount = $requestData['price'];
                        $password = uniqid('qrcode');
                        $checkout = new UserCheckoutController();
                        $user = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $be, $password);

                        $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
                        $activation = Carbon::parse($lastMemb->start_date);
                        $expire = Carbon::parse($lastMemb->expire_date);
                        $file_name = Common::makeInvoice($requestData, "extend", $user, $password, $amount, $requestData["payment_method"], $user->phone_number, $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, 1);

                        $mailer = new MegaMailer();
                        $data = [
                            'toMail' => $user->email,
                            'toName' => $user->fname,
                            'username' => $user->username,
                            'package_title' => $package->title,
                            'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                            'activation_date' => $activation->toFormattedDateString(),
                            'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                            'membership_invoice' => $file_name,
                            'website_title' => $bs->website_title,
                            'templateType' => 'membership_extend',
                            'type' => 'membershipExtend'
                        ];
                        $mailer->mailFromAdmin($data);

                        session()->flash('success', __('successful_payment'));
                        Session::forget('request');
                        Session::forget('paymentFor');
                        return redirect()->route('success.page');
                    }
                }
            }
            return redirect($cancel_url);
        }
        return redirect($cancel_url);
    }
}
