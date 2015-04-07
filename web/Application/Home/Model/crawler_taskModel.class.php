<?php 
namespace Home\Model;
use Think\Model;
class crawler_taskModel extends Model
{
	public function getById($id)
	{
		return $this->where(array('Id'=>$id))->find();
	}
	public function listByPage($page=1,$pageSize=20,$whereArr=null,$params=null)
	{
		$ac = $this->where ( $whereArr )->count ();
		$page = new \Think\Page ( $ac, $pageSize,$params);
		$showPage = $page->show ();
		$list = $this->join('crawler_config ON crawler_task.ConfigId=crawler_config.Id')->where ( $whereArr )->limit ( $Page->firstRow . ',' . $Page->listRows )->order ( 'crawler_task.AddTime' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}
}

 ?>