<?php 
	
	header("content-type:application/json;charset=utf-8");
	require_once("../services/bookService.php");
	require_once("../services/shelfService.php");
	// require_once("../services/orderService.php");

	if(!array_key_exists("Current" , $_COOKIE)){
		$result["code"] = 403;
		$result["message"] = "尚未登录";
		echo json_encode($result);
		exit;
	}

	$readerId = $_COOKIE["Current"];

	$result=[];

	//获取BookId,并检查bookId有效性

	$borrowNumber = "";

	if(array_key_exists("borrowNumber", $_GET)){
		$borrowNumber = $_GET["borrowNumber"];
	}


	if($borrowNumber == ""){
		$result["code"] = 104;
		$result["message"] = "参数无效";
		echo json_encode($result);
		exit;
	}


	// 检查图书信息是否有效
	// echo $borrowNumber;
	// echo $bookNumber;
	
	$bookCanfirm = getAllBookCanfirm($borrowNumber);

	if($bookCanfirm){
		$result["code"] = 100;
		$result["message"] = "取消成功";
		$result["data"] = 1;
	}
	else{
		$result["code"] = 101;
		$result["message"] = "取消失败";
		$result["data"] = 0;
	}

	echo json_encode($result);
 ?>