<?php 


require_once("dbHelper.php");
/*


*/
function getAllPublishers(){
	$sql = "select Id,Name from Publishers";
	$list = executeQuery($sql);
	if(is_bool($list))
		return false;

	$publishers = [];
	foreach ($list as $item) {
		$publishers[] = [
			"Id" => $item["Id"],
			"Name" => $item["Name"]
		];
	}

	return $publishers;
}