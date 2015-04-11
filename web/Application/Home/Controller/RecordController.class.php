<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\crawler_taskModel;
use Home\Model\recordModel;
/**
 *
 *任务控制器
 */
class RecordController extends BaseController {
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
            return false;
        }
        $this->assign('title','记录列表');
        $this->assign('res',$res);
        $this->assign('task',$id);
        $this->display();
    }
    public function gettpl($id=null,$tb=null)
    {   
        $id=!$id?I('id'):$id;
        $tb=!$tb?I('tb'):$tb;
        $res=new recordModel();
        $res=$res->getById($id,$tb);
        if (!$res||!$res[0]) {
            $this->ajaxReturn(array('status'=>0,'data'=>'加载失败！'),'json');
            return false;
        }
        $res=$res[0];
        $arr=array();
        foreach ($res as $key => $value) {
           $arr[$key]=$value;
        }
        $this->assign('list',$arr);
        $data=$this->fetch('gettpl');
        $this->ajaxReturn(array('status'=>1,'data'=>$data),'json');
    }

    /**
     *导出excel
     **/
    public function export()
    {
        require_once './Lib/HltExcel.class.php';
        $tb=I('tbname');
        $tid=I('task');
        $begin=(int)(I('begin'));
        $needcount=(int)(I('needcount'));
        $begin=$begin<=0?0:($begin-1);
        $needcount=$needcount<=0?100:($needcount>10000?10000:$needcount);
        $res=new recordModel();
        $res=$res->getListByTask($tb,$tid,$begin,$needcount);
        if(!$res){
            $this->error('导出失败！');
            return false;
        }
        $excel=new \HltExcel(count($res['cof'])+5,2007);
        try {
            $excelObj=$excel->SetDataToExcelObj($res['cof'],$res['list'],1);
            $fn=$excel->ExcelObjToFile($excelObj,'temp');
            $excel->downFile($fn);
            addlog('导出记录：'.$begin.'-'.($begin+count($res['list'])));
        } catch (Exception $e) {
            $this->error('导出失败！');
            return false;
        }
    }
    public function del($id,$tb)
    {
        if (!IS_POST) {
           $this->error('不要瞎搞！',U('/'));
           return false;
        }
        $id=!$id?I('id'):$id;
        $id=explode('|', $id);
        $tb=!$tb?I('tb'):$tb;
        $res=new recordModel();
        $res=$res->delById($id,$tb);
        $this->ajaxReturn($res,'json');
    }
}