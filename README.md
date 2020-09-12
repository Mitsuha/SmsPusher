# 高扩展性的短信验证码扩展包

## 安装
使用 composer 安装包：
```
composer require mitsuha/sms-pusher
```
发布资源组
```shell script
php artisan vendor:publish --tag=config 
```
## 使用
提供了一个控制器来获取验证码，路由可在配置文件中的 `route-prefix` 中修改，控制器获取手机号的字段可以在 `inputKey` 中修改

提供了 `sms` 验证规则，在需要短信验证的字段添加后，请求时需多带一个 `{$attribute}Code`， 如：
```shell script
$request->validate([
    'telephone' => ['required', 'sms']
]);
```
请求时：
```http request
application/json
{
    "telephone": "1-503-962-3772",
    "telephoneCode": "35614"
}
```
如验证码正确，请求将通过。否则会抛出一个表单异常

## 配置
SmsPusher 分为两部分：
一个是 Driver 负责存储和校验验证码，另一个 Pusher 负责处理发信请求。扩展包中定义了两个 Contracts 分别对应两部分的业务实现  
- 自定义储存和校验逻辑请实现 `mitsuha\SmsPusher\Driver\DriverContracts`
- 自定义发信请求请实现 `mitsuha\SmsPusher\Sms\SmsPusherContracts`

之后在配置文件 `sms.php` 中添加对应的实现，然后修改 `default` 使其生效
```
'driver' => [
    'default' => 'example',
    'implement' => [
       'redis' => \mitsuha\SmsPusher\Driver\RedisDriver::class,
       'hash' => \mitsuha\SmsPusher\Driver\HashDriver::class,
       'example' => \App\Http\Realization\ExampleDriver::class,
    ]
]
```
大多数情况下，验证码存储和校验都有通用的解决方案，但短信服务商多种多样，其提供的 API 也一言难尽。与其去支持各种服务商，不如把校验和存储的部分实现，具体的发信行为交由用户

实现一个发信请求，SmsPusher 需要你实现 `mitsuha\SmsPusher\Sms\SmsPusherContracts` 接口：
```
// 向指定的手机号，发送指定内容的短信
public function push($telephone, $content): void ;

// 短息发送是否成功
public function success(): bool ;

// 不成功时的错误信息
public function message(): string ;
```  
