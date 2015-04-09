<?php
namespace Home\Model;
use Think\Model;
/**
* 
*/
class crawler_regexModel extends Model
{
	public function updateById($data)
	{
		if (!$data||!$data['Id']) {
			return array('status'=>0,'data'=>'保存失败');
		}
		$ar['Id']=$data['Id'];
		$reg=array('Regex'=>htmlspecialchars_decode($data['Regex']),'DefaultValue'=>htmlspecialchars_decode($data['DefaultValue']),'Prdfix'=>htmlspecialchars_decode($data['Prdfix']),'Suffix'=>htmlspecialchars_decode($data['Suffix']));
		if (!$this->where($ar)->save($reg)) {
			return array('status'=>0,'data'=>'');
		}
		return array('status'=>1,'data'=>'OK!');
	}
	public function ListAllByConfId($id)
	{
		if (!$id) {
			return false;
		}
		return $this->where(array('ConfigId'=>$id))->select();
	}
}

?>