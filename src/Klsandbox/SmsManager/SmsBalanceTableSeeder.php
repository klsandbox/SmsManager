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
            $this->runForSite($site->id);
        }
    }
    
    public function runForSite($siteId) {
        SmsBalance::create(array(
            'balance' => 0,
            'site_id' => $siteId,
        ));
    }
}
