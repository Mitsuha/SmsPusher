<?php

namespace mitsuha\SmsPusher;

use mitsuha\SmsPusher\Driver\DriverContracts;
use mitsuha\SmsPusher\Sms\SmsPusherContracts;
use mitsuha\SmsPusher\src\Driver\ResponseContracts;
use mitsuha\SmsPusher\src\Driver\ValidateContracts;

class SmsPusher
{
    use Configuration;

    protected $driver;

    protected $pusher;

    public $telephone;

    protected $code;

    public function __construct(DriverContracts $driver, SmsPusherContracts $pusher)
    {
        $this->driver = $driver;
        $this->pusher = $pusher;
    }

    public function push($content){
        $this->pusher->push($content);
    }

    public function validate($telephone, $code): bool
    {
        if ($this->driver instanceof ValidateContracts){
            return $this->driver->validate($telephone, $code);
        }

        return $this->driver->get($telephone) == $code;
    }

    public function generate(): self
    {
        if ($this->reuse() && $this->driver->supportDelay() && $this->telephone !== null){
            $this->code = $this->driver->get($this->telephone);
        }

        $this->code = '';

        return $this;
    }

    public function content($telephone = null, $code = null): string
    {
        $telephone = $telephone === null ? $this->telephone : $telephone;
        $code = $code === null ? $this->code : $code;
        $valid = $this->valid();

        $str = $this->messageContent();

        foreach (compact('telephone', 'code', 'valid') as $key => $value){
            $str = str_replace("{{$key}}", $value, $str);
        }

        return $str;
    }

    public function response()
    {
        return $this->driver instanceof ResponseContracts
            ? $this->driver->response()
            : $this->responseOnSuccess();
    }

    public function setTelephone($telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }
}