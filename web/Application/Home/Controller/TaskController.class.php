<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
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
    	$res=$res->listByPage($pagesize,null,array('pagesize'=>$pagesize));
    	$this->assign('res',$res);
        $this->display();
    }
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function record($id=null,$p=1,$pagesize=10)
    {

    	# code...
    }
    /**
     *异步查询记录数量
     *@param int $id 事务Id
     */
    public function getCount($id=null)
    {	
    	if (!IS_POST) {
    		$this->error('不要瞎搞！',U('/'));
    	}
    	$id=!$id?I('id'):$id;
    	$res=new crawler_taskModel();
    	$res=$res->getCount($id);
    	echo json_encode($res);
    }
}