<?php
// +----------------------------------------------------------------------
// | 强制路由管理
// +----------------------------------------------------------------------
use think\Route;
// 加载前台首页
Route::get('/','index/Index/getindex');
// 登陆注册
Route::controller('/pass','index/index');
// 加载后台登陆模板
Route::controller('/adminlogin','admin/Login');
Route::controller('/admin','admin/Index');
Route::controller('/admins','admin/Admins');