<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>借书架</title>
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	  <link rel="stylesheet" href="css/index.css"/>
	  <link rel="stylesheet" href="css/detail.css"/>
	  <link rel="stylesheet" type="text/css" href="css/simplepop.css">
</head>
<body>
	<?php 
		if(!array_key_exists("Current",$_COOKIE)){
			header("location:login.php");
			exit;
		}
		$readerId = $_COOKIE["Current"];
	 ?>
	<?php 
		include_once("inc/header.php");
	 ?>
	 <?php 
	 	require_once("util/globalSetting.php");
	 	require_once("services/borrowService.php");
	 	require_once("services/shelfService.php");

	 	$books = getBooksInShelf($readerId);

	  ?>
 
	<div class="index-body" style="background-color:#fff;" >
		<div class="mine-borrows">
			<span>我的借书架</span>
		</div>
		<div class="booksTable">
			<table class="table table-striped" style="margin-top: 15px;">
				<thead style="background-color: #F2DEDE;">
					<th><input type="checkbox" name="">全选</th>
					<th>商品</th>
					<th>商品名</th>
					<th>图书ISBN</th>
					<th>操作</th>
				</thead>
				<tbody>
					<?php foreach($list as $item): ?>
						<tr>
							<td><input type="checkbox" name=""></td>
							<td><img src="<?php echo IMAGE_URL_HTTP . $item["image"]; ?>" style="width: 60px;"></td>
							<td><?php echo $item["name"] ?></td>
							<td><?php echo $item["isbn"] ?></td>
							<td><a class="btn-del" data-book-id="<?php echo $item["id"]; ?>">删除</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div>
				<div class="borrow-del">
					<span><a class="btn-delAll" data-book-id="<?php echo $item["id"]; ?>">全部删除</a></span>
				</div>
				<div class="borrow-delete">
					<div class="account">
						<span id="btnSubmit">去结算</span>
					</div>
					<div class="account-left">
						<span>共计：</span>
						<span class="cout"><?php echo count($list); ?></span>
					</div>
				</div>
				
			</div>
		</div>
		<div class="bookCeng">
			<img src="image/empty.png">
			<span>您的借书架是空的，您可以<a href="shop.php">去逛逛</a></span>
		</div>
		
		
	</div>
		

	 <?php 
		include_once("inc/footer.php");
	 ?>
	 <script src="lib/js/jquery.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/js/simplepop.js"></script>
	<script type="text/javascript">
		$(function(e){
			if($('.cout').text() == 0 ){
				$('.bookCeng').show();
				$('.booksTable').hide();
			}else{
				$('.bookCeng').hide();
				$('.booksTable').show();
			}


			$('.btn-del').bind('click' , function(e){
				var bookId = this.getAttribute('data-book-id');
				var $self = $(this);
				$.get('ajax/deleteOne.php?bookId=' + bookId , function(response){
					console.log(response);
					if(response.code == 100){
						$self.parent().parent().remove();
						location.href="borrowBooks.php";
					}else if(response.code == 103){
						SimplePop.alert("删除失败");
					}
				});
			});

			$('.btn-delAll').bind('click' , function(e){
				
				$.get('ajax/deleteAll.php' , function(response){
					console.log(response);
					if(response.code == 100){
						$('tbody tr').remove();
						location.href="borrowBooks.php";
					}else if(response.code == 103){
						SimplePop.alert("删除失败");
					}
				});
			});

			$('#btnSubmit').bind('click' , function(){
				
				$.get('ajax/submitOrder.php' , function(response){
					console.log(response);
					if(response.code == 100){
						$('tbody tr').remove();
						location.href="order.php";
					}
					else{
						SimplePop.alert(response.message);
					}
				});
			});
		});
		
	</script>
</body>
</html>   