<?php 
	
	header("content-type:application/json;charset=utf-8");
	require_once("../services/bookService.php");
	require_once("../services/shelfService.php");

	$readerId = $_COOKIE["Current"];

	$result=[];

	$data = delAllShelf($readerId);

	if($data){
		$result["code"] = 100;
		$result["message"] = "删除成功";
		$result["data"] = 1;
	}
	else{
		$result["code"] = 101;
		$result["message"] = "删除失败";
		$result["data"] = 0;
	}


	echo json_encode($result);
 ?>  