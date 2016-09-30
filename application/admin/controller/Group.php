<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 14:47
 */
namespace app\admin\controller;


class Group extends Base{
    //分组列表管理
    public function index(){
        $listrows=config("LISTROWS")?config("LISTROWS"):10;

        $groupsobj=model("UserGroup")->paginate($listrows);
        $groups=$groupsobj->toArray()['data'];
        foreach($groups as $k=>$v){
            $user=model("User")->find($v['owner_id']);
            $groups[$k]['owner_name']=$user->toArray()['user_name'];
        }
        $this->assign("groups",$groups);
        $this->assign("page_html",$groupsobj->render());
        $acjs=renderJsConfirm("icon-remove");
        $this->assign("action_confirm",$acjs);
        return $this->fetch();
    }

    public function edit($group_id){
        $group_id=intval($group_id);
        $groupobj=model("UserGroup")->where("group_id=".$group_id)->find();
        $group=$groupobj->toArray();
        if(empty($group)){
            $this->error("不存在该用户组！",url("Group/edit",array("group_id"=>$group_id)));die;
        }

        if (IS_POST) {
            $group_name=strval(input('post.group_name'));
            if($group_name =="" ){
                $this->error("缺少参数！",url("Group/edit",array("group_id"=>$group_id)));die;
            }else{
                $data=input("post.");
                $data['group_id']=$group_id;
                $result = model("UserGroup")->isUpdate(true)->save($data);

                if ($result>=0) {
                    Adminlog(session("user")['user_name'],"MODIFY" , "UserGroup",$group_id ,json_encode($data) );
                    $this->success( '账号组修改完成',url("Group/index"));die;
                } else {
                    $this->error( '修改过程出现错误！',url("Group/index"));die;
                }
            }
        }

        $groupOptions=model("UserGroup")->getGroupForOptions();
        $this->assign ( 'group', $group );
        $this->assign ( 'groupOptions', $groupOptions );
        return $this->fetch();
    }

    public function del($group_id){
        //先查看该分类下是否存在用户，存在则提醒删除用户再删除分组
        $usersobj=model("User")->where("user_group",$group_id)->find();
        if(!empty($usersobj)) {
            $users = $usersobj->toArray();
        }
        if(!empty($users)){
            $this->error("请先删除该分组下用户，才允许删除分组！",url("Group/index"));die;
        }
        $result=model("UserGroup")->where("group_id=".$group_id)->delete();
        if($result){
            $this->success("删除成功！",url("Group/index"));die;
        }else{
            $this->error("删除失败！",url("Group/index"));die;
        }
    }

    //权限管理
    public function group_role($group_id=1){
        $menu_ids=array();
        $group_option_list = model("GroupRole")->getGroupForOptions ();
        $group_infoobj = model("UserGroup")->where("group_id=".$group_id)->find();
        $group_info=array();
        if(!empty($group_infoobj)){
            $group_info=$group_infoobj->toArray();
        }
        if(!$group_info){
            $group_id =1;
            $group_infoobj =  model("UserGroup")->where("group_id=".$group_id)->find();
            if(!empty($group_infoobj)){
                $group_info=$group_infoobj->toArray();
            }
        }
        $role_list = model("GroupRole")->getGroupRoles ( $group_id );
        $group_role = $group_info ['group_role'];
        $group_role_array = explode ( ',', $group_role );

        if (IS_POST) {
            $menu_ids=$_POST['menu_ids'];
            if($group_id==1){
                $temp = array();
                foreach ($group_role_array as $group_role){

                    if($group_role>100){
                        $temp[]=$group_role;
                    }
                }

                $admin_role = array_diff($group_role_array,$temp);

                $menu_ids = array_merge($admin_role,$menu_ids);
                $menu_ids = array_unique($menu_ids);
                asort($menu_ids);
            }
            $group_role = join ( ',', $menu_ids );
            $group_data = array ("group_id"=>$group_id,'group_role' => $group_role );
            $result = model("UserGroup")->isUpdate(true)->save($group_data );
            if ($result>=0) {
                Adminlog(session("user")['user_name'], 'MODIFY', 'UserGroup' ,$group_id, json_encode($group_data) );
                //如果属于当前用户的用户组，则必须重新给当前用户菜单权限
                model("User")->reload();
                $this->success("修改权限成功！",url("Group/group_role"));die;
            }else{
                $this->success("修改权限失败！",url("Group/rgoup_role"));die;
            }
        }
        $this->assign ( 'role_list', $role_list );
        $this->assign ( 'group_id', $group_id );
        $this->assign ( 'group_option_list', $group_option_list );
        $this->assign ( 'group_role', $group_role_array );
        return $this->fetch();
    }

    public function add(){
        if (IS_POST) {
            $group_name=input("post.group_name");
            if($group_name =="" ){
                $this->error("缺少参数！");die;
            }else{
                $group_desc=input("post.group_desc");
                $data['group_name']=$group_name;
                $data['group_desc']=$group_desc;
                $data['group_role']="1,5,17,18,22,23,24,25";
                $data['owner_id']=session("user")['user_id'];
                $result = model("UserGroup")->save($data);
                if ($result>=0) {
                    Adminlog(session("user")['user_name'],"ADD" , "UserGroup",$result ,json_encode($data) );
                    $this->success( '新增账号组成功',url("Group/index"));die;
                } else {
                    $this->error( '新增账号组出错！',url("Group/index"));die;
                }
            }
        }

        return $this->fetch();
    }
}