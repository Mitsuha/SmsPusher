<?php

namespace mitsuha\SmsPusher;

use Illuminate\Http\Request;

trait Validate
{
    /**
     * Hash Validate， 一般验证方法传一个 手机号和验证码就可以了，但是 Hash需要传一个 key，需要考虑如何获取
     * 1 response()
     * 2 直接传一个手机和验证码
     * 3 如果 driver 引入了 Validate trait 就用 driver 的 validate，否则就用自己的 validate
     * @param Request $request
     */
    public function validate(Request $request){

    }
}