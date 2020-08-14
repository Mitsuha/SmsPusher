<?php

namespace mitsuha\SmsPusher\Sms;

class FakerPusher implements SmsPusherContracts
{
    public $result;

    public function push($content): void
    {
        // 让我们假装这里发送成功了
        $this->result = true;
    }

    public function success(): bool
    {
        return $this->result;
    }

    public function message(): string
    {
        return 'Request Timeout';
    }
}