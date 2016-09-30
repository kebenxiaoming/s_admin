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
}