<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function queryAllTest1(){
        if($this->request->isPost()){
            $sql='select id,title from t_tests tt where find_in_set(tt.id,(select test1_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test1_ids from t_lib where id=?))';
            //$result=Db::query($sql,[input('id'),input('id')]);
            $result=Db::queryDataToTable($sql,[input('id'),input('id')]);
            output_data($result);die;
        }
    }
}

?>