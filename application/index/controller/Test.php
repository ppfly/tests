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
            $sql='select `id`,`title` from t_tests tt where find_in_set(tt.id,(select test1_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test1_ids from t_lib where id=?))';
            //$result=Db::query($sql,[input('id'),input('id')]);
            $result=Db::query($sql,[1,1]);
            //$result=Db::queryDataToTable($sql,[input('id'),input('id')]);
            output_data($result);die;
        }
    }
    public function queryAllTest2(){
        if($this->request->isPost()){
            $sql="select id,`type`,title,`option` from t_tests tt where find_in_set(tt.id,(select test2_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test2_ids from t_lib where id=?))";
            $result=Db::query($sql,[2,2]);
            //$result=Db::queryDataToTable($sql,[input('id'),input('id')]);
            output_data($result);die;
        }
    }

    public function completedTest(){
        //output_data($_POST);
        if ($this->request->isPost()){
            header("Access-Control-Allow-Origin:*");
            $row=input('rows/a');

            //存入用户答题的信息
            $r_data=[];
            /*
             * Wex5 data组件toJson方法返回的值，如果radio没有被点击过，data组件的选择标示列['checked'] 下没有['value']而是存在['originalValue']
             * */
            foreach ($row as $k => $v){
                //echo $v['title']['value'].'<br/>';
                $tmp=[];
                $tmp['id']=$v['userdata']['id']['value'];
                //需要判断是否存在['checked']，否则会报找不到索引错误
                if(array_key_exists('value',$v['checked'])){
                    $tmp['checked']=$v['checked']['value'];
                }
                $r_data[]=$tmp;
            }

            //准备查寻sql的id们
            $r_ids=[];
            foreach ($r_data as $k => $v){
                $r_ids[]=$v['id'];
            }
            $str_ids=implode(',',$r_ids);
            //echo $str_ids;

            $sql='select id,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result=Db::query($sql,[$str_ids,$str_ids]);

            //$userScore记录用户总分
            $userScore=0;
            foreach($result as $r_k => $r_v){
                foreach($r_data as $k => $v){
                    if($r_v['id']==$v['id']){
                        if(array_key_exists('checked',$v) && $r_v['answer']==$v['checked'] ) $userScore=$userScore+1;
                    }
                }
            }
            $ot=['userScore'=>$userScore];
            echo json_encode($ot);
        }
        //dump($r_ids);
    }
}

?>