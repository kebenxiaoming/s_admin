<?php
/**
 * Created by sunny.
 * Tips:Have a nice day!
 * User: sunny
 * Date: 2016/7/18
 * Time: 15:06
 */
namespace app\admin\model;

use think\Model;
class UserGroup extends Model{

    public function getAllGroup(){
        $listobjarr=$this->select();
        if (!empty($listobjarr)) {
            foreach($listobjarr as $val){
                $list[]=$val->toArray();
            }
            if(!empty($list)) {
                return $list;
            }
        }
        return array ();
    }

    public function getGroupForOptions() {
        $group_list = $this->getAllGroup ();
        $group_options_array=array();
        foreach ( $group_list as $group ) {
            $group_options_array [$group ['group_id']] = $group ['group_name'];
        }

        return $group_options_array;
    }
}