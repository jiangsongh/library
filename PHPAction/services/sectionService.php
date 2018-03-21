<?php 

require_once("dbHelper.php");
require_once("bookService.php");

/*


*/
function getAllSections(){
	$sql = "select id , name from sections order by priority desc";

	$list = executeQuery($sql);
	if(is_bool($list)){
		return false;
	}

	$sections = [];

	foreach ($list as $item) {

		$books = getBooksBySectionId($item[0]); // 根据栏目编号，获取栏目下的图书


		$sections[] = [
			"id" => $item[0],
			"name" => $item[1],
			"books" => $books
		];
	}

	return $sections;
}