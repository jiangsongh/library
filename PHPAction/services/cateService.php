<?php 


require_once("dbHelper.php");
/*


*/
function getAllCategories(){
	$sql = "select Id ,Name ,Icon , Tag from Categories";
	$list = executeQuery($sql);
	if(is_bool($list))
		return false;

	$categories = [];
	foreach ($list as $item) {
		$categories[] = [
			"Id" => $item["Id"],
			"Name" => $item["Name"]
		];
	}

	return $categories;
}