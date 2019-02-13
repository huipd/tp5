<?php 
namespace app\admin\model;
use think\Db;
use think\Model;
class Admins extends Model
{
	protected $table="admins";
	public function getZidAttr($value)
	{
    	$row = Db::table('jurisd')->select();
    	foreach ($row as $k => $v) {
    		$zid[$row[$k]['zid']] = $v['zname'];
    	}
		// $zid=[0=>'开启',1=>'禁用'];
		return $zid[$value];
	}
}


 ?>