<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Login extends Controller
{
    public function getlogin()
    {
    	// 加载登陆模板
        return $this->fetch("Login/login");
    }
    // 执行登陆
    public function postdologin()
    {
        $fcode = request()->param('fcode');
    	// 获取用户名和密码
    	$name = request()->param('username');
    	$pwd = request()->param('password');
        // 获取登陆ip
        // $ip = request()->ip();
        if (captcha_check($fcode)) {
        	$row = Db::table('admins')->where("admins='{$name}' and pwds='{$pwd}'")->select();
            if ($row) {
               if ($row[0]['zid'] !=0) {
                    if($row){
                        // 把用户信息存在session里
                        Session::set('islogin',2);
                        Session::set('aname',$row[0]['aname']);
                        Session::set('cart',$row[0]['cart']);
                        Session::set('zid',$row[0]['zid']);
                        $this->success("登陆成功","/admin/index");
                    }else{
                        $this->error("账号或者密码输入错误","/adminlogin/login");
                    }
                }else{
                    $this->error("账号已被禁用","/adminlogin/login");
                }
            }else{
                $this->error("对不起账号不存在","/adminlogin/login");
            }
        }else{
        	$this->error("验证码输入错误请重新输入","/adminlogin/login");
        }
    }
    // 执行退出
    public function getlogout(){
    	Session::delete('islogin');
    	Session::delete('aname');
    	Session::delete('cart');
    	Session::delete('zid');
    	$this->success("退出成功","/adminlogin/login");
    }
}