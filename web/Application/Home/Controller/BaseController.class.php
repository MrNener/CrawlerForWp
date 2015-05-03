<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class BaseController extends Controller
{
  
  function _initialize()
  {
    $uid=strtoupper(trim(cookie('uzid')));
    $key=strtoupper(trim(cookie('umid')));
    $keyr=strtoupper(trim(session($uid)));
    if ($key!=$keyr||(!$uid)||(!$key)||(!$keyr)) {
        if( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
            $this->error('还没有登陆诶！',U('Login/index'));
        } else {
            $this->redirect(('Login/index'));
        }
        return false;
    }
    $this->assign('username',cookie('uname'));
  }
}
?>