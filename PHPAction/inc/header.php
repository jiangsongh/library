<?php 
	$name = "";
	$readerId="";
	if(array_key_exists("Current",$_COOKIE)){
		$name = $_COOKIE["Current"];
		$readerId = $_COOKIE["Current"];
	}
			 
 ?>
 <?php 
 	require_once("util/globalSetting.php");
	require_once("services/borrowService.php");
 	if(strpos($_SERVER['REQUEST_URI'],'index.php')){
 		$flag = 0;
 	}
 	if(strpos($_SERVER['REQUEST_URI'],'shop.php')){
 		$flag = 1;
 	}
 	if(strpos($_SERVER['REQUEST_URI'],'detail.php')){
 		$flag = 1;
 	}
 	if(strpos($_SERVER['REQUEST_URI'],'borrowBooks.php')){
 		$flag = 1;
 	}
 	if(strpos($_SERVER['REQUEST_URI'],'order.php')){
 		$flag = 1;
 	}
 	$list = getAllBorrows($readerId);

  ?>
<div class="index-top">
    <div class="index-top-top">
        <div class="index-top-top-all top-left">欢迎来到图书商城，  <span id="userName"><?php echo $name;?></span>  <a href="login.php" id="loginBtn">登录</a><a href="logout.php" id="logoutBtn">注销</a><a href="">免费注册</a></div>
        <div class="index-top-top-all top-right">
			<a href="order.php">我的订单&nbsp;|&nbsp;</a>
			<a href="">会员中心&nbsp;|&nbsp;</a>
			<a href="">移动端&nbsp;|&nbsp;</a>
			<a href="">客服服务</a>
		</div>
    </div>
	<div class="index-top-bottom">
		<div class="index-top-bottom-top"><a href="index.php"><img src="image/index.png" alt=""/></a></div>
		<div class="index-top-bottom-center">
			<div class="index-top-bottom-search">
				<input type="search"/>
				<img src="image/search.jpg" alt=""/>
			</div>
			<p>热门搜索：</p>
		</div>
		<div  class="index-top-bottom-right">
			<div class="index-top-bottom-all right-right">
				<a href="borrowBooks.php"><img src="image/购物车.png" alt=""/>
					<span>借书架</span>
					<div class="car-count" id="lblCount"><?php echo count($list); ?></div>
				</a>
			</div>
			<div class="index-top-bottom-all right-left">
				<a href=""><img src="image/收藏.png" alt=""/>
					<span>收藏</span>
				</a>
			</div>
		</div>
	</div>
</div>
	<div class="index-nav">
		<div class="index-nav-center">
			<ul class="ulu">
				<li <?php echo $flag==0 ?'class="active"':""; ?> ><a href="index.php">首页</a></li>
				<li <?php echo $flag==1 ?'class="active"':""; ?> ><a href="shop.php">图书商城</a></li>
				<li><a href=""></a>公司简介</li>
				<li><a href=""></a>图书百科</li>
				<li><a href=""></a>客户端</li>
			</ul>
		</div>
	</div>
<script type="text/javascript" src="lib/js/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(e){
			if($('#userName').text() == ""){
				$('#logoutBtn').hide();
				$('#loginBtn').show();
			}else{
				$('#logoutBtn').show();
				$('#loginBtn').hide();
			}
		});
		
	</script>
