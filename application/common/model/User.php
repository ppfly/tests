<?php
namespace app\common\model;
use think\Model;

class User extends Model{

    public function login($username,$password){
        if(empty($username)) return 0;
        $map=[
            'username'=>$username,
        ];

        $user=$this->db()->where($map)->find()->toArray();
        if($user['password']==md5($password) && $user['is_admin']==config('user_administrator')){
            $this->loginHandler($user);
            return $user['id'];
        }else{
            return 0;
        }

    }
    public function loginHandler($user){
        $data=[
            'id'=>$user['id'],
            'username'=>$user['username'],
            'last_login_time'=>time(),
        ];
        $this->where(['id'=>$user['id']])->update($data);
        session('user_auth',$data);
        session('user_auth_sign',data_auth_sign($data));
    }

    public function logout(){
        session('user_auth',null);
        session('user_auth_sign',null);
    }
}

?>