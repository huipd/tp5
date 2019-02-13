<?php 
namespace app\index\widget;
use think\Controller;
use think\Db;
class Cate extends Controller
{
	// 加载公共头部模板
	public function header()
	{
		return $this->fetch("Cate:header");
	}
	// 加载公共尾部模板
	public function footer()
	{
		return $this->fetch("Cate:footer");
	}
}


 ?>