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


        $MonitorInterval=M('sys_config')->where(array('Key'=>'MonitorInterval'))->find();
        if (!$MonitorInterval) {
           $this->ajaxReturn(array('status'=>0,'data'=>'加载失败!'));
           return false;
        }
        $this->assign('MonitorInterval',$MonitorInterval['Value']);
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
        $MonitorInterval=!$MonitorInterval?I('MonitorInterval'):$MonitorInterval;
        $MonitorInterval=(int)$MonitorInterval;
        if ($MonitorInterval<=0||$MonitorInterval>43200) {
           $this->ajaxReturn(array('status'=>0,'data'=>'保存失败!'));
           return false;
        }
        
        M('sys_config')->where(array('Key'=>'StopCount'))->save(array('Value'=>$StopCount,'UpdateTime'=>time()));
        M('sys_config')->where(array('Key'=>'MaxThread'))->save(array('Value'=>$MaxThread,'UpdateTime'=>time()));
        M('sys_config')->where(array('Key'=>'MonitorInterval'))->save(array('Value'=>$MonitorInterval,'UpdateTime'=>time()));
        addlog('修改设置');
        M('crawler_config')->where(array('StopPageCount'=>array('neq',$StopCount)))->save(array('StopPageCount'=>$StopCount));
        $this->ajaxReturn(array('status'=>1,'data'=>'OK!'));
    }
    public function setpwd()
    {
      $this->assign('title','修改密码');
      $this->display();
    }
    /**
     * 保存密码
     * @return [type] [description]
     */
    public function savepwd()
    {
      $arr=I('post.');
      if (!IS_POST||!$arr) {
         $this->error('不要瞎搞！',U('/'));
         return false;
      }
      $m=M('user')->where(array('Id'=>cookie('uid'),'Status'=>1))->find();
      if (!$m) {
        echo json_encode(array('status'=>0,'data'=>'用户不存在！')) ;
        return false;
      }
      $pwd=strtoupper(sha1(C('PWD_Salt').trim($arr['OPWD'].$m['Name']).$m['KeySalt']));
      if ($pwd!=strtoupper($m['PWD'])) {
        echo json_encode(array('status'=>0,'data'=>'原密码错误！'));
        return false;
      }
      $newsalt=uniqid(randstr(4),true);
      $npwd=strtoupper(sha1(C('PWD_Salt').trim($arr['PWD'].$m['Name']).$newsalt));
      if(M('user')->where(array('Id'=>$m['Id']))->data(array('LastTime'=>time(),'KeySalt'=>$newsalt,'PWD'=>$npwd))->save()){
        $uid=cookie('uzid');
        if (!!$uid) {
          session($uid,null);
        }
        cookie(null);
        addlog('修改密码');
        echo json_encode(array('status'=>1,'data'=>'修改成功'));
        return false;
      }
      echo json_encode(array('status'=>0,'data'=>'修改失败'));
      return false;
    }
}