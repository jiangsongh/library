<?php 


require_once("dbHelper.php");
/*


*/
function getBookDetail($id){
	$sql = "select b.id ,b.isbn, b.name ,b.pinyin ,  b.publishDate, b.image, b.introduce , b.state ,b.categoryId,c.name,b.publisherId, p.name , b.authorId , a.name  , b.Amount , (select count(1) from bookdetails where State = 1 and BookId = b.id) 
from books b inner join categories c on b.CategoryId = c.Id inner join publishers p on b.PublisherId = p.Id inner join `authors` a on a.Id = b.AuthorId where b.Id = '{$id}'";
	$list = executeQuery($sql);
	if(is_bool($list))
		return false;

	$detailList = [];
	foreach ($list as $item) {
		$detailList["id"]=$item[0];
		$detailList["isbn"]=$item[1];
		$detailList["name"]=$item[2];
		$detailList["author"]=$item[13];
		$detailList["image"]=$item[5];
		$detailList["introduce"]=$item[6];
		$detailList["Amount"]=$item[15];
		$detailList["publishDate"]=$item[4];
	}

	return $detailList;
}