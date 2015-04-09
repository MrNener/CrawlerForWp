<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\recordModel;
use Home\Model\crawler_configModel;
/**
 *
 *任务控制器
 */
class TaskController extends Controller {
	/**
	 *事务列表
	 *@param int $p 页码
	 *@param int $pagesize 分页大小
	 */
    public function index($pagesize=10){
    	$pagesize=(int)$pagesize;
		$pagesize=$pagesize<=0?10:($pagesize>20?20:$pagesize);
    	$res=new crawler_taskModel();
    	$res=$res->listByPage($pagesize,array('crawler_task.`Status`'=>array('not in',array(-1,0))),array('pagesize'=>$pagesize));
    	$this->assign('res',$res);
    	$res=new crawler_configModel();
    	$res=$res->listByPage(2000,array('Status'=>1));
    	$this->assign('cls',$res['list']);
        $this->assign('title','事务列表');
        $this->display();
    }
    /**
     *异步查询记录数量
     *@param int $id 事务Id
     */
    public function getCount($id=null,$tb=null)
    {	
    	if (!IS_POST) {
    		$this->error('不要瞎搞！',U('/'));
            return null;
    	}
    	$id=!$id?I('id'):$id;
        $tb=!$tb?I('tb'):$tb;
    	$res=new crawler_taskModel();
    	$res=$res->getCount($id,$tb);
    	$this->ajaxReturn($res);
    }
    public function del($id)
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return null;
        }
        $id=!$id?I('id'):$id;
        $id=explode('|', $id);
        $res=new crawler_taskModel();
        $res=$res->delById($id);
        $this->ajaxReturn($res,'json');
    }
    public function gettask($id)
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return null;
        }
        $id=!$id?I('id'):$id;
        $res=new crawler_taskModel();
        $model=$res->getById($id);
        if (!$model) {
            $this->ajaxReturn(array('status'=>0,'data'=>'加载失败'));
            return false;
        }
        $res=new crawler_configModel();
        $res=$res->listByPage(1000,array('Status'=>1));
        $this->assign('list',$res['list']);
        $this->assign('title','修改');
        $this->assign('modif','update');
        $this->assign('model',$model);
        $data=$this->fetch('configtpl');
        $this->ajaxReturn(array('status'=>1,'data'=>$data),'json');
    }
    public function getconf()
    {
        if (!IS_POST) {
          $this->error('不要瞎搞！',U('/'));
          return false;
        }
        $res=new crawler_configModel();
        $res=$res->listByPage(1000,array('Status'=>1));
        $this->assign('list',$res['list']);
        $this->assign('title','添加');
        $this->assign('modif','add');
        $data=$this->fetch('configtpl');
        $this->ajaxReturn(array('status'=>1,'data'=>$data),'json');
    }

    public function savetask()
    {
    	if (!IS_POST) {
    	  $this->error('不要瞎搞！',U('/'));
    	  return false;
    	}
        $res=new crawler_taskModel();
        $res=$res->savetask(I('post.'));
    	$this->ajaxReturn($res);
    }

}