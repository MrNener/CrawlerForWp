<?php 
namespace Home\Model;
use Think\Model;
class crawler_taskModel extends Model
{
	public function getById($id)
	{
		if (!$id) {
			return null;
		}
		return $this->where(array('Id'=>$id))->find();
	}
	public function listByPage($pageSize=10,$whereArr=null,$params=null)
	{
		$pageSize=$pageSize<=0?10:($pageSize>100?100:$pageSize);
		$ac = $this->where ( $whereArr )->count ();
		$page = new \Think\Page ( $ac, $pageSize,$params);
		$showPage = $page->show ();
		$list = $this->field('crawler_config.Name AS ConfigName,crawler_config.TableName,crawler_task.*,`status`.Note AS StatusNote')->join('crawler_config ON crawler_task.ConfigId=crawler_config.Id')->join('`status` ON crawler_task.Status=`status`.Key')->where ( $whereArr )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'crawler_task.AddTime DESC ,crawler_task.Id DESC' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}

	public function getCount($id,$tb)
	{
		if (!$id||!$tb) {
			return array('status'=>0,'data'=>'查询失败');
		}
		$res=M()->query('SELECT COUNT(1) AS count FROM %s WHERE  `TaskId`=%s;',$tb,$id);
		if(!$res||!$res[0]){
			return array('status'=>0,'data'=>'查询失败');
		}
		return array('status'=>1,'data'=>$res[0]['count']);	
	}
	public function delById($idArr)
	{
	    if (!$idArr) {
	        return array('status'=>0,'data'=>'删除失败！');
	    }
	    if (!is_array($idArr)) {
	        $idArr=array($idArr);
	    }
	    if (count($idArr)<=0) {
	        return array('status'=>0,'data'=>'删除失败！');
	    }
	    $wa['Id']=array('in',$idArr);
	    $r1=$this->field('ConfigId')->where($wa)->group('ConfigId')->select();
	    if (!$r1) {
	        return array('status'=>0,'data'=>'删除失败！');
	    }
	    $temp=array();
	    foreach ($r1 as $key => $value) {
	    	$temp[]=$value['ConfigId'];
	    }
	    $c=new crawler_configModel();
	    $r1=$c->getByIds(array_values($temp));
	    if (!$r1) {
	        return array('status'=>0,'data'=>'删除失败！');
	    }
	    $rm=new recordModel();
	    $d=M();
	    $d->startTrans();
	    foreach ($r1 as $key => $value) {
	    	if (!$value['TableName']) {
	    		continue;
	    	}
	    	$rm->delByTaskId($idArr,$value['TableName']);
	    }
	    if ($this->where($wa)->delete()) {
	    	$d->commit();
	        return array('status'=>1,'data'=>'OK！');
	    }
	    $d->rollback();
	    return array('status'=>0,'data'=>'删除失败！');
	}
	public function savetask($arr)
	{
		$modif=$arr['Modif'];
		if (!$arr||!in_array($modif, array('add','update'))) {
	    	return array('status'=>0,'data'=>'失败！');
		}
		unset($arr['Modif']);
		$arr['ExpireTime']=((int)strtotime($arr['ExpireTime'])+86399);
		$arr['AddTime']=time();
		$arr['UpdateTime']=0;
		$arr['Status']=1;
		$arr['Cycle']=(int)(((int)$arr['Cycle'])*86400);
		$wa['Id']=$arr['Id'];
		unset($arr['Id']);
		if ($modif=='add') {
			$st=$this->data($arr)->add();
		}else{
			unset($arr['AddTime']);
			$st=$this->where($wa)->save($arr);
		}
	    return array('status'=>(int)((bool)$st),'data'=>'');
	}
}

 ?>