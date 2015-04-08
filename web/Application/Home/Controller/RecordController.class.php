<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\recordModel;
/**
 *
 *任务控制器
 */
class RecordController extends Controller {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($id=null,$pagesize=10)
    {
    	$id=!$id?I('id'):$id;
        $pagesize=(int)$pagesize;
        $pagesize=$pagesize<=0?10:($pagesize>20?20:$pagesize);
        $res=new recordModel();
        $res=$res->listByPage($id,$pagesize,null,array('id'=>$id,'pagesize'=>$pagesize));
        if(!$res){
            $this->error('不要瞎搞！',U('/'));
            return null;
        }
        $this->assign('res',$res);
        $this->display();
    }

    public function del($id,$tb)
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return null;
        }
        $id=!$id?I('id'):$id;
        $id=explode('|', $id);
        $tb=!$tb?I('tb'):$tb;
        $res=new recordModel();
        $res=$res->delById($id,$tb);
        $this->ajaxReturn($res,'json');
    }
}