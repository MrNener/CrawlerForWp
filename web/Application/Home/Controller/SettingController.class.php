<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\recordModel;
/**
 *
 *任务控制器
 */
class SettingController extends Controller {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($id=null,$pagesize=10)
    {
        $this->assign('title','设置');
        $this->display();
    }
}