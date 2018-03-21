<?php 
	
require_once("dbHelper.php");

function getAllBorrowed($readerId,$pageIndex = 0, $pageSize = 5){
	

	$sql1 = "select br.id , br.borrowNumber , br.bookId , b.name , b.Image , br.bookNumber , b.AuthorId , a.`Name` , b.PublisherId , p.`Name` ,br.createTime , br.sendTime , br.ReceiveTime , br.state 
from borrowrecords br inner join books b on b.Id = br.BookId inner join `authors` a on b.AuthorId = a.Id inner join publishers p on b.PublisherId = p.Id 
where br.MemberId = '{$readerId}' order by br.state asc , br.CreateTime";

	$sql2 = "select count(*) from borrowrecords br inner join books b on b.Id = br.BookId inner join `authors` a on b.AuthorId = a.Id inner join publishers p on b.PublisherId = p.Id where 1=1";

	//分页
	$startIndex = $pageIndex * $pageSize;
	$sql1 = $sql1 . " limit {$startIndex} , {$pageSize};";
	$sql = $sql1 . $sql2 . ";";

	$list = executeMultiQuery($sql);
	if(is_bool($list))
		return false;

	$borrowedList = [];
	if($list[0]){
		foreach ($list[0] as $item) {
			$borrowedList[] = [
				"id" => $item[2],
				"borrowNumber" => $item[1],
				"name" => $item[3],
				"Image" => $item[4],
				"createTime" => $item[10],
				"state" => $item[13],
				"authorName" => $item[7],
				"bookNumber" => $item[5]
			];
		}
	}
	

	$totalRowCount = $list[1][0][0];
	return [
		"borrowedList" => $borrowedList,
		"totalRowCount" => $totalRowCount
	];
}

 ?>
