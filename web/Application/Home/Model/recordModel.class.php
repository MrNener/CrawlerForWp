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

	public function getListByTask($tb,$idArr,$begin=0,$ncount=5000)
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
		$whereArr['TaskId']=array('in',$idArr);
		$c=new crawler_configModel();
		$c=$c->getByTableName($tb);
		if (!$c) {
			return false;
		}
		$f1=explode('|', $c['FieldsNote']);
		$f2=explode('|', $c['Fields']);
		if (!$f1||count($f1)!=count($f2)) {
			$f1=$f2;
		}
		$f1['SYS_AddTime']='收录时间';
		$lis=$this->getListByWhere($tb,$whereArr,$begin,$ncount);
		foreach ($lis as $key => $value) {
			$lis[$key ]['SYS_AddTime']=date('Y-m-d H:i:s',$value['SYS_AddTime']);
		}
		return array('cof'=>$f1,'list'=>$lis);
	}
	public function getListByWhere($tb,$whereArr,$begin=0,$ncount=5000)
	{
		if (!$tb) {
			return array();
		}
		return D($tb)->field(array('Id','TaskId'),true)->where($whereArr)->limit(($begin.','.$ncount))->order('SYS_AddTime DESC,Id DESC')->select ();
	}
	public function getById($idArr,$tb)
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
		return D($tb)->where($wa)->select();
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