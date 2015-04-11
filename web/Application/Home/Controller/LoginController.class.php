<?php
namespace Home\Controller;
use Think\Controller;
/**
 *
 *任务控制器
 */
class LoginController extends Controller {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($id=null,$pagesize=10)
    {
        $uid=strtoupper(trim(cookie('uzid')));
        $key=strtoupper(trim(cookie('umid')));
        $keyr=strtoupper(trim(session($uid)));
        if ($key==$keyr&&!(!$uid)&&!(!$key)&&!(!$keyr)) {
            $this->redirect(('Index/index'));
            return false;
        }
        $this->assign('title','登录');
        $this->display();
    }
    public function logout()
    {
      addlog('退出');
      $uid=cookie('uzid');
      if (!!$uid) {
        session($uid,null);
      }
      cookie(null);
      $this->redirect(('index'));
    }
    public function login()
    {
       if (!IS_POST) {
          $this->error('不要瞎搞！',U('index'));
          return false;
       }
       $arr=I('post.');
       if (!$arr||!$arr['Name']||!$arr['PWD']) {
           $this->ajaxReturn(array('status'=>0,'data'=>'数据不完整！'),'json');
           return false;
       }
       $m=M('user')->where(array('Name'=>$arr['Name'],'Status'=>1))->find();
       if (!$m) {
           $this->ajaxReturn(array('status'=>0,'data'=>'用户不存在'),'json');
           return false;
       }
       $pwd=strtoupper(sha1(C('PWD_Salt').trim($arr['PWD'].$arr['Name']).$m['KeySalt']));
       if ($pwd==strtoupper($m['PWD'])) {
            $key=strtoupper(sha1(uniqid(randstr(4),true).$pwd));
            $uid=strtoupper(sha1(uniqid(randstr(4),true).$arr['Name']));
            cookie('uzid',$uid);
            cookie('uid',$m['Id']);
            cookie('uname',$m['Name']);
            cookie('umid',$key);
            session($uid,$key);
            M('user')->where(array('Id'=>$m['Id']))->data(array('LastTime'=>time()))->save();
            addlog('登录');
            $this->ajaxReturn(array('status'=>1,'data'=>'OK!'),'json');
            return false;
       }
       $this->ajaxReturn(array('status'=>0,'data'=>'用户名或密码错误！'),'json');
    }
}