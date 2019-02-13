<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;
// 接收短信验证
function send($p)
{
	Vendor('lib.Ucpaas');
	//填写在开发者控制台首页上的Account Sid
	$options['accountsid']='6308c1c2692a55d3c97a69438b5df1ec';
	//填写在开发者控制台首页上的Auth Token
	$options['token']='eec9eb144a371ccac49356ff408d4d15';
	//初始化 $options必填
	$ucpass = new Ucpaas($options);

	$appid = "51863c02632c49b2bcd0133fedd08dd2";	//应用的ID，可在开发者控制台内的短信产品下查看
	$templateid = "426257";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID
	$param = rand(1000,9999);  //产生一个随机验证码
	// 把验证码存在cookieli
	setcookie('vcode',$param,time()+60);
	$mobile = $p;
	$uid = "";
	echo $ucpass->SendSms($appid,$templateid,$param,$mobile,$uid);;
}