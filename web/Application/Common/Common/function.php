<?php
use Home\Model\logModel;
function randstr($length = 8) {
	if ($length <= 0) {
		return null;
	}
	$pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ'; // 字符池
	$end = strlen ( $pattern ) - 1;
	$rst = '';
	for($i = 0; $i < $length; $i ++) {
		$rst .= $pattern {mt_rand ( 0, $end )}; // 生成php随机数
	}
	return $rst;
}
function objectToArray($e){
    $e=(array)$e;
    foreach($e as $k=>$v){
        if( gettype($v)=='resource' ) return;
        if( gettype($v)=='object' || gettype($v)=='array' )
            $e[$k]=(array)objectToArray($v);
    }
    return $e;
}
function addlog($txt,$type=2)
{
	$re=new logModel();
	$txt='用户：'.cookie('uname'). '  '.$txt;
	return $re->addlog($txt,$type);
}
?>