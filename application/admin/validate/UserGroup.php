<?php
/**
 * Created by sunny.
 * User: sunny
 * Have a nice day!
 * Date: 2016/12/19
 * Time: 9:07
 */
namespace app\admin\validate;
use think\Validate;
class UserGroup extends Validate
{
    protected $rule = [
        'group_name'  =>  'require|max:25',
        'group_desc' =>  'require',
    ];

    protected $message = [
        'group_name.require'  =>  '组名必须',
        'group_desc.require' =>  '组描述也必须',
    ];

    protected $scene = [
        'add'   =>  ['group_name','group_desc'],
        'edit'  =>  ['group_name','group_desc'],
    ];
}