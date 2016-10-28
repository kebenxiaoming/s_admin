<?php
/**
 * Created by sunny.
 * User: sunny
 * For Darling
 * Date: 2016/10/21
 * Time: 17:41
 */
namespace app\admin\model;
use think\Model;

class File extends model{
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $data['ext']=$info->getExtension();
            $data['name']=$file->getInfo()['name'];
            $data['savepath']= $info->getSaveName();
            $data['savename']=$info->getFilename();
            $data['mime']=$file->getMime();
            $data['size']=$info->getSize();
            $data['create_time']=$info->getMTime();
            $data['location']=$info->getPathname();
            $data['md5']=$info->hash("md5");
            $data['sha1']=$info->hash("sha1");
            //查看是否已经存在该文件
            if($old=$this->isExist($data)){
                return array("error"=>0,"info"=>$old);
            }
            if($id=$this->save($data)){
                $data['id']=$id;
                return array("error"=>0,"info"=>$data);
            }else{
                return array("error"=>1,"info"=>"上传保存失败！");
            }
        }else{
            // 上传失败获取错误信息
            return array("error"=>1,"info"=>$file->getError());
        }
    }

    //判断文件是否已经存在
    private function isExist($data){
        $where['md5']=$data['md5'];
        $where['sha1']=$data['sha1'];
        if($old=$this->where($where)->find()){
            return $old->toArray();
        }else{
            return false;
        }
    }
}