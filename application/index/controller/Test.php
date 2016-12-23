<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function queryAllTest(){

        //if($this->request->isPost()){

            //随机从题库选出的id
            $lib_ids=Db::name('Lib')->column('id');
            $lib_rand_id=$lib_ids[rand(0,count($lib_ids)-1)];

            //查找判断题
            $sql='select `id`,`title` from t_tests tt where find_in_set(tt.id,(select test1_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test1_ids from t_lib where id=?))';
            //$result=Db::query($sql,[input('id'),input('id')]);
            $result1=Db::query($sql,[$lib_rand_id,$lib_rand_id]);
            //查找判断题结束

            //查找单选题开始
            $sql="select `id`,`type`,`title`,`option` from t_tests tt where find_in_set(tt.id,(select test2_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test2_ids from t_lib where id=?))";
            $result2=Db::query($sql,[$lib_rand_id,$lib_rand_id]);

            $result2_option=[];
            foreach($result2 as $k => $v){

                //$v=array_merge(json_decode($v['option'],true),['id'=>$v['id']]);
                $option_tmp=json_decode($v['option'],true);

                $option_tmp_element=[];
                foreach ($option_tmp as $ok => $ov){
                    //$ov=array_merge($ov,['id'=>$v['id']]);
                    $option_tmp_element['id']=$v['id'];
                    $option_tmp_element['option_element']=$ok.'.'.$ov;
                    $option_tmp_element['option_key']=$ok;
                    $result2_option[]=$option_tmp_element;
                }

                //$result2_option[]=$option_tmp_element;
            }
            //查找单选题结束


            //查找多选题开始
            $sql="select `id`,`type`,`title`,`option` from t_tests tt where find_in_set(tt.id,(select test3_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test3_ids from t_lib where id=?))";
            $result3=Db::query($sql,[$lib_rand_id,$lib_rand_id]);


            $result3_option=[];
            foreach($result3 as $k => $v){

                //$v=array_merge(json_decode($v['option'],true),['id'=>$v['id']]);
                $option_tmp=json_decode($v['option'],true);
                $option_tmp_element=[];
                foreach ($option_tmp as $ok => $ov){
                    //$ov=array_merge($ov,['id'=>$v['id']]);
                    $option_tmp_element['id']=$v['id'];
                    $option_tmp_element['option_element']=$ok.'.'.$ov;
                    $option_tmp_element['option_key']=$ok;
                    $result3_option[]=$option_tmp_element;
                }

                //$result2_option[]=$option_tmp_element;
            }
            //查找多选题结束




            $result['result1']=$result1;

            $result2_data=[];
            $result2_data['data']=$result2;
            $result2_data['option']=$result2_option;
            $result['result2']=$result2_data;

            $result3_data=[];
            $result3_data['data']=$result3;
            $result3_data['option']=$result3_option;
            $result['result3']=$result3_data;


            //dump($result);die;

            output_data($result);die;
        //}
    }
    public function queryAllTest2(){
        if($this->request->isPost()){
            $sql="select id,`type`,title,`option` from t_tests tt where find_in_set(tt.id,(select test2_ids from t_lib where id=?)) ORDER by find_in_set(tt.id,(select test2_ids from t_lib where id=?))";
            $result=Db::query($sql,[1,1]);
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
    public function execSQL(){
        $data='{"A":"\u7b54\u6848\u9009\u9879A \u7b54\u6848\u9009\u9879A ","B":"\u7b54\u6848\u9009\u9879B \u7b54\u6848\u9009\u9879B ","C":"\u7b54\u6848\u9009\u9879C \u7b54\u6848\u9009\u9879C ","D":"\u7b54\u6848\u9009\u9879D \u7b54\u6848\u9009\u9879D "}';
        $sql="update t_tests set `option`=? WHERE type='3'";
        Db::execute($sql,[$data]);
        //{\"A\":\"\\u7b54\\u6848\\u9009\u9879A \u7b54\u6848\u9009\u9879A ","B":"\u7b54\u6848\u9009\u9879B \u7b54\u6848\u9009\u9879B ","C":"\u7b54\u6848\u9009\u9879C \u7b54\u6848\u9009\u9879C ","D":"\u7b54\u6848\u9009\u9879D \u7b54\u6848\u9009\u9879D
    }
}

?>