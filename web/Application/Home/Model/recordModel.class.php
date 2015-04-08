<?php
namespace Home\Model;
use Think\Model;
/**
 * 爬虫记录管理类
 *
 */
class recordModel 
{
	/**
	 *获取记录
	 *@param int $taskid 事物id
	 *@param int $pageSize 分页大小
	 *@param array $whereArr 筛选条件
	 *@param int $params 分页附加参数
	 *@return array page list config
	 */
	public function listByPage($taskid,$pageSize=10,$whereArr=null,$params=null)
	{
		if (!$taskid) {
			return false;
		}
		$m=new crawler_taskModel();
		$m=$m->getById($taskid);
		if (!$m||!$m['ConfigId']) {
			return false;
		}
		$c=new crawler_configModel();
		$c=$c->getById($m['ConfigId']);
		if (!$c||!$c['Fields']||!$c['FieldsNote']||!$c['TableName']) {
			return false;
		}
		$arr=array('TaskId'=>$taskid);
		if ($whereArr&&is_array($whereArr)) {
			$whereArr=array_merge($arr,$whereArr);
		}else{
			$whereArr=$arr;
		}
		$c['Fields']=explode('|', $c['Fields']);
		$c['FieldsNote']=explode('|', $c['FieldsNote']);
		$ac=D($c['TableName'])->where($whereArr)->count();
		$page = new \Think\Page ( $ac, $pageSize,$params);
		$showPage = $page->show ();
		$list=D($c['TableName'])->where($whereArr)->limit ( $page->firstRow . ',' . $page->listRows )->order('SYS_AddTime DESC,Id DESC')->select ();
		return array('page'=>$showPage,'list'=>$list,'config'=>$c);
	}

	public function delById($idArr,$tb)
	{
		if (!$idArr||!$tb) {
			return array('status'=>0,'data'=>'删除失败！');
		}
		if (!is_array($idArr)) {
			$idArr=array($idArr);
		}
		if (count($idArr)<=0) {
			return array('status'=>0,'data'=>'删除失败！');
		}
		$wa['Id']=array('in',$idArr);
		if (D($tb)->where($wa)->delete()) {
			return array('status'=>1,'data'=>'OK！');
		}
		return array('status'=>0,'data'=>'删除失败！');
	}
	public function delByTaskId($idArr,$tb)
	{
		if (!$idArr||!$tb) {
			return false;
		}
		if (!is_array($idArr)) {
			$idArr=array($idArr);
		}
		if (count($idArr)<=0) {
			return false;
		}
		$wa['TaskId']=array('in',$idArr);
		if (D($tb)->where($wa)->delete()) {
			return true;
		}
		return false;
	}
}
?>