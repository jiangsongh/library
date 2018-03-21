<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>我的订单</title>
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/simplepop.css">
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/order.css"/>
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
	 	require_once("services/bookService.php");
	 	require_once("services/orderService.php");

	 	$pageIndex = 0;
		$pageSize = 5;

		if(array_key_exists("pageIndex" , $_GET)){
	 		$pageIndex = $_GET["pageIndex"];
	 	}

	 	$readerId = $_COOKIE["Current"];
	 	$list = getAllBorrowed($readerId, $pageIndex , $pageSize);
	 	
	 	$totalPageCount = ceil($list["totalRowCount"] / $pageSize);



	  ?>
	<div class="index-body">
		<div class="bread-wrap">
		    <div class="bread-wrap-main">
		      <img src="image/in1.png" alt=""/>
		      <a href="index.html">首页</a>
		      <img src="image/right.png" alt=""/>
		      <a href="index.html">图书商城</a>
		      <img src="image/right.png" alt=""/>我的订单
		    </div>
  		</div>
		<div class="order-body">
			<h3 style="font-weight: bold;">我的订单</h3>
			<div class="order-title">
				<span>所借图书</span>
				<span>作者</span>
				<span>借阅状态</span>
				<span>操作<span>
			</div>
			<?php foreach($list["borrowedList"]  as $item): ?>
				<div class="order-item">
					<div class="order-num">
						<span><?php echo date("Y-m-d H:i:s",$item["createTime"]/1000); ?></span>
						<span>订单号：</span>
						<span><?php echo $item["borrowNumber"]; ?></span>
					</div>
					<div class="order-detail">
						<div class="order-book">
							<img src="<?php echo IMAGE_URL_HTTP . $item["Image"]; ?>" style="width: 60px;">
							<a href="detail.php?id=<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></a>
						</div>
						<div><?php echo $item["authorName"]; ?></div>
						<div>
							<?php 
								if($item["state"] == 0){
									echo "已取消";
								}else if($item["state"] == 1){
									echo "已下单";
								}else if($item["state"] == 2){
									echo "已配送";
								}else if($item["state"] == 3){
									echo "已收货";
								}else if($item["state"] == 4){
									echo "已收货";
								}
						 	?>
						</div>
						 <div class="btn-But">
						 	<?php 
						 		if($item["state"] == 1 ){
						 	?>
						 		<a class="btn-add" 
								 	data-book-id="<?php echo $item["borrowNumber"]; ?>" 
								 	data-book-number="<?php echo $item["bookNumber"]; ?>">
									<?php echo "取消";?>
						 	 	</a>
						 	 <?php
							 	}else if($item["state"] == 2){
							 ?>
						 		<a class="btn-add" 
								 	data-book-id="<?php echo $item["borrowNumber"]; ?>" 
								 	data-book-number="<?php echo $item["bookNumber"]; ?>">
									<?php echo "收货";?>
						 	 	</a>
						 	 <?php } ?>
						 	
						</div>
					</div>
				</div>
			 <?php endforeach ?>
		</div>
		<div class="fenye" style="margin-left:40%;margin-top: 20px;">
			<?php for($i = 0 ; $i < $totalPageCount; $i++): ?>
				<a href="order.php?pageIndex=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
			<?php endfor ?>
		</div>

	</div>
	 <?php 
		include_once("inc/footer.php");
	 ?>
	 <script src="lib/js/jquery-1.11.1.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/js/simplepop.js"></script>
	<script type="text/javascript">
		$(function(e){
			$('.btn-add').bind('click' , function(e){
				var $self = $(this);
				var borrowNumber = this.getAttribute('data-book-id');
				var bookNumber = this.getAttribute('data-book-number');
				$.get('ajax/cancelShelf.php?borrowNumber=' + borrowNumber + '&bookNumber=' + bookNumber, function(response){
					if(response.code == 100){
						$self.remove();
						location.href = 'order.php';
					}
					else if(response.code == 403){
						location.href = 'login.php';
					}
					else if(response.code == 103){
						SimplePop.alert("取消失败");
					}
				});

				$.get('ajax/confirmShelf.php?borrowNumber=' + borrowNumber , function(response){
					console.log(response);
					if(response.code == 100){
						$self.remove();
						location.href = 'order.php';
					}
					else if(response.code == 403){
						location.href = 'login.php';
					}
					else if(response.code == 103){
						SimplePop.alert("收货失败");
					}
				});
			});

		});
	</script>
</body>
</html>