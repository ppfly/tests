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
                if(is_array($option_tmp) && !empty($option_tmp)) {
                    foreach ($option_tmp as $ok => $ov) {
                        //$ov=array_merge($ov,['id'=>$v['id']]);
                        $option_tmp_element['id'] = $v['id'];
                        $option_tmp_element['option_element'] = $ok . '.' . $ov;
                        $option_tmp_element['option_key'] = $ok;
                        $result2_option[] = $option_tmp_element;
                    }
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
                if(is_array($option_tmp) && !empty($option_tmp)) {
                    foreach ($option_tmp as $ok => $ov) {
                        //$ov=array_merge($ov,['id'=>$v['id']]);
                        $option_tmp_element['id'] = $v['id'];
                        $option_tmp_element['option_element'] = $ok . '.' . $ov;
                        $option_tmp_element['option_key'] = $ok;
                        $result3_option[] = $option_tmp_element;
                    }
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
            //分别获取三种题型交卷上来的id,和选择项
            $allTest1=input('alltest1/a');
            $allTest2=input('alltest2/a');
            $allTest3=input('alltest3/a');
            //output_data($allTest1);die;
            //分别得到每种题型答过题的id和选择项
            $r1_data=[];
            $r1_noSelected=[];//未选择的判断题ID
            if($allTest1['rows']){
                foreach ($allTest1['rows'] as $k => $v) {
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r1_data[]=$tmp;
                    }else{//获得未做选择的判断题id 存用$1_noSelected
                        $r1_noSelected[]=$v['userdata']['id']['value'];
                    }
                }
            }

            $r2_data=[];
            $r2_noSelected=[];//未选择的单选题ID
            if($allTest2['rows']){
                foreach ($allTest2['rows'] as $k => $v){
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r2_data[]=$tmp;
                    }else{//获得未做选择的单选题id 存用$2_noSelected
                        $r2_noSelected[]=$v['userdata']['id']['value'];
                    }
                }
            }

            $r3_data=[];
            $r3_noSelected=[];//未选择的多选题ID
            if($allTest3['rows']){
                foreach ($allTest3['rows'] as $k => $v){
                    $tmp=[];
                    if($v['checked']['changed']=='1'){
                        $tmp['id']=$v['userdata']['id']['value'];
                        $tmp['selected']=$v['checked']['value'];

                        $r3_data[]=$tmp;
                    }else{//获得未做选择的多选题id 存用$3_noSelected
                        $r3_noSelected[]=$v['userdata']['id']['value'];
                    }
                }
            }
            //output_data($r3_noSelected);die;

            //取出所有答过的题的id，并组成用逗号分隔的字符串
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

            //从数据库中取出答过的题的正确答案
            $sql='select id,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result=Db::query($sql,[$all_ids_str,$all_ids_str]);


            //$userScore记录用户总分
            //判断每种题型各答对的分数，并求出总分
            $userScore=0;
            $allTest1Score=0;
            $allTest2Score=0;
            $allTest3Score=0;
            $r1_wrongSelect=[];//选择错误的判断题
            foreach($result as $r_k => $r_v){
                foreach($r1_data as $k => $v){
                    if($r_v['id']==$v['id']){
                        $tmp_wrongSelect=[];
                        if($r_v['answer']==$v['selected']) {
                            $allTest1Score=$allTest1Score+1;
                        }else{//把答错的判断题ID存入$r1_wrongSelected
                            $r1_wrongSelect[]=$v['id'];
                        }
                    }
                }
            }

            $r2_wrongSelect=[];//选择错误的单选题
            foreach($result as $r_k => $r_v){
                foreach($r2_data as $k => $v){
                    if($r_v['id']==$v['id']){
                        $tmp_wrongSelect=[];
                        if($r_v['answer']==$v['selected']) $allTest2Score=$allTest2Score+1;
                    }else{//把答错的单选题ID存入$r2_wrongSelected
                        $r2_wrongSelect[]=$v['id'];
                    }
                }
            }
            $r3_wrongSelect=[];//选择错误的多选题
            foreach($result as $r_k => $r_v){
                foreach($r3_data as $k => $v){
                    $tmp_r=$r_v['answer'];
                    $tmp_s=$v['selected'];
                    if($r_v['id']==$v['id']){
                        //重新按降序排序交卷上传和数据库中标准答案的多选答案，并进行对比
                        $tmp_wrongSelect=[];
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
                        if($r==$s) {
                            $allTest3Score=$allTest3Score+1;
                        }else{//把答错的多选题ID存入$r2_wrongSelected
                            $r3_wrongSelect[]=$v['id'];

                        }
                    }
                }
            }
            $userScore=$allTest1Score+$allTest2Score+$allTest3Score;

            //把每种题型的未选和答错的ID数组合并,并从数据库中分别查询出来，合并到返回给前台的数组中
            $r1_wrongSelect=array_merge($r1_wrongSelect,$r1_noSelected);
            $r2_wrongSelect=array_merge($r2_wrongSelect,$r2_noSelected);
            $r3_wrongSelect=array_merge($r3_wrongSelect,$r3_noSelected);
            $r1_wrongSelect_str=implode(',',$r1_wrongSelect);
            $r2_wrongSelect_str=implode(',',$r2_wrongSelect);
            $r3_wrongSelect_str=implode(',',$r3_wrongSelect);

            $sql1='select id,title,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result1=Db::query($sql1,[$r1_wrongSelect_str,$r1_wrongSelect_str]);
            $sql2='select id,title,`option`,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result2=Db::query($sql2,[$r2_wrongSelect_str,$r2_wrongSelect_str]);
            $sql3='select id,title,`option`,answer from t_tests tt where find_in_set(tt.id,?) order by find_in_set(tt.id,?)';
            $result3=Db::query($sql3,[$r3_wrongSelect_str,$r3_wrongSelect_str]);

            //这里没写完，要继续把option单独取出存起来，方便前台再读取到data组件中，并组合到返回给前台的数组中
            //把单、多选的选项和所属ID单独放在数组中保存
            $result2_option=[];
            foreach($result2 as $k =>$v){
                $option_tmp=json_decode($v['option'],true);
                $option_tmp_element=[];
                if(is_array($option_tmp) && !empty($option_tmp)) {
                    foreach ($option_tmp as $ok => $ov) {
                        $option_tmp_element['id'] = $v['id'];
                        $option_tmp_element['option_element'] = $ok . '.' . $ov;
                        $option_tmp_element['option_key'] = $ok;

                        $result2_option[] = $option_tmp_element;
                    }
                }
            }

            $result3_option=[];
            foreach($result3 as $k =>$v){
                $option_tmp=json_decode($v['option'],true);
                $option_tmp_element=[];
                if(is_array($option_tmp) && !empty($option_tmp)) {
                    foreach ($option_tmp as $ok => $ov) {
                        $option_tmp_element['id'] = $v['id'];
                        $option_tmp_element['option_element'] = $ok . '.' . $ov;
                        $option_tmp_element['option_key'] = $ok;

                        $result3_option[] = $option_tmp_element;
                    }
                }
            }
            //简化返回前台的数据
            $result2_new=[];
            foreach ($result2 as $k => $v){
                $tmp=[];
                $tmp['id']=$v['id'];
                $tmp['title']=$v['title'];
                $tmp['answer']=$v['answer'];
                $result2_new[]=$tmp;
            }
            $result3_new=[];
            foreach ($result3 as $k => $v){
                $tmp=[];
                $tmp['id']=$v['id'];
                $tmp['title']=$v['title'];
                $tmp['answer']=$v['answer'];
                $result3_new[]=$tmp;
            }


            //json形式返回结果
            $ot=[
                'userScore'=>$userScore,
                'test1'=>$allTest1Score,
                'test2'=>$allTest2Score,
                'test3'=>$allTest3Score,
                'wrongtest1'=>$result1,
                'wrongtest2'=>[
                    'data'=>$result2_new,
                    'option'=>$result2_option
                ],
                'wrongtest3'=>[
                    'data'=>$result3_new,
                    'option'=>$result3_option,
                ],
            ];
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
    public function t(){
        for ($i=1;$i<4;$i++){

        }
    }
}

?>