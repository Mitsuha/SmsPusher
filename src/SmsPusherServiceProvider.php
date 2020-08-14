<?php

namespace mitsuha\SmsPusher;

use Illuminate\Support\ServiceProvider;
use mitsuha\SmsPusher\Driver\RedisDriver;

class SmsPusherServiceProvider extends ServiceProvider
{
    public function boot():void {
        $this->app->make(RedisDriver::class);
    }

    public function register(): void
    {

    }
}