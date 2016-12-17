<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace tests;
use app\common\model\user;


class ExampleTest extends TestCase
{

    public function testBasicExample()
    {
        $this->visit('/')->see('十年');

    }

    public function test1(){
        $user=new User();
        //ar_dump($user->login('admin','admin'));
        //$this->assertNotEquals('0',$user->login('admin','admin'),'没有返回1');
        print_r($this->getResult($user->login('admin','admin')));
    }
}