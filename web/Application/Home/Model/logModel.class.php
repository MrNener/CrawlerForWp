<?php
namespace Home\Model;
use Think\Model;
class logModel extends Model
{
	public function addlog($txt,$type=2)
	{
		return $this->data(array('AddTime'=>time(),'Type'=>$type,'Contents'=>$txt))->add();
	}
}
?>