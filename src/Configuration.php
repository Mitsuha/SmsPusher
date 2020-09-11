<?php

namespace mitsuha\SmsPusher;

trait Configuration
{
    public function table(){
        return config('sms.table-name');
    }

    public function valid(){
        return config('sms.valid');
    }

    public function inputKey(){
        return config('sms.inputKey','telephone');
    }

    public function responseOnSuccess(){
        return config('sms.success-response');
    }

    public function responseOnFail(){
        return config('sms.fail-response');
    }

    public function messageContent(){
        return config('sms.content');
    }

    public function reuse(){
        return config('sms.reuse');
    }

    public function appKey(){
        return config('app.key');
    }

    public function routePrefix($router = ''){
        return config('sms.route-prefix') . $router;
    }

    public function driver(){
        return config('sms.driver.default');
    }

    public function driverRealization(){
        return config('sms.driver.implement.' . $this->driver());
    }

    public function pusher(){
        return config('sms.pusher.default');
    }

    public function pusherRealization(){
        return config('sms.pusher.implement.' . $this->pusher());
    }
}
