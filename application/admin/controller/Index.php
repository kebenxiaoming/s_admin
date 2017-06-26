<?php
namespace app\admin\controller;

class Index extends Base
{
    public function index(){
        // 模板输出
        return $this->fetch('index');
    }


}
