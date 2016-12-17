<?php
namespace app\admin\controller;

use app\common\controller\Admin;
//use think\File;
use think\Db;

//use app\common\model\Tests;

class Tests extends Admin{
    public function addTest1(){
        if(IS_POST){
            //dump($_POST);die;
            $title=input('title');
            $answer=input('answer');
            $is_update=input('is_update');
            $id=input('id');
            if(empty(trim($title)) && isNull($answer)){
                return $this->error('必须填写题面和标准答案');
            }

            $uploadFile=request()->file('pic');
            //dump($uploadFile);die;
            $fileName='';
            if($uploadFile){
                if($is_update){
                    $deleteFileName=Db::name('Tests')->where('id',$id)->value('pic');
                    if($deleteFileName){
                        if(file_exists(UPLOADS.$deleteFileName)){
                            unlink(UPLOADS.$deleteFileName);
                        }
                    }

                }

                $info=$uploadFile->move(ROOT_PATH.'public'.DS.'uploads',true,false);
                if($info){
                    $fileName=$info->getSaveName();
                }
                $fileName='/uploads/'.$fileName;
            }

            $data=[
                'title'=>$title,
                'type'=>'1',
                'answer'=>$answer,
                'pic'=>$fileName,
            ];

            $tests=model('Tests');

            //编辑习题时更新数据
            if($is_update){
                $result=$tests->save($data,['id'=>$id]);
                $cpage=input('currentPage');
                if($result){
                    //dump(url('tests/listTest1',['page'=>$cpage]));die;
                    //return $this->success('修改成功',url('tests/listTest1',['currentPage'=>$cpage]));
                    return $this->success('修改成功',url('tests/listTest1',['page'=>$cpage]));
                }else{
                    return $this->error('数据保存错误');
                }
            }else{
                $result=$tests->data($data)->isUpdate(false)->save();
            }

            if($result){
                return $this->success('习题保存成功','tests/addTest1');
            }else{
                return $this->error('数据保存错误');
            }

        }else{
            return $this->fetch();
        }
    }

    public function listTest1($currentPage=0){
        $tests=model('Tests');
        $map=$this->searchMap();
        //dump($map);
        //dump($this->param);

        if(!$currentPage==0) $this->param['page']=$currentPage;
        $data=$tests->where(['type'=>'1'])->where($map)->paginate(2,false,['query'=>$this->param]);
        //dump($data->total());

        $this->assign('total',$data->total());
        $this->assign('cpage',$data->currentPage());
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        return $this->fetch();
    }

    public function deleteTest1($id=0,$currentPage=0,$total=0){
        if($id<1) $this->error('删除参数不正确');
        //$tests=new Tests();
        $fileName=Db::name('Tests')->where('id',$id)->value('pic');
        //dump($fileName);die;
        if($fileName && file_exists(ROOT_PATH.'public'.$fileName)){
            unlink(ROOT_PATH.'public'.$fileName);
        }

        if(\app\common\model\Tests::destroy($id)){
            if(!$total==0 && $total%2==1 && $currentPage>=2){
                return $this->success('删除成功',url('tests/listTest1',['page'=>($currentPage-1)]));
            }else{
                return $this->success('删除成功');
            }

        }else{
            return $this->success('删除失败');
        }
    }

    public function editTest1($id=0,$currentPage=0){
        if($id<1) $this->error('查询参数错误');
        if(IS_POST){

        }else{
            $data=Db::name('tests')->where('id',$id)->find();
            $this->assign('currentPage',$currentPage);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public function searchMap(){
        $map=[];
        $tmp=$this->request->get();
        foreach ($tmp as $k=>$v){
            if($k=="keywords"){
                $map['title']=['like',"%$v%"];
            }
        }
        if(isset($map['page'])){
            unset($map['page']);
        }
        return $map;
    }

    //Test2---------------------------------------------------------------------Test2
    public function addTest2(){
        if(IS_POST){
            $title=input('title');
            $answer=input('answer');
            $is_update=input('is_update');
            $id=input('id');
            if(empty(trim($title)) && isNull($answer)){
                return $this->error('必须填写题面和标准答案');
            }

            $uploadFile=request()->file('pic');
            //dump($uploadFile);die;
            $fileName='';
            if($uploadFile){
                if($is_update){
                    $deleteFileName=Db::name('Tests')->where('id',$id)->value('pic');
                    if($deleteFileName){
                        if(file_exists(UPLOADS.$deleteFileName)){
                            unlink(UPLOADS.$deleteFileName);
                        }
                    }

                }

                $info=$uploadFile->move(ROOT_PATH.'public'.DS.'uploads',true,false);
                if($info){
                    $fileName=$info->getSaveName();
                }
                $fileName='/uploads/'.$fileName;
            }

            $option_arr=array_filter(input('option/a'));
            $option_n=65;
            $option_new_arr=[];
            foreach($option_arr as $k=>$v){
                $option_new_arr=array_merge($option_new_arr,[chr($option_n)=>$v]);
                $option_n++;
            }

            $data=[
                'title'=>$title,
                'type'=>'2',
                'option'=>json_encode($option_new_arr),
                'answer'=>$answer,
                'pic'=>$fileName,
            ];

            $tests=model('Tests');

            //编辑习题时更新数据
            if($is_update){
                $result=$tests->save($data,['id'=>$id]);
                $cpage=input('currentPage');
                if($result){
                    return $this->success('修改成功',url('tests/listTest2',['page'=>$cpage]));
                }else{
                    return $this->error('数据保存错误');
                }
            }else{
                $result=$tests->data($data)->isUpdate(false)->save();
            }

            if($result){
                return $this->success('习题保存成功','tests/addTest2');
            }else{
                return $this->error('数据保存错误');
            }

        }else{
            return $this->fetch();
        }
    }

    public function listTest2($currentPage=0){
        $tests=model('Tests');
        $map=$this->searchMap();
        //dump($map);
        //dump($this->param);

        if(!$currentPage==0) $this->param['page']=$currentPage;
        $data=$tests->where(['type'=>'2'])->where($map)->paginate(2,false,['query'=>$this->param]);
        //dump($data->total());

        $this->assign('total',$data->total());
        $this->assign('cpage',$data->currentPage());
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        return $this->fetch();
    }

    public function deleteTest2($id=0,$currentPage=0,$total=0){
        if($id<1) $this->error('删除参数不正确');
        //$tests=new Tests();
        $fileName=Db::name('Tests')->where('id',$id)->value('pic');
        //dump($fileName);die;
        if($fileName && file_exists(ROOT_PATH.'public'.$fileName)){
            unlink(ROOT_PATH.'public'.$fileName);
        }

        if(\app\common\model\Tests::destroy($id)){
            if(!$total==0 && $total%2==1 && $currentPage>=2){
                return $this->success('删除成功',url('tests/listTest2',['page'=>($currentPage-1)]));
            }else{
                return $this->success('删除成功');
            }

        }else{
            return $this->success('删除失败');
        }
    }

    public function editTest2($id=0,$currentPage=0){
        if($id<1) $this->error('查询参数错误');
        if(IS_POST){

        }else{
            $data=Db::name('tests')->where('id',$id)->find();
            $this->assign('currentPage',$currentPage);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    //Test3---------------------------------------------------------------------Test3
    public function addTest3(){
        if(IS_POST){
            //dump($_POST);
            $title=input('title');
            $answer=implode(',',$_POST['answer']);
            $is_update=input('is_update');
            $id=input('id');
            if(empty(trim($title)) && isNull($answer)){
                return $this->error('必须填写题面和标准答案');
            }

            $uploadFile=request()->file('pic');
            //dump($uploadFile);die;
            $fileName='';
            if($uploadFile){
                if($is_update){
                    $deleteFileName=Db::name('Tests')->where('id',$id)->value('pic');
                    if($deleteFileName){
                        if(file_exists(UPLOADS.$deleteFileName)){
                            unlink(UPLOADS.$deleteFileName);
                        }

                    }

                }

                $info=$uploadFile->move(ROOT_PATH.'public'.DS.'uploads',true,false);
                if($info){
                    $fileName=$info->getSaveName();
                }
                $fileName='/uploads/'.$fileName;
            }

            $data=[
                'title'=>$title,
                'type'=>'3',
                'answer'=>$answer,
                'pic'=>$fileName,
            ];

            $tests=model('Tests');

            //编辑习题时更新数据
            if($is_update){
                $result=$tests->save($data,['id'=>$id]);
                $cpage=input('currentPage');
                if($result){
                    return $this->success('修改成功',url('tests/listTest3',['page'=>$cpage]));
                }else{
                    return $this->error('数据保存错误');
                }
            }else{
                $result=$tests->data($data)->isUpdate(false)->save();
            }

            if($result){
                return $this->success('习题保存成功','tests/addTest3');
            }else{
                return $this->error('数据保存错误');
            }

        }else{
            return $this->fetch();
        }
    }

    public function listTest3($currentPage=0){
        $tests=model('Tests');
        $map=$this->searchMap();
        //dump($map);
        //dump($this->param);

        if(!$currentPage==0) $this->param['page']=$currentPage;
        $data=$tests->where(['type'=>'3'])->where($map)->paginate(2,false,['query'=>$this->param]);
        //dump($data->total());

        $this->assign('total',$data->total());
        $this->assign('cpage',$data->currentPage());
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        return $this->fetch();
    }

    public function deleteTest3($id=0,$currentPage=0,$total=0){
        if($id<1) $this->error('删除参数不正确');
        //$tests=new Tests();
        $fileName=Db::name('Tests')->where('id',$id)->value('pic');
        //dump($fileName);die;
        if($fileName && file_exists(ROOT_PATH.'public'.$fileName)){
            unlink(ROOT_PATH.'public'.$fileName);
        }

        if(\app\common\model\Tests::destroy($id)){
            if(!$total==0 && $total%2==1 && $currentPage>=2){
                return $this->success('删除成功',url('tests/listTest3',['page'=>($currentPage-1)]));
            }else{
                return $this->success('删除成功');
            }

        }else{
            return $this->success('删除失败');
        }
    }

    public function editTest3($id=0,$currentPage=0){
        if($id<1) $this->error('查询参数错误');
        if(IS_POST){

        }else{
            $data=Db::name('tests')->where('id',$id)->find();
            $this->assign('currentPage',$currentPage);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
}

?>