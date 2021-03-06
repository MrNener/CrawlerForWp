<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\crawler_configModel;
use Home\Model\crawler_regexModel;
/**
 *
 *任务控制器
 */
class ConfigController extends BaseController {
    /**
     *查看记录
     *@param int $id 事务Id
     *@param int $p 页码
     *@param int $pagesize 分页大小
     */
    public function index($pagesize=10,$wd=null)
    {
        $res=new crawler_configModel();
        $wd=!$wd?I('wd'):$wd;
        if (!!$wd) {
            $wa['Name']=array('like','%'.trim($wd).'%');
        }
        $wa['Status']=1;
        $res=$res->listByPage($pagesize, $wa,array('wd'=>trim($wd)));
        $this->assign('res',$res);
        $this->assign('title','配置管理');
        $this->assign('wd',$wd);
        $this->display();
    }
    public function saveconfig()
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return false;
        }
        $arr=I('post.');
        $res=new crawler_configModel();
        $res=$res->saveConf($arr);
        $this->ajaxReturn($res,'json');
    }
    public function saveregex()
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return false;
        }
        $res=new crawler_regexModel();
        $res=$res->updateById(I('post.'));
        $this->ajaxReturn($res,'json');
    }
    public function del($id)
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return false;
        }
        $id=!$id?I('id'):$id;
        $id=explode('|', $id);
        $res=new crawler_configModel();
        $res=$res->delById($id);
        $this->ajaxReturn($res,'json');
    }

    public function listregex($id)
    {
        $res=new crawler_regexModel();
        $res=$res->ListAllByConfId($id);
        $this->assign('list',$res);
        $data=$this->display('regextpl');
        return false;
        $this->ajaxReturn(array('status'=>1,'data'=>$data.'json'));
        
    }
    /**
     *加载配置
     *@param
     **/
    public function getcof($id=null,$modif=null)
    {
        $id=!$id?I('id'):$id;
        $modif=!$modif?I('modif'):$modif;
        $this->assign('modif',$modif);
        //查看
        if ($modif=='get') {
             $this->assign('title','查看配置');
             $this->assign('readonly','readonly');
        }else if ($modif=='update') {
            //更新
             $this->assign('title','更新配置');
            $this->assign('chide','chide');
            $this->assign('allowsave',true);
        }else if($modif=='add'){
            //添加
             $this->assign('title','添加配置');
            $this->assign('chide','chide');
            $this->assign('allowsave',true);
            $data=$this->fetch('configtpl');
            $this->ajaxReturn(array('status'=>1,'data'=>$data),'json');
            return false;
        }
        else{
            $this->ajaxReturn(array('status'=>0,'data'=>'加载失败!参数不合法！'));
            return false;
        }
        $res=new crawler_configModel();
        $res=$res->getById($id);
        if (!$res) {
            $this->ajaxReturn(array('status'=>0,'data'=>'加载失败'));
            return false;
        }
        $this->assign('model',$res);
        $data=$this->fetch('configtpl');
        $this->ajaxReturn(array('status'=>1,'data'=>$data),'json');
        return false;
    }
}