<?php
namespace app\admin\controller;

use app\common\controller\Admin;

class Lib extends Admin{
    public function addLib($test1=0,$test2=0,$test3=0){
        if (IS_POST){
            if($test1+$test2+$test3!=100) $this->error('总和必须等于100,请重新填写');
            $lib=model('Tests');
            $ids=$lib->getIds();

            if(count($ids[1])>=$test1 && count($ids[2])>=$test2 && count($ids[3]>=$test3)) {

                $newIds[1] = [];
                $newIds[2] = [];
                $newIds[3] = [];


                while (count($newIds[1]) < $test1) {
                    $newIds[1][] = $ids[1][rand(1, count($ids[1]) - 1)];
                    $newIds[1] = array_unique($newIds[1]);
                    //dump($newIds);die;
                }
                while (count($newIds[2]) < $test2) {
                    $newIds[2][] = $ids[2][rand(1, count($ids[2]) - 1)];
                    $newIds[2] = array_unique($newIds[2]);
                    //dump($newIds);die;
                }
                while (count($newIds[3]) < $test3) {
                    $newIds[3][] = $ids[3][rand(1, count($ids[3]) - 1)];
                    $newIds[3] = array_unique($newIds[3]);
                    //dump($newIds);die;
                }

                $lib=model('Lib');
                $data=[
                    'test1_num'=>$test1,
                    'test2_num'=>$test2,
                    'test3_num'=>$test3,
                    'test1_ids'=>implode(',',$newIds[1]),
                    'test2_ids'=>implode(',',$newIds[2]),
                    'test3_ids'=>implode(',',$newIds[3])
                ];
                $result=$lib->data($data)->save();
                if($result){
                    return $this->success('保存成功','lib/addLib');
                }else{
                    return $this->error('数据生成出错');
                }
            }else{
                return $this->error('习题中的数量少于要生成的数量');
            }

            dump($newIds);
        }else{
            $lib=model('Tests');
            $ids=$lib->getIds();
            $test1_num=count($ids[1]);
            $test2_num=count($ids[2]);
            $test3_num=count($ids[3]);
            $this->assign('test1_num',$test1_num);
            $this->assign('test2_num',$test2_num);
            $this->assign('test3_num',$test3_num);
            return $this->fetch();
        }
    }

    public function listLib($currentPage=0){
        $lib=model('Lib');
        if(!$currentPage==0) $this->param['page']=$currentPage;
        $data=$lib->paginate(2,false,['query'=>$this->param]);

        $this->assign('total',$data->total());
        $this->assign('cpage',$data->currentPage());
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        return $this->fetch();
    }
}

?>