<?php 


require_once("dbHelper.php");

/*
	功能描述：根据栏目编号，获取图书列表
*/
function getBooksBySectionId($sectionId){
	$sql = "select b.id ,b.isbn , b.Name , b.Image from books b inner join bookinsections bs on b.id = bs.bookId
where bs.sectionId = '{$sectionId}'";

	$list = executeQuery($sql);

	if(is_bool($list))
		return false;

	$books = [];
	foreach($list as $item){
		$books[] = [
			"id" => $item[0],
			"isbn" => $item[1],
			"name" => $item[2],
			"image" => $item[3]
		];
	}

	return $books;
}


function getAllBooks($cid="",$pid="",$pageIndex = 0, $pageSize = 10){
	
$sql1 = "select b.id ,b.isbn, b.name ,b.pinyin ,  b.publishDate, b.image, b.introduce , b.state ,b.categoryId,c.name,b.publisherId, p.name , b.authorId , a.name  , b.Amount , (select count(1) from bookdetails where State = 1 and BookId = b.id) from books b inner join categories c on b.CategoryId = c.Id inner join publishers p on b.PublisherId = p.Id inner join `authors` a on a.Id = b.AuthorId where 1=1";

	$sql2 = "select count(*) from books b inner join categories c on b.CategoryId = c.Id inner join publishers p on b.PublisherId = p.Id inner join `authors` a on a.Id = b.AuthorId where 1=1";


	//添加条件
	if($cid != ""){
		$sql1 = $sql1 . " and c.id = '{$cid}'";
		$sql2 = $sql2 . " and c.id = '{$cid}'";
	}

	if($pid != ""){
		$sql1 = $sql1 . " and p.id = '{$pid}'";
		$sql2 = $sql2 . " and p.id = '{$pid}'";
	}

	//分页
	$startIndex = $pageIndex * $pageSize;
	$sql1 = $sql1 . " limit {$startIndex} , {$pageSize};";
	$sql = $sql1 . $sql2 . ";";

	$list = executeMultiQuery($sql);
	if(is_bool($list))
		return false;

	$bookList = [];
	if($list[0]){
		foreach ($list[0] as $item) {
			$bookList[] = [
				"id" => $item["id"],
				"bookname" => $item[2],
				"name" => $item["name"],
				"image" => $item["image"],
				"isbn" => $item["isbn"]
			];
		}
	}

	$totalRowCount = $list[1][0][0];
	return [
		"list" => $bookList,
		"totalRowCount" => $totalRowCount
	];
}

function getBookById($bookId){
	$sql = "select b.id ,b.isbn, b.name ,b.pinyin ,  b.publishDate, b.image, b.introduce , b.state ,b.categoryId,c.name,b.publisherId, p.name , b.authorId , a.name  , b.Amount , (select count(1) from bookdetails where State = 1 and BookId = b.id) from books b inner join categories c on b.CategoryId = c.Id inner join publishers p on b.PublisherId = p.Id inner join `authors` a on a.Id = b.AuthorId where b.Id = '{$bookId}'";

	$result = executeQuery($sql);
	if(is_bool($result)){
		return false;
	}

	$book = null;
	if($result){
		$book = [
			"id" => $result[0][0],
			"isbn" => $result[0][1],
			"name" => $result[0][2],
			"image" => $result[0][5],
			"number" => $result[0][15]
		];
	}

	return $book;
}


function getDetailById($bookId){
	$sql = "select b.id , b.number , b.state ,b.libraryId , l.name , b.bookId from bookDetails b inner join libraries l on l.id=b.libraryId where b.bookId='{$bookId}' and state = 1";

	$result = executeQuery($sql);
	if(is_bool($result)){
		return false;
	}

	$details = [];

	foreach($result as $item){
		$details[] = [
			"id" => $item[0],
			"bookNumber" => $item[1],
			"bookId" => $item[5]
		];
	}

	return $details;
}
