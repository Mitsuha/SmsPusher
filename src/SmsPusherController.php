<?php

namespace mitsuha\SmsPusher;

use Illuminate\Http\Request;

class SmsPusherController
{
    use Configuration;

    protected $pusher;

    public function __construct(SmsPusher $pusher)
    {
        $this->pusher = $pusher;
    }

    public function send(Request $request){
        $code = $this->pusher->generate();

        $content = $this->pusher->content(
            $request->input($this->inputKey()),
            $code
        );

        $this->pusher->push($content);

        return $this->pusher->response();
    }

}