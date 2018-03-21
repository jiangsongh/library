<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>当当图书</title>
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/simplepop.css">
    <link rel="stylesheet" href="css/index.css"/>
</head>
<body>
 
	<?php 
		include_once("inc/header.php");
	 ?>

	<?php 
		require_once("util/globalSetting.php");
		require_once("services/cateService.php");
		require_once("services/publisherService.php");
		require_once("services/bookService.php");

		$pageIndex = 0;
		$pageSize = 10;

		if(array_key_exists("pageIndex" , $_GET)){
	 		$pageIndex = $_GET["pageIndex"];
	 	}

	 	$cid = "";
	 	if(array_key_exists("cid" , $_GET)){
	 		$cid = $_GET["cid"];
	 	}
		$pid = "";
	 	if(array_key_exists("pid" , $_GET)){
	 		$pid = $_GET["pid"];
	 	}

		$categories = getAllCategories();
		array_unshift($categories, ["Id" => "" , "Name" => "全部"]);
		$publishers = getAllPublishers();
		array_unshift($publishers, ["Id" => "" , "Name" => "全部"]);


		$book = getAllBooks($cid , $pid , $pageIndex , $pageSize);
		if(is_bool($book)){
			echo "查询数据失败";
			exit;
		}

		$totalPageCount = ceil($book["totalRowCount"] / $pageSize);


	 ?>
	
	<div class="index-body">
		<div class="bread-wrap">
		    <div class="bread-wrap-main">
		      <img src="image/in1.png" alt=""/>
		      <a href="index.html">首页</a>
		      <img src="image/right.png" alt=""/>图书商城
		    </div>
  		</div>
		<div class="shop-classify">
		    <div class="crumb clear-float">
		        <span>所有分类 <img src="image/right.png" alt=""/></span>
		        <span id="hideGroups" class="f-right" style="display: block;float: right;">
		        	<a href="javascript:;">收起筛选</a>
		        	<img src="image/up.png">
		        </span>
		        <span id="showGroups" class="f-right dis-none" style="display:none;float: right;">
		        	<a href="javascript:;">显示筛选</a>
		        	<img src="image/down.png">
		        </span>
		    </div>
	      	<div class="groups" id="category">
				<ul>
					<li>
						<span>类别</span>
						<?php foreach($categories  as $item): ?>
							<a href="shop.php?cid=<?php echo $item["Id"]; ?>&pid=<?php echo $pid; ?>"><?php echo $item["Name"]; ?></a>
						<?php endforeach ?>
					</li>
					<li>
						<span>出版社</span>
						<?php foreach($publishers  as $item): ?>
							<a href="shop.php?pid=<?php echo $item["Id"]; ?>&cid=<?php echo $cid; ?>"><?php echo $item["Name"]; ?></a>
						<?php endforeach ?>
					</li>
				</ul>
	      	</div>
    	</div>

    
	    <div class="grid">
	     	<div class="search-list-nav clear-float">
		        <span>当前图书</span>
	      	</div>
	        <div class="goods-list">
	        	<?php foreach($book["list"] as $item):?>
					<div class="item1">
						<div class="item1-img">
							<img src="<?php echo IMAGE_URL_HTTP . $item["image"]; ?>">
						</div>
						<div class="item1-detail">
							<div class="item1-name">
								<p><?php echo $item["bookname"]; ?></p>
								<p><?php echo $item["name"]; ?>&nbsp;&nbsp;&nbsp;<i>著</i></p>
							</div>
							<div style="font-size: 0">
								<a href="detail.php?id=<?php echo $item["id"]; ?>" style="border-right: 2px solid;">查看详情</a>
								<a class="btn-add" data-book-id="<?php echo $item["id"]; ?>">加入借书架</a>
							</div>
						</div>
					</div>
				<?php endforeach ?>
	        </div>
    	</div>

    	<div class="fenye" style="margin-left:40%;">
			<?php for($i = 0 ; $i < $totalPageCount; $i++): ?>
				<a href="shop.php?pageIndex=<?php echo $i; ?>&cid=<?php echo $cid; ?>&pid=<?php echo $pid; ?>"><?php echo $i + 1; ?></a>
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
			$('#hideGroups').bind('click' , function(e){
				$('#showGroups').show();
				$('#hideGroups').hide();
				$('.groups').slideUp(500);
			});
			$('#showGroups').bind('click' , function(e){
				$('#showGroups').hide();
				$('#hideGroups').show();
				$('.groups').slideDown(500);
			});
		})
 
		$(function(e){

			$('.btn-add').bind('click' , function(e){
				var bookId = this.getAttribute('data-book-id');
				$.get('ajax/addShelf.php?bookId=' + bookId , function(response){
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