<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\recordModel;
/**
 *
 *任务控制器
 */
class SettingController extends BaseController {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index()
    {
        $StopCount=M('sys_config')->where(array('Key'=>'StopCount'))->find();
        if (!$StopCount) {
           $this->ajaxReturn(array('status'=>0,'data'=>'加载失败!'));
           return false;
        }
        $this->assign('StopCount',$StopCount['Value']);
        $MaxThread=M('sys_config')->where(array('Key'=>'MaxThread'))->find();
        if (!$MaxThread) {
           $this->ajaxReturn(array('status'=>0,'data'=>'加载失败!'));
           return false;
        }
        $this->assign('MaxThread',$MaxThread['Value']);
        $data=$this->fetch('index');
        $this->ajaxReturn(array('status'=>1,'data'=>$data));
    }
    public function save($StopCount='')
    {

        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return false;
        }
        $StopCount=!$StopCount?I('StopCount'):$StopCount;
        $StopCount=(int)$StopCount;
        if ($StopCount<=0) {
           $this->ajaxReturn(array('status'=>0,'data'=>'保存失败!'));
           return false;
        }
        $MaxThread=!$MaxThread?I('MaxThread'):$MaxThread;
        $MaxThread=(int)$MaxThread;
        if ($MaxThread<=0||$MaxThread>20) {
           $this->ajaxReturn(array('status'=>0,'data'=>'保存失败!'));
           return false;
        }
        M('sys_config')->where(array('Key'=>'StopCount'))->save(array('Value'=>$StopCount,'UpdateTime'=>time()));
        M('sys_config')->where(array('Key'=>'MaxThread'))->save(array('Value'=>$MaxThread,'UpdateTime'=>time()));
        addlog('修改设置');
        M('crawler_config')->where(array('StopPageCount'=>array('neq',$StopCount)))->save(array('StopPageCount'=>$StopCount));
        $this->ajaxReturn(array('status'=>1,'data'=>'OK!'));
    }
}