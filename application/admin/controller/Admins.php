<?php
namespace app\admin\controller;
use think\Db;
use think\File;
// 别名处理同名
use app\admin\model\Admins as s;
class Admins extends Allow
{
    public function getsee()
    {
    	// 查看管理员列表
        // 获取所有数据
        $ss = s::select();
        return $this->fetch("Admins/see",['admins'=>$ss]);
    }
    // 添加管理员
    public function getadd()
    {
    	$row = Db::table('jurisd')->select();
        return $this->fetch("Admins/add",['zid'=>$row]);
    }
    // 执行添加
    public function postdofile()
    {
        // 接收值
		$data = input('post.');
        $file = request()->file('image');
        // 比对验证
		$results = $this->validate(request()->param(),'User');
        $result=$this->validate(['file1'=>$file],['file1'=>'require|image'],['file1.require'=>'上传头像不能为空','file1.image'=>'上传文件类型必须是图像类型']); 
        if(true !== $results){
            $this->error($results,"/admins/add");
        }elseif(true !==$result){
            $this->error($result,"/admins/add");
        }else{
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $data['cart'] = $info->getSaveName();
            $data['addtime']=time();
            unset($data['repwd']);
        }
        if(Db::table('admins')->insert($data)){
            $this->success("添加成功","/admins/see");
        }else{
            $this->error("添加失败","/admins/add");
        }
    }
     // 进入修改
    public function getedit(){
        $row = Db::table('jurisd')->select();
        $request=request();
        $id=$request->param('id');
        $user=Db::table('admins')->where("id","{$id}")->find();
        return $this->fetch("Admins/edit",['zid'=>$row,'admins'=>$user]);
    }
    // 执行修改
    public function postupdate(){
       // 接收值
        $data = input('post.');
        $file = request()->file('image');
        // 比对验证
        $results = $this->validate(request()->param(),'User');
        $result=$this->validate(['file1'=>$file],['file1'=>'image'],['file1.image'=>'上传文件类型必须是图像类型']);
        // 已存在的头像地址
        $cart = ROOT_PATH . 'public' . DS . 'uploads'. DS .$data['cart'];
        if(true !== $results){
            $this->error($results,"/admins/edit/id/{$data['id']}");
        }elseif(true !==$result){
            $this->error($result,"/admins/edit/id/{$data['id']}");
        }elseif($file){
            // 判断头像文件是否存在
            if (file_exists($cart)) {
                unlink($cart);
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $data['cart'] = $info->getSaveName();
                unset($data['repwd']);
            }else{
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $data['cart'] = $info->getSaveName();
                unset($data['repwd']);
            } 
        }else{
            unset($data['repwd']);
            unset($data['cart']);
        }
        if(Db::table('admins')->where('id',$data['id'])->update($data)){
            $this->success("修改成功","/admin/index");
        }else{
            $this->error("对不起您还未修改值","/admins/edit/id/{$data['id']}");
        }
    }
    // 执行删除操作
    public function getdelete(){
        $request=request();
        $id=$request->param('id');
        $cart = Db::table('admins')->where('id',$id)->value('cart');
        $carturl = ROOT_PATH . 'public' . DS . 'uploads'. DS .$cart;
        if (file_exists($carturl)) {
            unlink($carturl);
            if (Db::table('admins')->where("id",$id)->delete()) {
                $this->success("数据删除成功","/admins/see");
            }else{
                $this->error("数据删除失败","/admins/see");
            }
        }else{
            $this->error("原头像不存在,请修正后在删","/admins/see");
        }
    }
    // 加载个人中心修改密码页面
    public function getmod(){
        return $this->fetch("Admins/mod");
    }
     // 个人中心修改密码
    public function postdomod(){
        $data = input('post.');
        $admins1 = Db::table('admins')->where("aname",$data['aname'])->find();
        if($data['pwd'] == $admins1['pwds'] && $data['pwds'] == $data['repwd']){
            $result=$this->validate(['pwds'=>$data['pwds']],['pwds'=>'regex:\w{6,10}'],['pwds.regex'=>'新密码格式有误']);
            if(true !== $result){
                $this->error($result,"/admins/mod");
            }elseif(Db::table('admins')->where("aname",$data['aname'])->update(['pwds'=>$data['pwds']])){
                $this->success("数据修改成功","/admin/index");
            }else{
                $this->error("密码和原密码一样","/admins/mod");
            }
        }else{
            $this->error("原密码输入错误,或者两次密码不一致","/admins/mod");
        }
    }
}
