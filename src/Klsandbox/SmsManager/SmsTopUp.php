<?php

namespace Klsandbox\SmsManager;

use Illuminate\Console\Command;
use App\Models\SmsBalance;
use Klsandbox\SiteModel\Site;

class SmsTopUp extends Command {

    protected $name = 'sms:topup';
    protected $description = 'Send pending notifications. Supports email and sms.';

    protected function getArguments() {
        return [['unused-key' => 'amount']];
    }

    public function fire() {
        $this->comment('top up for site ' . Site::key());

        $balance = SmsBalance::where('site_id', '=', Site::id())->first();
        
        if (!$balance)
        {
            $this->error("Sms Balance not found for site '" . Site::key() . "'");
            return;
        }

        $amount = $this->argument('amount');

        $balance->TopUp($amount, "Top Up From Console");
    }

}
