<?php

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
?>