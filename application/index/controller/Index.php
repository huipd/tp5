<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
class Index extends Controller
{
    public function getindex()
    {
    	// 加载前台模板
        $islogins = Session::has('islogin');
        return $this->fetch("Index/index",['islogin'=>$islogins]);
    }
    // 加载注册模板
    public function getregister()
    {
        $islogins = Session::has('islogin');
        return $this->fetch("Index/signup",['islogin'=>$islogins]);
    }
    public function getLogin()
    {
    	// 加载注册模板载登陆
        $islogins = Session::has('islogin');
        return $this->fetch("Index/login",['islogin'=>$islogins]);
    }
    // 手机号验证
    public function getphone()
    {
        //请求对象
        $request=request();
        //获取手机
        $p=$request->get('phone');
        //获取users 数据表的手机号
        $arr=Db::table("users")->column('phone');
        //对比
        if(in_array($p,$arr)){
            echo 1;
        }else{
            echo 0;
        }
    }
    // 邮箱验证
    public function getcheckmail()
    {
        //请求对象
        $request=request();
        //获取邮箱
        $email=$request->get('email');
        //获取users 数据表的邮箱
        $arr=Db::table("users")->column('email');
        // echo "<pre>";
        // var_dump($arr);
        //对比
        if(in_array($email,$arr)){
            echo 1;
        }else{
            echo 0;
        }
    }
    // 验证码验证
    public function getcode(){
        // 获取验证码
        $code=request()->get('code');
        if(!captcha_check($code)){
            echo 1;
        }else{
            echo 0;
        }
    }
    // 短信验证发送短信
    public function getcheckp(){
        $p=request()->get('p');
        send($p);
    }
    // 短信验证码是否合法
    public function getcheckcod(){
        $cod = request()->get('cod');
        //对比手机接收到的校验码和输入的校验码
        if(isset($_COOKIE['vcode'])){
            //获取手机接收的校验码
            $vcode=$_COOKIE['vcode'];
            //对比
            if($cod==$vcode){
                echo 0;//对比正确
            }else{
                echo 1;//验证码输入有误
            }
        }else{
            echo 2;//验证码已过期
        }
    }
    // 执行注册
    public function postdoregister(){
        $data=request()->only(['phone','email','pwd']);
        $data['addtime'] = time();
        $data['state'] = 1;
        if (Db::table('users')->insert($data)) {
            $this->redirect('/pass/Login');
        }else{
            $this->redirect('/pass/register');
        }
    }
    // 执行登陆
    public function postserviceLogin(){
        $data=request()->only(['phone','pwd']);
        $user = Db::table('users')->where('phone',$data['phone'])->find();
        if ($user['pwd'] == $data['pwd']) {
            Session::set('islogin',1);
            Session::set('phone',$user['phone']);
            Session::set('state',$user['state']);
            $this->redirect('/');
        }else{
            $this->redirect('/pass/Login');
        }
    }
    // 执行退出
    public function getlogouts(){
        Session::delete('islogin');
        Session::delete('phone');
        Session::delete('state');
        $this->success("退出成功","/");
    }
}
