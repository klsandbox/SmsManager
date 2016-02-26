<?php

namespace Klsandbox\SmsManager;

use App\Http\Controllers\Controller;
use Klsandbox\SiteModel\Site;
use Illuminate\Support\Facades\App;

class SmsManagementController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => 'getFakeSms']);
    }

    public function getFakeSms() {
        return "1701:" . mt_rand(1000000, 99999999);
    }

    public function getView() {

        $smsBalances = SmsBalance::forSite()->get();
        if ($smsBalances->count() == 0) {
            App::abort(404, 'SMS not found for site');
        }

        if ($smsBalances->count() > 1) {
            App::abort(500, 'invalid state');
        }

        $smsBalance = $smsBalances->first();

        $totalBalance = $smsBalance->balance;

        $items = SmsTransactionLog::forSite()
                ->orderBy('created_at', 'DESC')
                ->paginate(100);

        $lastTransactionLog = SmsTransactionLog::forSite()
                ->where('delta', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->first();

        $last_reload_time = null;
        $last_reload_amount = null;

        if ($lastTransactionLog) {
            $last_reload_time = $lastTransactionLog->created_at;
            $last_reload_amount = $lastTransactionLog->delta;
        }

        return view('sms-manager::view-sms')
                        ->with('total_balance', $totalBalance)
                        ->with('list', $items)
                        ->with('last_reload_time', $last_reload_time)
                        ->with('last_reload_amount', $last_reload_amount);
    }

}
