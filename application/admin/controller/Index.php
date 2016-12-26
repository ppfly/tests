<?php
namespace app\admin\controller;

use think\controller;
use app\common\controller\Admin;

class Index extends Admin{
    public function index(){
        //dump($_SESSION);
        return $this->fetch();
    }
    public function login($username='',$password='',$code=''){
        if(IS_POST) {
            if(empty($username) && empty($password)){
                $this->error('用户名或密码不能为空');
            }
            $this->checkVerify($code);

            $user=model('User');
            if($user->login($username,$password)){
                $this->success('登陆成功','admin/index/index');
            }else{
                $this->error('用户名或密码错误');
            }

        }else{
            return $this->fetch();
        }
    }
    public function logout(){
        $user=model('User');
        $user->logout();
        $this->redirect('index/login');
    }
    public function info(){
        return $this->fetch();
    }
}

?>