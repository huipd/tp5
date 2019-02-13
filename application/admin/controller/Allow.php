<?php
namespace app\admin\controller;
use think\Session;
use think\Controller;
class Allow extends Controller
{
   public function _initialize()
   {
   		// 检测session信息
   		if (!Session::get('islogin')) {
   			$this->error("请先登录用户","/adminlogin/login");
   		}
   }
}
