<?php

namespace mitsuha\SmsPusher\src\Driver;

interface ValidateContracts
{
    public function validate($telephone, $code): bool ;
}