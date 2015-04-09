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
		$reg=array('Regex'=>html_entity_decode($data['Regex']),'DefaultValue'=>html_entity_decode($data['DefaultValue']),'Prdfix'=>html_entity_decode($data['Prdfix']),'Suffix'=>html_entity_decode($data['Suffix']));
		if (!$this->where($ar)->save($reg)) {
			return array('status'=>0,'data'=>'保存失败');
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