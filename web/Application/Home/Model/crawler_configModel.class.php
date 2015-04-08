<?php
namespace Home\Model;
use Think\Model;
class crawler_configModel extends Model
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
		$list = $this->where ( $whereArr )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'AddTime DESC ,Id DESC' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}
}


?>