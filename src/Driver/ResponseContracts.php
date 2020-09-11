<?php

namespace mitsuha\SmsPusher\src\Driver;

use mitsuha\SmsPusher\Sms\SmsPusherContracts;

interface ResponseContracts
{
    public function response(SmsPusherContracts $pusher);
}
