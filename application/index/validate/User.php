<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25',
        'password'=>'length:3,25',
       
        'username'   => 'unique:user',
    ];
}