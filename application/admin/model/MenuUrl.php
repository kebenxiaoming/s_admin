<?php
/**
 * Created by sunny.
 * User: sunny
 * For Darling
 * Date: 2016/9/28
 * Time: 13:34
 */
namespace app\admin\model;

use think\Model;

class MenuUrl extends Model
{
    //获取当前用户所有的菜单
    public function getTrees(){
        $user_info = session("user");
        //功能菜单
        $data = array ();
        $data = model("Module")->getAllModules(1);
        //用户的权限
        $access = $this->getMenuByRole ( $user_info ['user_role'] );
        foreach ( $data as $k => $module ) {
            $list = $this->getlistByModuleId ($module ['module_id'],'sidebar' );
            if (! $list) {
                unset ( $data [$k] );
                continue;
            }
            //去除无权限访问的
            foreach ( $list as $key => $value ) {
                if (! in_array ( $value ['menu_id'], $access )) {
                    unset ( $list [$key] );
                }
            }
            $data [$k] ['menu_list'] = $list;
        }
        return $data;
    }

    //根据角色获取权限
    public function getMenuByRole($user_role,$online=1){
        $url_array = array();

        $sql = "select * from " .config('database.prefix'). "menu_url me," . config('database.prefix') . "module mo where me.menu_id in ($user_role) and me.online = $online and me.module_id = mo.module_id and mo.online = 1";

        $list=$this->db() ->query($sql);

        if ($list) {
            foreach ($list as $menu_info) {
                $url_array[] = $menu_info['menu_id'];
            }
            return $url_array;
        }
        return array();
    }

    public function getListByModuleId($module_id, $type = "all")
    {
        if (!$module_id || !is_numeric($module_id)) {
            return array();
        }
        switch ($type) {
            case "sidebar":
                $sub_condition["is_show"] = 1;
                $sub_condition["online"] = 1;
                break;
            case "role":
                $sub_condition["online"] = 1;
                break;
            case "navibar":
                $sub_condition["is_show"] = 1;
                $sub_condition["online"] = 1;
                break;
            // default:
        }
        $sub_condition["module_id"] = $module_id;
        $order="sort DESC";
        $listobjarr=$this->where($sub_condition)->order($order)->select();
        if(!empty($listobjarr)) {
            foreach ($listobjarr as $val) {
                $list[] = $val->toArray();
            }
            if ($list) return $list;
        }
        return array();
    }

    public function getMenuByUrl($url)
    {
        $condition = array("menu_url" => $url);

        $listobj = $this->where($condition)->find();
        $list="";
        if(!empty($listobj)){
            $list=$listobj->toArray();
        }
        if ($list) {
            $menu = $list;
            $moduleobj = model("Module")->where("module_id=".$menu['module_id'])->find();
            $module=$moduleobj->toArray();
            $menu['module_id'] = $module['module_id'];
            $menu['module_name'] = $module['module_name'];
            $menu['module_url'] = $module['module_url'];
            if ($menu['father_menu'] > 0) {
                $father_menuobj = $this->where("menu_id=".$menu['father_menu'])->find();
                $father_menu=$father_menuobj->toArray();
                $menu['father_menu_url'] = $father_menu['menu_url'];
                $menu['father_menu_name'] = $father_menu['menu_name'];
            }
            return $menu;
        }
        return array();
    }

    public function getFatherMenuForOptions()
    {
        $menu_options_array = array("0" => "无");
        $modules = model("Module")->getAllModules();
        foreach ($modules as $module) {
            $list = $this->getListByModuleId($module['module_id'], 'navibar');
            foreach ($list as $menu) {
                $menu_options_array[$module['module_name']][$menu['menu_id']] = $menu['menu_name'];
            }
        }
        return $menu_options_array;
    }
}