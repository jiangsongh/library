<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>当当图书</title>
	<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css"/>
</head>
<body>
	<?php 
		require_once("util/globalSetting.php");
		require_once("services/advertService.php");
		require_once("services/sectionService.php");

		$adverts = getAllAdverts();
		$sections = getAllSections();
	 ?>
	 <?php 

	  ?>
	<?php 
		include_once("inc/header.php");
	 ?>
	<div class="index-body">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-top: 10px;">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
				<li data-target="#carousel-example-generic" data-slide-to="3"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox" style="width: 100%;height: 400px;">
				<div class="item active" style="width: 100%;height: 400px;">
						<img src="<?php echo IMAGE_URL_HTTP . $adverts[0]["image"]; ?>" alt="<?php echo $adverts["link"]; ?>" style="width: 100%;height: 400px;">
				</div>
				<div class="item" style="width: 100%;height: 400px;">
						<img src="<?php echo IMAGE_URL_HTTP . $adverts[1]["image"]; ?>" alt="<?php echo $adverts["link"]; ?>" style="width: 100%;height: 400px;">
				</div>
				<div class="item" style="width: 100%;height: 400px;">
						<img src="<?php echo IMAGE_URL_HTTP . $adverts[2]["image"]; ?>" alt="<?php echo $adverts["link"]; ?>" style="width: 100%;height: 400px;">
				</div>
				<div class="item" style="width: 100%;height: 400px;">
						<img src="<?php echo IMAGE_URL_HTTP . $adverts[3]["image"]; ?>" alt="<?php echo $adverts["link"]; ?>" style="width: 100%;height: 400px;">
				</div>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>

		<div class="index-body-guang">
			<?php foreach($sections  as $item): ?>
			<div class="guang-title">
				<b><?php echo $item["name"]; ?><!-- <a href="bookList.php?section=<?php echo $item["id"]; ?>">更多</a> --></b>
			</div>
			<div class="guang-img">
				<?php foreach($item["books"] as $book): ?>
					<div class="guang-img-div">
						<a href="detail.php?id=<?php echo $book["id"]; ?>">
							<img src="<?php echo IMAGE_URL_HTTP . $book["image"] ?>">
						</a>
						<h4><?php echo $book["name"]; ?></h4>
					</div>
				<?php endforeach ?>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<?php 
		include_once("inc/footer.php");
	 ?>
		

	<script src="lib/js/jquery.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
</body>
</html>