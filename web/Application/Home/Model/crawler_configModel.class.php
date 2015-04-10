<?php
namespace Home\Model;
use Think\Model;
class crawler_configModel extends Model
{
	public function getById($id)
	{
		if (!$id) {
			return false;
		}
		return $this->where(array('Id'=>$id))->find();
	}
	public function getByTableName($tb)
	{
		if (!$tb) {
			return false;
		}
		return $this->where(array('TableName'=>$tb))->limit(1)->find();
	}
	public function listByPage($pageSize=10,$whereArr=null,$params=null)
	{
		$pageSize=$pageSize<=0?10:($pageSize>10000?10000:$pageSize);
		$ac = $this->where ( $whereArr )->count ();
		$page = new \Think\Page ( $ac, $pageSize,$params);
		$showPage = $page->show ();
		$list = $this->where ( $whereArr )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'AddTime DESC ,Id DESC' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}
	public function getByIds($ids)
	{
		if (!$ids||!is_array($ids)) {
			return false;
		}
		$arr['Id']=array('in',$ids);
		return $this->where($arr)->select();
	}
	public function saveConf($data)
	{
		$f1=explode('|', $data['Fields']);
		$f2=explode('|', $data['FieldsNote']);
		if (count($f1)!=count($f2)) {
			$data['FieldsNote']=$data['Fields'];
		}
		$modif=strtolower($data['Modif']);
		$id=$data['Id'];
		unset($data['Id']);
		unset($data['Modif']);
		$data['AllRowConfig']=htmlspecialchars_decode($data['AllRowConfig']);
		if (!$modif||!in_array($modif, array('add','update'))) {
			return array('status'=>0,'data'=>'保存失败！');
		}
		$data['Status']=1;
		$data['AddTime']=time();
		if ($modif=='add') {
			//添加
			$data['TableName']=strtolower(uniqid(randstr('2').'_'));
			$data['Status']=1;
			$d=M();
			$d->startTrans();
			$r1=$this->data($data)->add();
			if (!$r1) {
				$d->rollback();
				return array('status'=>0,'data'=>'保存失败！');
			}
			$sql=array(" `Id` bigint(11) NOT NULL AUTO_INCREMENT");
			foreach ($f1 as $key => $value) {
				if (!$value) {
					$d->rollback();
					return array('status'=>0,'data'=>'保存失败！');
				}
				$sql[]=" `".$value."` text NOT NULL";
			}
			$d->commit();
			$sql[]=" `SYS_AddTime` int(11) NOT NULL DEFAULT '0'";
			$sql[]=" `TaskId` int(11) NOT NULL";
			$sql[]=" PRIMARY KEY (`Id`) ";
			$sql=implode(',', $sql);
			$sql="SET FOREIGN_KEY_CHECKS=0; DROP TABLE IF EXISTS `".$data['TableName']."` ; CREATE TABLE `".$data['TableName']."`(".$sql.") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
			D()->execute($sql);
			$tc=M()->table('information_schema.tables ')->where(array('table_schema'=>C('DB_NAME'),'table_name'=>$data['TableName']))->count();
			if (!$tc) {
				$this->where(array('Id'=>$r1))->delete();
				return array('status'=>0,'data'=>'保存失败！');
			}
			$regexDat=array('ConfigId'=>$r1,'Regex'=>'','DefaultValue'=>'','Prdfix'=>'','Suffix'=>'','Status'=>1);
			$d=M();
			$d->startTrans();
			foreach ($f1 as $key => $value) {
				$regexDat['ColName']=$value;
				$regexDat['ColNote']=$value;
				if (!M()->table('crawler_regex')->data($regexDat)->add()) {
					$d->rollback();
					$this->where(array('Id'=>$r1))->delete();
					D()->execute("SET FOREIGN_KEY_CHECKS=0; DROP TABLE IF EXISTS `".$data['TableName']."` ;");
					return array('status'=>0,'data'=>'保存失败！1');
				}
			}
			$d->commit();
			return array('status'=>1,'data'=>'OK！');
		}else{
			unset($data['Fields']);
			if ($this->where(array('Id'=>$id))->save($data)) {
				return array('status'=>1,'data'=>'OK！');
			}
		}
		return array('status'=>0,'data'=>'保存失败！');
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
		$carr=$this->where(array('Id'=>array('in',$idArr)))->select();
		if (!$carr) {
		    return array('status'=>0,'data'=>'删除失败！');
		}
		$d=M();
		$d->startTrans();
		if (!$this->where(array('Id'=>array('in',$idArr)))->delete()) {
			$d->rollback();
		    return array('status'=>0,'data'=>'删除失败！');
		}
		M('crawler_task')->where(array('ConfigId'=>array('in',$idArr)))->delete();
		M('crawler_regex')->where(array('ConfigId'=>array('in',$idArr)))->delete();
		foreach ($carr as $key => $value) {
			D()->execute("SET FOREIGN_KEY_CHECKS=0; DROP TABLE IF EXISTS `".$value['TableName']."` ;");
		}
		return array('status'=>1,'data'=>'OK！');
	}
}
?>