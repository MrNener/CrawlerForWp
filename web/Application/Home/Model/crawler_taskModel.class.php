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
		$list = $this->field('crawler_config.Name AS ConfigName,crawler_task.*,`status`.Note AS StatusNote')->join('crawler_config ON crawler_task.ConfigId=crawler_config.Id')->join('`status` ON crawler_task.Status=`status`.Key')->where ( $whereArr )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'crawler_task.AddTime DESC ,crawler_task.Id DESC' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}

	public function getCount($id)
	{
		$m=$this->getById($id);
		if (!$m||!$m['ConfigId']) {
			return array('status'=>0,'data'=>'查询失败');
		}
		$c=new crawler_configModel();
		$m=$c->getById($m['ConfigId']);
		if (!$m||!$m['TableName']) {
			return array('status'=>0,'data'=>'查询失败');
		}
		$res=M()->query('SELECT COUNT(1) AS count FROM '.$m['TableName'].' WHERE  `TaskId`=%s;',$id);
		if(!$res||!$res[0]){
			return array('status'=>0,'data'=>'查询失败');
		}
		return array('status'=>1,'data'=>$res[0]['count']);	
	}
}

 ?>