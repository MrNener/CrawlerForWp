<?php
namespace Home\Controller;
use Think\Controller;
class LogController extends BaseController {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($type=null,$wd=null,$pagesize=10)
    {
        $type=(int)$type;
        $wa=array();
        if ($type==1||$type==2) {
            $wa=array('Type'=>$type);
        }if (!!$wd) {
            $wa['Contents']=array('like','%'.$wd.'%');
        }
        $c=M('log')->where($wa)->count();
        $page = new \Think\Page ( $c, $pagesize,array('type'=>$type,'pagesize'=>$pagesize,'wd'=>$wd));
        $showPage = $page->show ();
        $list=M('log')->field('log.*,global_type.Note AS TypeName')->join('global_type ON log.Type=global_type.Key')->where($wa)->limit($page->firstRow . ',' . $page->listRows)->order('log.AddTime DESC ,log.Id DESC')->select();
        $this->assign('res',array('page'=>$showPage,'list'=>$list));
        $this->assign('type',$type);
        $this->assign('wd',$wd);
        $this->assign('title','日志');
        $this->display();
    }
}