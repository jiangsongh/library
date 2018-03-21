<?php 


require_once("dbHelper.php");
/*


*/
function getAllAdverts(){
	$sql = "select id , image, link from adverts order by priority desc";
	$list = executeQuery($sql);
	if(is_bool($list))
		return false;

	$adverts = [];
	foreach ($list as $item) {
		$adverts[] = [
			"id" => $item["id"],
			"image" => $item["image"],
			"link" => $item["link"]
		];
	}

	return $adverts;
}