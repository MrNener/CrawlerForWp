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

}


?>