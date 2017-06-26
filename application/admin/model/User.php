<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 9:59
 */
namespace app\admin\model;

use think\Model;
class User extends Model{

    protected $pk = 'user_id';
    //检测用户
    public function  login($username,$password){
        $where=array(
            "user_name"=>$username,
        );
        $userdata=$this->where($where)->find();
        $userdata=$userdata->data;
        if($userdata){
            if($userdata['password']==md5($password)){
                //更新登录信息
                $userdata['login_time']=time();
                $userdata['login_ip']=getIp();
                $this->update($userdata);
                $data=array("group_id"=>$userdata['user_group']);
                $user_groupobj = model("UserGroup")->where($data)->find();
                $user_group=$user_groupobj->toArray();
                $userdata['user_group']=$user_group['group_id'];
                $userdata['user_role']=$user_group['group_role'];
                session("user",$userdata);
                return true;
            }
        }
        return false;
    }
    //自动登录
    public function autoLogin($user_id){
        if($user_id){
            $data=array("user_id"=>$user_id);
            $userob=$this->where($data)->find();
            $user=$userob->toArray();
            if(!empty($user)){

                //更新登录信息
                $user['login_time']=time();
                $user['login_ip']=getIp();
                $this->update($user);

                $data=array("group_id"=>$user['user_group']);
                $user_group = model("UserGroup")->where($data)->find();
                $user['group_id']=$user_group['group_id'];
                $user['user_role']=$user_group['group_role'];
                session("user",$user);
            }
        }
    }
    //重新登录一下
    public function reload(){
        $userob=$this->where("user_id",session("user")['user_id'])->find();
        $user=$userob;
        if($user){
                $data=array("group_id"=>$user['user_group']);
                $user_groupob = model("UserGroup")->where($data)->find();
                $user_group=$user_groupob->toArray();
                $user['group_id']=$user_group['group_id'];
                $user['user_role']=$user_group['group_role'];
                session("user",$user);
                return true;
        }
        return false;
    }
}