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

    protected $content;

    protected $telephone;

    protected $code;

    public function __construct(DriverContracts $driver, SmsPusherContracts $pusher)
    {
        $this->driver = $driver;
        $this->pusher = $pusher;
    }

    public function push($content = null){
        $content = $content === null ? $this->getContent() : $content;

        $this->pusher->push($this->telephone,$content);
    }

    public function validate($telephone, $code): bool
    {
        if ($this->driver instanceof ValidateContracts){
            return $this->driver->validate($telephone, $code);
        }

        return $this->driver->get($telephone) == $code;
    }

    public function generateCode(): self
    {
        if ($this->telephone === null){
            throw new \Exception('A verification code was generated without setting the telephone number');
        }

        if ($this->reuse() && $this->driver->supportDelay()){
            $this->code = $this->driver->get($this->telephone);
        }

        else{
            $this->code = rand(1111,9999);
            $this->driver->set($this->telephone, $this->code);
        }

        return $this;
    }

    public function createContent($code = null): self
    {
        $code = $code === null ? $this->getCode() : $code;
        $valid = $this->valid();

        $str = $this->messageContent();

        foreach (compact('code', 'valid') as $key => $value){
            $str = str_replace("{{$key}}", $value, $str);
        }

        $this->content = $str;

        return $this;
    }

    public function response()
    {
        if ($this->driver instanceof ResponseContracts)
            return $this->driver->response($this->pusher);

        if ($this->pusher->success()){
            return $this->responseOnSuccess();
        }

        return $this->responseOnFail();
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

    public function getPusher(){
        return $this->pusher;
    }

    public function getContent(){
        return $this->content;
    }
}
