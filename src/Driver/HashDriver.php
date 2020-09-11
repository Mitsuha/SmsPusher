<?php

namespace mitsuha\SmsPusher\Driver;

use Illuminate\Support\Facades\Hash;
use mitsuha\SmsPusher\Configuration;
use mitsuha\SmsPusher\src\Driver\ResponseContracts;
use mitsuha\SmsPusher\src\Driver\ValidateContracts;

class HashDriver implements DriverContracts, ValidateContracts, ResponseContracts
{
    use Configuration;

    protected $key;

    public function get($telephone)
    {
        throw new \BadMethodCallException('Call unsupported method mitsuha\SmsPusher\Driver\HashDriver::get()');
    }

    public function set($telephone, $code): void
    {
        $this->key = $this->generate($telephone, $code);
    }

    public function delay($telephone, $code): void
    {
        $this->key = $this->generate($telephone, $code);
    }

    public function supportDelay(): bool
    {
        return true;
    }

    public function validate($telephone, $code): bool
    {

    }

    protected function generate($telephone, $code): string
    {
        $key = sprintf('%s.%s.%s.%s', $code, $telephone, time(), $this->appKey());

        return sprintf('%s.%s.%s', $telephone, time(), Hash::make($key));
    }

    protected function check($telephone, $code): bool
    {

    }

    public function response()
    {
        $response = $this->responseOnSuccess();

        if (is_array($response)){
            $response['key'] = $this->key;
        }

        else{
            $response = [
                'code' => 200,
                'message' => 'SMS verification code sent successfully',
                'token' => $this->key
            ];
        }

        return $response;
    }
}