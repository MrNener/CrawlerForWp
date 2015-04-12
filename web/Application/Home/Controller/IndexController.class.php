<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($id=null,$pagesize=10)
    {
        $ls=M('sys_status')->select();
        $tls=M('crawler_task')->where(array('AddTime'=>array('EGT',strtotime(date('Y-m-d')))))->limit(3)->order('AddTime DESC')->select();
        if (!$tls||count($tls)<3) {
            $tc=!$tls?0:count($tls);
        }else{
            $tc=M('crawler_task')->where(array('AddTime'=>array('EGT',strtotime(date('Y-m-d')))))->count();
        }

        $tlsc=M('crawler_task')->where(array('UpdateTime'=>array('EGT',strtotime(date('Y-m-d')))))->limit(3)->order('UpdateTime DESC')->select();
        if (!$tlsc||count($tlsc)<3) {
            $tc=!$tlsc?0:count($tlsc);
        }else{
            $tcc=M('crawler_task')->where(array('UpdateTime'=>array('EGT',strtotime(date('Y-m-d')))))->count();
        }

        $this->assign('sls',$ls);
        $this->assign('tls',$tls);
        $this->assign('tc',$tc);
        $this->assign('tlsc',$tlsc);
        $this->assign('tcc',$tcc);

        $this->assign('title','系统状态');
        $this->display();
    }
}