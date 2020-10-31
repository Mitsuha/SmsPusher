<?php

namespace mitsuha\SmsPusher;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use mitsuha\SmsPusher\Driver\DriverContracts;
use mitsuha\SmsPusher\Driver\RedisDriver;
use mitsuha\SmsPusher\Sms\FakerPusher;
use mitsuha\SmsPusher\Sms\SmsPusherContracts;

class SmsPusherServiceProvider extends ServiceProvider
{
    use Configuration;

    public function boot():void
    {
        $this->publishes([
            __DIR__ . '/../config/sms.php' => config_path('sms.php')
        ], 'config');

        $this->app->bind(DriverContracts::class, $this->driverRealization());
        $this->app->bind(SmsPusherContracts::class, $this->pusherRealization());

        $this->registerRouter($this->app['router']);
        $this->registerValidator($this->app['validator']);

    }

    public function registerRouter($router){
        $router->post($this->routePrefix(), SmsPusherController::class . '@captcha')->middleware('throttle:1,1');
    }

    public function registerValidator($validator){
        $validator->extend('sms', function ($attribute, $value, $parameters) {
            request()->validate([
                $attribute.'Captcha' => ['required']
            ]);

            $pusher = $this->app->make(SmsPusher::class);
            return $pusher->validate($value, request()->input($attribute.'Captcha'));
        });
    }

    public function register(): void
    {

    }
}
