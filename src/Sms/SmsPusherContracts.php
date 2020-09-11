<?php

namespace mitsuha\SmsPusher\Sms;

interface SmsPusherContracts
{
    public function push($telephone, $content): void ;

    public function success(): bool ;

    public function message(): string ;
}
