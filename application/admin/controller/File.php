<?php
/**
 * Created by sunny.
 * User: sunny
 * For Darling
 * Date: 2016/9/30
 * Time: 14:27
 */
namespace app\admin\controller;


class File extends Base{
    public function upload(){
        if(IS_POST) {
            $info=model("File")->upload();
            print_r($info);die;
        }
        return $this->fetch();
    }
}