<?php
namespace app\common\controller;

class Admin extends Base{
    public function _initialize(){
        parent::_initialize();
        define('IS_ADMINISTRATOR',is_administrator());
        if (!IS_ADMINISTRATOR && !in_array($this->url,['admin/index/verify','admin/index/logout','admin/index/login'])){
            $this->redirect('admin/index/login');
        }

    }
}

?>