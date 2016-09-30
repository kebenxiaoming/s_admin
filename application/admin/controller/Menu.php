<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 16:38
 */
namespace app\admin\controller;

class Menu extends Base{
    public function index(){
        $listrows=config("LISTROWS")?config("LISTROWS"):10;
        $menus=model("MenuUrl")->paginate($listrows);
        $this->assign("menus",$menus->toArray()['data']);
        $this->assign("page_html",$menus->render());

        $module_options_list = model("Module")->getModuleForOptions ();
        $module_options_list[0]="全部";
        ksort($module_options_list);
        $this->assign("module_options_list",$module_options_list);

        $acjs=renderJsConfirm("icon-remove");
        $this->assign("action_confirm",$acjs);
        return $this->fetch();
    }

    /**
     * 添加菜单
     */
    public function add(){
        if(IS_POST) {
            $menu = model("MenuUrl");
            $data =input("post.");
            $res = $menu->save($data);
            if ($res) {
                Adminlog(session("user")['user_name'],"ADD" , "MenuUrl",$res ,json_encode($data) );
                $this->success("添加成功！", url("Menu/index"));
                die;
            } else {
                $this->error("添加失败！", url("Menu/index"));
                die;
            }
        }else{
            $module_options_list = model("Module")->getModuleForOptions ();
            $this->assign("module_options_list",$module_options_list);
            $father_menu_options_list = model("MenuUrl")->getFatherMenuForOptions ();
            $this->assign("father_menu_options_list",$father_menu_options_list);
            return $this->fetch();
        }
    }

    /**
     * 编辑菜单
     */
    public function edit(){
        $menuurl=model("MenuUrl");
        if(IS_POST) {
            $data = input("post.");
            $data['menu_id']=intval(input("param.menu_id"));
            $res = $menuurl->isUpdate(true)->save($data);
            if ($res>=0) {
                Adminlog(session("user")['user_name'],"MODIFY" , "MenuUrl", $data['menu_id'] ,json_encode($data) );
                $this->success("修改成功！", url("Menu/index"));
                die;
            } else {
                $this->error("修改失败！", url("Menu/index"));die;
            }
        }else{
            $menu_id=intval(input("param.menu_id"));
            $menuobj=$menuurl->find($menu_id);
            $menu=array();
            if(!empty($menuobj)){
                $menu=$menuobj->toArray();
            }else{
                $this->error("未获取到菜单信息！");
            }
            $this->assign("currentmenu",$menu);
            $module_options_list = model("Module")->getModuleForOptions ();
            $this->assign("module_options_list",$module_options_list);
            $father_menu_options_list = model("MenuUrl")->getFatherMenuForOptions ();
            $this->assign("father_menu_options_list",$father_menu_options_list);
            return $this->fetch();
        }
    }

    /**
     * 编辑菜单
     */
    public function del(){
        $data['menu_id']=intval(input('param.menu_id'));
        //先查找是否存在
        $menu=model("MenuUrl")->where($data)->find();
        if(empty($menu)){
            $this->error("不存在该菜单！");die;
        }
        $res = model("MenuUrl")->where($data)->delete();
        if ($res) {
            Adminlog(session("user")['user_name'],"DEL" , "MenuUrl",$data['menu_id'] ,json_encode($menu) );
            $this->success("删除成功！", url("Menu/index"));
            die;
        } else {
            $this->error("删除失败！", url("Menu/index"));die;
        }
    }
}