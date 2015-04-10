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
        $this->error('赶紧去登录!',U('Login/index'));
        return false;
    }
    $this->assign('username',cookie('uname'));
  }
}
?>