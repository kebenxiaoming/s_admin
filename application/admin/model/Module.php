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
class Module extends Model{
    //列表
    public function getAllModules($is_online=null) {
        $condition=array();
        if(isset($is_online)){
            $condition=array("online"=>$is_online);
        }
        $order = ' module_sort asc,module_id asc';
        $listobjarr=$this->where($condition)->order($order)->select();
        if(!empty($listobjarr)) {
            foreach ($listobjarr as $val) {
                $list[] = $val->toArray();
            }
            if (!empty($list)) {
                return $list;
            }else{
                return array();
            }
        }
        return array ();
    }

    public function getModuleForOptions() {
        $module_options_array = array ();
        $module_list = $this->getAllModules (1);

        foreach ( $module_list as $module ) {
            $module_options_array [$module ['module_id']] = $module ['module_name'];
        }

        return $module_options_array;
    }
}