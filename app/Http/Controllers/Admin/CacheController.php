<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use Session;

class CacheController extends Controller
{
    public function clear() {
      Artisan::call('cache:clear');
      Artisan::call('config:clear');
      Artisan::call('route:clear');
      Artisan::call('view:clear');

      Session::flash('success', __('Cache, route, view, config cleared successfully'));
      return back();
    }
}
