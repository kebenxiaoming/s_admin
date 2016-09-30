<?php
/**
 * Created by sunny.
 * User: sunny
 * Be better
 * Date: 2016/9/26
 * Time: 14:05
 */
namespace app\home\controller;

class Index
{
    public function index()
    {
        return "aaa";
//        // 实例化视图类
//        $view = new View();
//        // 渲染模板输出 并赋值模板变量
//        return $view->fetch('index',['name'=>'thinkphp']);
    }

    public function hello($name)
    {
        return 'Hello,'.$name;
    }
}
