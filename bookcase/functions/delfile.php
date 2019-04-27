<?php
	include_once("../config.php");

	if(	array_search($_POST['filepath'],$ignore) ||
		strpos(strtolower($_POST['filepath']),'epub')===false ||
		$_POST['password'] != $config['password']
	) {
		$redata = array(
		"code"	=>	0,
		"msg"	=>	"不允许删除"
		);
	} else {
		unlink($_POST['filepath']);
		$redata = array(
			"code"		=>	1,
			"msg"		=>	"已删除"
		);
	}

	$redata = json_encode($redata);
	echo $redata;
?>