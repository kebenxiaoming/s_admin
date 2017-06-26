<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 15:02
 */
namespace app\admin\model;

use think\Model;
class GroupRole extends Model{
    
    Protected $autoCheckFields = false;

    public function getGroupRoles($group_id) {
        if (! $group_id || ! is_numeric ( $group_id )) {
            return false;
        }
        $data = model("Module")->getAllModules (1);
        //用户组的权限
        foreach ( $data as $k => $module ) {
            $list = model("MenuUrl")->getListByModuleId ($module ['module_id'] ,"role");
            foreach ( $list as $menu ) {
                $data [$k] ['menu_info'][$menu ['menu_id']] = $menu ['menu_name'];
            }
        }

        return $data;
    }

    public function getGroupForOptions() {
        $group_list = model("UserGroup")->getAllGroup ();
        $group_options_array=array();
        foreach ( $group_list as $group ) {
            $group_options_array [$group ['group_id']] = $group ['group_name'];
        }

        return $group_options_array;
    }
}