<?php

namespace Klsandbox\SmsManager;

use Config;
use Klsandbox\SiteModel\Site;
use Request;
use Input;
use Illuminate\Routing\Router;

class SmsSender {

    private $router;

    public function __construct() {
        $this->router = new Router(app('events'), app());
    }

    /**
     * 
     * @return \Illuminate\Routing\Router
     */
    public function getRouter() {
        return $this->router;
    }

    public function send($route, $target_id, \Illuminate\Database\Eloquent\Model $user, Site $site, \Illuminate\Console\Command $command) {
        Site::protect($user, 'User');
        
        $url = $route . '/' . $user->id . '/' . $target_id;
        
        $request = Request::create($url, 'GET');
        Input::initialize([]);
        
        if ($command->option('verbose'))
        {
            $command->comment("route:" . $route);
        }

        $data = $this->router->dispatch($request)->getOriginalContent();

        $view = 'sms.' . $route;
        $message = view($view, $data);
        $receiver_number = env('SMS_ADMIN_PHONE', $data['receiver_number']);
        $to = $user->name;

        $note = "message:$message - to:$to - number:$receiver_number";

        $sms_host = (Config::get('sms-manager.host'));
        $sms_route = (Config::get('sms-manager.route'));
        $sms_username = urlencode(Config::get('sms-manager.username'));
        $sms_password = urlencode(Config::get('sms-manager.password'));
        $sms_sender = urlencode(Config::get('sms-manager.sender'));
        $sms_type = urlencode(Config::get('sms-manager.type'));
        $message = urlencode($message);
        $url = "http://$sms_host/$sms_route?username=$sms_username&password=$sms_password&message=$message&mobile=$receiver_number&sender=$sms_sender&type=$sms_type";
        $command->comment("SMS - $note - url:$url");

        if (Config::get('sms-manager.pretend')) {
            $command->comment("pretend - $note - url:$url");
        } else {
            $response = file_get_contents($url);

            if (preg_match("/^1701/", $response)) {
                $balance = SmsBalance::where('site_id', '=', $site->id)->first();
                $balance->Spend($note);
                
                return $response;
            }
        }

        return false;
    }

}
