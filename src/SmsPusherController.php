<?php

namespace mitsuha\SmsPusher;

use Illuminate\Http\Request;
use mitsuha\SmsPusher\Request\SmsRequest;

class SmsPusherController
{
    use Configuration;

    protected $pusher;

    public function __construct(SmsPusher $pusher)
    {
        $this->pusher = $pusher;
    }

    public function captcha(SmsRequest $request){
        $request->validate([
            $this->inputKey() => ['required']
        ]);

        $phoneNumber = $request->input($this->inputKey());
        $this->pusher->setTelephone($phoneNumber)
            ->generateCode()
            ->createContent()
            ->push();

        return $this->pusher->response();
    }

}
