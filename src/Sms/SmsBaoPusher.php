<?php

namespace mitsuha\SmsPusher\Sms;

use Illuminate\Support\Arr;

class SmsBaoPusher implements SmsPusherContracts
{
    public $result;

    private $status = array(
        '0' => '短信发送成功',
        '-1' => '参数不全',
        '-2' => '服务器空间不支持curl或者fsocket',
        '30' => '密码错误',
        '40' => '账号不存在',
        '41' => '余额不足',
        '42' => '帐户已过期',
        '43' => 'IP地址限制',
        '50' => '内容含有敏感词'
    );

    private $api = 'http://api.smsbao.com/';

    public function push($phoneNumber, $content): void
    {
        $user = config('sms.pusher-configuration.smsBao.username');
        $pass = md5(config('sms.pusher-configuration.smsBao.password'));

        $url = $this->api.'sms?u='.$user.'&p='.$pass.'&m='.$phoneNumber.'&c='.urlencode($content);

        $this->result = file_get_contents($url) ;
    }

    public function success(): bool
    {
        return $this->result == 0;
    }

    public function message(): string
    {
        return Arr::get($this->status, $this->result);
    }
}
