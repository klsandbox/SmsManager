<?php

namespace Klsandbox\SmsManager;

use Illuminate\Database\Seeder;
use Klsandbox\SiteModel\Site;

class SmsBalanceTableSeeder extends Seeder {

    public function run() {
        if (SmsBalance::count() > 0) {
            return;
        }

        foreach (Site::all() as $site) {
            Site::setSite($site);
            SmsBalance::create(array(
                'balance' => 0,
            ));
        }
    }

}
