<?php
namespace app\admin\controller;
use think\Db;
class Index extends Allow
{
    public function getindex()
    {
    	// 加载后台首页模板
        return $this->fetch("Admin/index");
    }
    public function getusers()
    {
    	// 加载用户列表
    	return $this->fetch("Users/users");
    }
}
