<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 11:53
 */
namespace app\admin\controller;

use think\Request;
class User extends Base{
    public function index(){
        $listrows=config("LISTROWS")?config("LISTROWS"):10;
        $user_infos=model("User")->paginate($listrows);
        $userlists=$user_infos->toArray()['data'];
        foreach ($userlists as $k=>$v){
            $userlists[$k]['group_name']=getGroupName($v['user_group']);
        }
        $this->assign("user_infos",$userlists);
        $this->assign("page_html",$user_infos->render());

        $acjs=renderJsConfirm("icon-remove");
        $this->assign("action_confirm",$acjs);
        return $this->fetch();
    }

    public function showGroup($group_id){
        $listrows=config("LISTROWS")?config("LISTROWS"):10;
        $user_infos=model("User")->where("user_group",$group_id)->paginate($listrows);
        if(!empty($user_infos)){
            $this->assign("user_infos",$user_infos->toArray()['data']);
            $this->assign("page_html",$user_infos->render());
        }
        return $this->fetch();
    }

    public function add(){
        if(IS_POST) {
            $user = model("User");
            $data =input("post.");
            //判断邮箱格式
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if(!preg_match($pattern,$data['email'] )){
                $this->error("邮箱格式不正确，请重新输入！");
            }
            //判断手机号格式
            if(!preg_match("/^0{0,1}(13[0-9]|15[7-9]|153|17[0-9]|156|18[0-9])[0-9]{8}$/",$data['mobile'])){
                $this->error("手机号格式不正确，请重新输入！");
            }
            $data['password']=md5($data['password']);
            $res = $user->save($data);
            if ($res) {
                Adminlog(session("user")['user_name'],"ADD" , "User",$res ,json_encode($data) );
                $this->success("添加成功！", url("User/index"));
                die;
            } else {
                $this->error("添加失败！", url("User/index"));
                die;
            }
        }else{
            $group_option_list = model("GroupRole")->getGroupForOptions ();
            $this->assign ( 'group_option_list', $group_option_list );
            return $this->fetch();
        }
    }

    public function edit(){
        if(IS_POST) {
            $user = model("User");
            $data =input("post.");
            //判断邮箱格式
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if(!preg_match($pattern,$data['email'] )){
                $this->error("邮箱格式不正确，请重新输入！");
            }
            //判断手机号格式
            if(!preg_match("/^0{0,1}(13[0-9]|15[7-9]|153|17[0-9]|156|18[0-9])[0-9]{8}$/",$data['mobile'])){
                $this->error("手机号格式不正确，请重新输入！");
            }
            if(!empty($data['password'])) {
                $data['password'] = md5($data['password']);
            }else{
                unset($data['password']);
            }
            $res = $user->isUpdate(true)->save($data);
            if ($res) {
                Adminlog(session("user")['user_name'],"MODIFY" , "User",$res ,json_encode($data) );
                $this->success("修改成功！", url("User/index"));
                die;
            } else {
                $this->error("修改失败！", url("User/index"));
                die;
            }
        }else{
            $user_id=input("param.user_id");
            if(empty($user_id)){
                $this->error("未获取到用户id");die;
            }
            $user=model("User")->find($user_id);
            if($user){
                $userinfo=$user->toArray();
            }else{
                $this->error("未获取到用户信息！");die;
            }
            $this->assign("user",$userinfo);
            $group_option_list = model("GroupRole")->getGroupForOptions ();
            $this->assign ( 'group_option_list', $group_option_list );
            return $this->fetch();
        }
    }
    //删除
    public function del(){
        $data['user_id']=intval(input('param.user_id'));
        if($data['user_id']==1){
            $this->error("禁止删除初始管理员！");die;
        }
        //先查找是否存在
        $user=model("User")->where($data)->find();
        if(empty($user)){
            $this->error("不存在该用户！");die;
        }
        $res = model("User")->where($data)->delete();
        if ($res) {
            Adminlog(session("user")['user_name'],"DEL" , "User",$data['user_id'] ,json_encode($user) );
            $this->success("删除成功！", url("User/index"));
            die;
        } else {
            $this->error("删除失败！", url("User/index"));die;
        }
    }
}