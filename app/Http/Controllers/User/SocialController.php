<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller
{
    public function index()
    {
        $data['socials'] = Social::where('user_id', Auth::guard('web')->user()->id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('user.settings.social.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'url' => 'required',
            'serial_number' => 'required|integer',
        ]);

        $social = new Social;
        $social->icon = $request->icon;
        $social->url = $request->url;
        $social->serial_number = $request->serial_number;
        $social->user_id = Auth::guard('web')->user()->id;
        $social->save();

        Session::flash('success', __('Created successfully'));
        return back();
    }

    public function edit($id)
    {
        $data['social'] = Social::where('user_id', Auth::guard('web')->user()->id)->where('id', $id)->firstOrFail();
        return view('user.settings.social.edit', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'url' => 'required',
            'serial_number' => 'required|integer',
        ]);

        $social = Social::where('user_id', Auth::guard('web')->user()->id)->where('id', $request->socialid)->firstOrFail();
        $social->icon = $request->icon;
        $social->url = $request->url;
        $social->serial_number = $request->serial_number;
        $social->user_id = Auth::guard('web')->user()->id;
        $social->save();

        Session::flash('success', __('Updated Successfully'));
        return back();
    }

    public function delete(Request $request)
    {
        $social = Social::where('user_id', Auth::guard('web')->user()->id)->where('id', $request->socialid)->firstOrFail();
        $social->delete();
        Session::flash('success', __('Deleted successfully'));
        return back();
    }
}
