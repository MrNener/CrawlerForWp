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
		$list = $this->field('crawler_config.Name AS ConfigName,crawler_config.TableName,crawler_task.*,`status`.Note AS StatusNote')->join('crawler_config ON crawler_task.ConfigId=crawler_config.Id')->join('`status` ON crawler_task.Status=`status`.Key')->where ( $whereArr )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'crawler_task.AddTime DESC ,crawler_task.Id DESC' )->select ();
		return array('page'=>$showPage,'list'=>$list);
	}

	public function getCount($id,$tb)
	{
		if (!$id||!$tb) {
			return array('status'=>0,'data'=>'查询失败');
		}
		$res=M()->query('SELECT COUNT(1) AS count FROM %s WHERE  `TaskId`=%s;',$tb,$id);
		if(!$res||!$res[0]){
			return array('status'=>0,'data'=>'查询失败');
		}
		return array('status'=>1,'data'=>$res[0]['count']);	
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
	    $wa['Id']=array('in',$idArr);
	    if ($this->where($wa)->save(array('Status'=>-1))) {
	        return array('status'=>1,'data'=>'OK！');
	    }
	    return array('status'=>0,'data'=>'删除失败！');
	}
}

 ?>