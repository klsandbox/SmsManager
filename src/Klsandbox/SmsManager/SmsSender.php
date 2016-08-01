<?php

namespace Klsandbox\SmsManager;

use Config;
use Illuminate\Routing\Router;
use Input;
use Request;

class SmsSender
{
    private $router;

    public function __construct()
    {
        $this->router = new Router(app('events'), app());
    }

    /**
     * @return \Illuminate\Routing\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    private function getMessage($route, $target_id, \Illuminate\Database\Eloquent\Model $user, \Illuminate\Console\Command $command)
    {
        $url = $route . '/' . $user->id . '/' . $target_id;

        $request = Request::create($url, 'GET');
        Input::initialize([]);

        if ($command->option('verbose')) {
            $command->comment('route:' . $route);
        }

        $data = $this->router->dispatch($request)->getOriginalContent();

        if ($data === null)
        {
            return null;
        }

        $view = 'sms.' . $route;
        $message = view($view, $data);

        if (Config::get('sms-manager.prefix')) {
            $message = Config::get('sms-manager.prefix') . $message;
        }

        $adminPhone = Config::get('sms-manager.admin_phone');
        $receiver_number = $adminPhone ? $adminPhone : $data['receiver_number'];
        $to = $user->name;

        // HACKHACK: Needs to update the database instead
        if ($receiver_number[0] != '6') {
            $receiver_number = '6' . $receiver_number;
        }

        return (object) ['to' => $to, 'receiver_number' => $receiver_number, 'message' => $message];
    }

    public function validate($route, $target_id, \Illuminate\Database\Eloquent\Model $user, \Illuminate\Console\Command $command)
    {
        $message = $this->getMessage($route, $target_id, $user, $command);

        if ($message === null)
        {
            return null;
        }

        if (!$message->receiver_number) {
            return false;
        }

        if (preg_match('/^6[057][0-9]{8,11}$/', $message->receiver_number)) {
            return true;
        }

        $command->error('Phone number failed validation ' . $message->receiver_number);

        return false;
    }

    public function send($route, $target_id, \Illuminate\Database\Eloquent\Model $user, \Illuminate\Console\Command $command)
    {
        $messageObject = $this->getMessage($route, $target_id, $user, $command);

        $note = "message:$messageObject->message - to:$messageObject->to - number:$messageObject->receiver_number";

        $sms_host = (Config::get('sms-manager.host'));
        $sms_route = (Config::get('sms-manager.route'));
        $sms_username = urlencode(Config::get('sms-manager.username'));
        $sms_password = urlencode(Config::get('sms-manager.password'));
        $sms_sender = urlencode(Config::get('sms-manager.sender'));
        $sms_type = urlencode(Config::get('sms-manager.type'));
        $message = urlencode($messageObject->message);
        $url = "http://$sms_host/$sms_route?username=$sms_username&password=$sms_password&message=$message&mobile=$messageObject->receiver_number&sender=$sms_sender&type=$sms_type";
        $command->comment("SMS - $note - url:$url");

        if (Config::get('sms-manager.pretend')) {
            $command->comment("pretend - $note - url:$url");
        } else {
            $response = file_get_contents($url);

            if ($command->option('verbose')) {
                $command->comment('response:' . $response);
            }

            if (preg_match('/^1701/', $response)) {
                $balance = SmsBalance::first();
                $balance->Spend($note);

                return $response;
            } elseif (preg_match('/^1704/', $response)) {
                $command->error('Insufficient Credits from provider');
            } elseif (preg_match('/^1705/', $response)) {
                $command->error('Invalid Mobile Number');
            } else {
                $command->error('Unmatched Error:' . $response);
            }
        }

        return false;
    }
}
