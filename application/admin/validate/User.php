<?php 
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    // 设置规则
    protected $rule = [
    	
        'aname'  =>  'require|chs|unique:admins',
        'admins' => 'require|regex:\w{3,18}|unique:admins',
        'pwds'=>'require|regex:\w{6,10}',
        'repwd'=>'require|confirm:pwds',
        // 'email' =>  'require|email|unique:users',
    ];
    // 规则提示信息
    protected $message = [
        'aname.require'  =>  '用户名不能为空',
        'aname.chs'  =>  '用户名必须为汉字',
        'aname.unique'  =>  '已存在用户名',
        'admins.require'  =>  '账号不能为空',
        'admins.regex'  =>  '账号必须为3—6位任意数字字母下划线',
        'admins.unique'  =>  '账号已存在',
        'pwds.require'=>'密码不能为空',
        'pwds.regex'=>'密码为6-10位任意数字字母下划线',
        'repwd.require'=>'确认密码不能为空',
        'repwd.confirm'=>'两次密码不一致',
        // 'email.require' =>  '邮箱不能为空',
        // 'email.email' =>  '邮箱格式错误',
        // 'email.unique' =>  '邮箱不能重复',
    ];

    protected $scene = [
        'add'   =>  ['aname','admins','email','pwds','repwd'],
    ];
}

 ?>