<?php

namespace mitsuha\SmsPusher\Driver;

interface DriverContracts
{
    public function get($telephone);

    public function set($telephone, $code): void ;

    public function delay($telephone): void ;

    public function supportDelay(): bool ;
}