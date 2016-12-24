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
        //$allTest3=input('alltest3/a');
        //output_data($allTest3);die;
        //$all=input($_POST/a);
        //output_data($_POST);die;
        if ($this->request->isPost()){
            header("Access-Control-Allow-Origin:*");
            //$row=input('rows/a');
            $allTest1=input('alltest1/a');
            $allTest2=input('alltest2/a');
            $allTest3=input('alltest3/a');

            $r1_data=[];
            if($allTest1['rows']){
                foreach ($allTest1['rows'] as $k => $v) {
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r1_data[]=$tmp;
                    }
                }
            }

            $r2_data=[];
            if($allTest2['rows']){
                foreach ($allTest2['rows'] as $k => $v){
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r2_data[]=$tmp;
                    }
                }
            }

            $r3_data=[];
            if($allTest3['rows']){
                foreach ($allTest3['rows'] as $k => $v){
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r3_data[]=$tmp;
                    }
                }
            }
            //output_data($r3_data);die;

            $all_ids=[];
            $allTest1_ids=[];
            foreach ($r1_data as $k => $v){
                $allTest1_ids[]=$v['id'];
            }
            $allTest2_ids=[];
            foreach ($r2_data as $k => $v){
                $allTest2_ids[]=$v['id'];
            }
            $allTest3_ids=[];
            foreach ($r3_data as $k => $v){
                $allTest3_ids[]=$v['id'];
            }


            $all_ids=array_merge($all_ids,$allTest1_ids);
            $all_ids=array_merge($all_ids,$allTest2_ids);
            $all_ids=array_merge($all_ids,$allTest3_ids);

            $all_ids_str=implode(',',$all_ids);

            $sql='select id,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result=Db::query($sql,[$all_ids_str,$all_ids_str]);


            //$userScore记录用户总分
            $userScore=0;
            $allTest1Score=0;
            $allTest2Score=0;
            $allTest3Score=0;
            foreach($result as $r_k => $r_v){
                foreach($r1_data as $k => $v){
                    if($r_v['id']==$v['id']){
                        if($r_v['answer']==$v['selected']) $allTest1Score=$allTest1Score+1;
                    }
                }
            }
            foreach($result as $r_k => $r_v){
                foreach($r2_data as $k => $v){
                    if($r_v['id']==$v['id']){
                        if($r_v['answer']==$v['selected']) $allTest2Score=$allTest2Score+1;
                    }
                }
            }
            foreach($result as $r_k => $r_v){
                foreach($r3_data as $k => $v){
                    $tmp_r=$r_v['answer'];
                    $tmp_s=$v['selected'];
                    if($r_v['id']==$v['id']){
                        $r=[];
                        for($i=0;$i<strlen($tmp_r);$i++){
                            $r[$i] = $tmp_r[$i];
                        }
                        $s=[];
                        for($i=0;$i<strlen($tmp_s);$i++){
                            $s[$i] = $tmp_s[$i];
                        }
                        $r=sort($r);
                        $s=sort($s);
                        //if(implode(',',$r)==implode(',',$s)) $allTest3Score=$allTest3Score+1;
                        if($r==$s) $allTest3Score=$allTest3Score+1;
                    }
                }
            }
            $userScore=$allTest1Score+$allTest2Score+$allTest3Score;

            $ot=['userScore'=>$userScore,'test1'=>$allTest1Score,'test2'=>$allTest2Score,'test3'=>$allTest3Score];
            output_data($ot);


        }
        //dump($r_ids);
    }
    public function execSQL(){
        //$data='{"A":"\u7b54\u6848\u9009\u9879A \u7b54\u6848\u9009\u9879A ","B":"\u7b54\u6848\u9009\u9879B \u7b54\u6848\u9009\u9879B ","C":"\u7b54\u6848\u9009\u9879C \u7b54\u6848\u9009\u9879C ","D":"\u7b54\u6848\u9009\u9879D \u7b54\u6848\u9009\u9879D "}';

        $sql="update t_tests set `answer`=? WHERE type='2'";
        Db::execute($sql,['C']);
        //{\"A\":\"\\u7b54\\u6848\\u9009\u9879A \u7b54\u6848\u9009\u9879A ","B":"\u7b54\u6848\u9009\u9879B \u7b54\u6848\u9009\u9879B ","C":"\u7b54\u6848\u9009\u9879C \u7b54\u6848\u9009\u9879C ","D":"\u7b54\u6848\u9009\u9879D \u7b54\u6848\u9009\u9879D
    }
}

?>