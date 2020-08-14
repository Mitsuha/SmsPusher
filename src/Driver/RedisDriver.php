<?php

namespace mitsuha\SmsPusher\Driver;

use Illuminate\Redis\RedisManager;
use mitsuha\SmsPusher\Configuration;

class RedisDriver implements DriverContracts
{
    use Configuration;

    private $redis;

    public function __construct(RedisManager $redis)
    {
        $this->redis = $redis;
    }

    public function get($telephone)
    {
        return $this->client()->hGet($this->table(),$telephone);
    }

    public function set($telephone, $code): void
    {
        $this->client()->hSet($this->table(), $telephone, $code);
    }

    public function delay($telephone): void
    {
        //
    }

    public function supportDelay(): bool
    {
        return false;
    }

    public function client(){
        return $this->redis->client();
    }
}