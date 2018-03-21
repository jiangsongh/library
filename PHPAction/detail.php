<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>当当图书</title>
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index.css"/>
  <link rel="stylesheet" href="css/detail.css"/>
  <link rel="stylesheet" type="text/css" href="css/simplepop.css">
</head>
<body>
	<?php 
		include_once("inc/header.php");
	 ?>
	<?php 
		require_once("util/globalSetting.php");
		require_once("services/detailService.php");

		$bookId = $_GET["id"];
		$list = getBookDetail($bookId);

	 ?>
	
	<div class="index-body" style="width: 1100px">
		<div class="bread-wrap">
		    <div class="bread-wrap-main">
		      <img src="image/in1.png" alt=""/>
		      <a href="index.html">首页</a>
		      <img src="image/right.png" alt=""/><a href="shop.php">图书商城</a>
		      <img src="image/right.png" alt=""/>图书详情
		    </div>
  	</div>
		<div>
			<div class="div-detail">
				<div>
					<div>
						<img src="<?php echo IMAGE_URL_HTTP . $list["image"]; ?>">
					</div>
					<div>
						<img src="<?php echo IMAGE_URL_HTTP . $list["image"]; ?>">
					</div>
				</div>
				<div>
					<h2><?php echo $list["name"]; ?></h2>
					<div>
						<span>作者：</span>
						<span><?php echo $list["author"]; ?></span>
					</div>
					<div>
						<span>ISBN：</span>
						<span><?php echo $list["isbn"]; ?></span>
					</div>
					<div>
						<span>库存：</span>
						<span><?php echo $list["Amount"]; ?></span>
					</div>
					<div>
						<span>出版日期：</span>
						<span><?php echo $list["publishDate"]; ?></span>
					</div>
			        <button class="btn-add" data-book-id="<?php echo $list["id"]; ?>">加入借书架</button>
			    </div>
		</div>
		<div class="detail-div">
			<p>简介</p>
			<p><?php echo $list["introduce"]; ?></p>
		</div>
    <div class="detail-img">
      <img src="<?php echo IMAGE_URL_HTTP . $list["image"]; ?>" style="width: 400px;">
    </div>
  </div>
	<?php 
		include_once("inc/footer.php");
	 ?>
		

	<script src="lib/js/jquery.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/js/simplepop.js"></script>
	<script type="text/javascript">

		function addShelf(bookId){
			console.log(bookId);
		}
		
		$(function(e){

			$('.btn-add').bind('click' , function(e){
				var bookId = this.getAttribute('data-book-id');
				
				$.get('ajax/addShelf.php?bookId=' + bookId , function(response){
					console.log(response);
					if(response.code == 100){
						var count = parseInt($('#lblCount').text());
						count++;
						$('#lblCount').text(count);
						SimplePop.alert("加入成功");
					}
					else if(response.code == 403){
						location.href = 'login.php';
					}
					else if(response.code == 103){
						SimplePop.alert("没有库存");
					}

				});
			});
		});
	</script>
</body>
</html>