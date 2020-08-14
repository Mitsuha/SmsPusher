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
        return config('sms.input-key');
    }

    public function responseOnSuccess(){
        return config('sms.success-response');
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
}