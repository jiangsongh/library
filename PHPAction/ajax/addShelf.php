<?php 
	
	header("content-type:application/json;charset=utf-8");
	require_once("../services/bookService.php");
	require_once("../services/shelfService.php");

	if(!array_key_exists("Current" , $_COOKIE)){
		$result["code"] = 403;
		$result["message"] = "尚未登录";
		echo json_encode($result);
		exit;
	}

	$readerId = $_COOKIE["Current"];

	$result=[];

	//获取BookId,并检查bookId有效性
	$bookId = "";

	if(array_key_exists("bookId", $_GET)){
		$bookId = $_GET["bookId"];
	}


	if($bookId == ""){
		$result["code"] = 104;
		$result["message"] = "参数无效";
		echo json_encode($result);
		exit;
	}

	// 检查图书信息是否有效

	$book = getBookById($bookId);

	if(is_null($book)){
		$result["code"] = 102;
		$result["message"] = "该图书信息不存在";
		echo json_encode($result);
		exit;

	}

	if($book["number"] == 0){
		$result["code"] = 103;
		$result["message"] = "该图书没有库存.";
		echo json_encode($result);
		exit;
	}


	$data = addShelf($readerId , $bookId);

	if($data){
		$result["code"] = 100;
		$result["message"] = "加入成功";
		$result["data"] = 1;
	}
	else{
		$result["code"] = 101;
		$result["message"] = "加入失败";
		$result["data"] = 0;
	}


	echo json_encode($result);
 ?>