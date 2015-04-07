<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
/**
 *
 *
 */
class IndexController extends Controller {

    public function index($p=1,$pagesize=1){
    	$res=new crawler_taskModel();
    	$res=$res->listByPage(p,$pagesize,null,array('pagesize'=>$pagesize));
    	$this->assign('res',$res);
    	var_dump($res);
        $this->display();
    }
}