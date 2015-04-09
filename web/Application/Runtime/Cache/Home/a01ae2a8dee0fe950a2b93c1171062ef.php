<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="copyright" content="Nener">
	<meta name="author" content="Nener -周孟">
	<title>智能爬虫
		<?php if($title): ?>-<?php echo ($title); endif; ?></title> 
	<!-- Bootstrap Core CSS -->
	<link href="/Public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Public/css/normalize.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/Public/css/crawler.css" rel="stylesheet">
	<!-- <link rel="shortcut icon" href="/Public/Img/favicon.png" type="image/x-icon" >
	-->
	
</head>
<body>
	<!-- 页身 -->
	<div id="wrap">
		<!-- 导航 -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a  href="/">首页</a>
						</li>
						<li>
							<a  href="<?php echo U('Task/index');?>">事务列表</a>
						</li>
						<li>
							<a  href="<?php echo U('Config/index');?>">配置列表</a>
						</li>
						<li>
							<a  href="<?php echo U('Setting/index');?>">设置</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
<div id="main" class="container">
	
	<h1 class="text-center">Hello Word!</h1>

</div>
</div>
<footer>
<div class="container">
	<div class="row hidden-xs">
		<div class="col-md-12 text-center text-p">
			<p>
				Copyright &copy; <?php echo date('Y');?>, Nener
			</p>

		</div>
	</div>
	<div class="row visible-xs-inline">
		<div class="col-md-12 text-center text-p">
			<p>
				Copyright &copy; <?php echo date('Y');?>, Nener
			</p>
		</div>
	</div>
</div>
</footer>
<div  class="loadingimg" ><img src="/Public/img/loading.gif" /></div>
<script src="/Public/js/jquery-1.11.2.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="/Public/js/html5shiv.min.js"></script>
<script src="/Public/js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="/Public/js/crawler.js"></script>
<!--[if lt IE 9]>
	<style>
		.container{
			width: 1170px;
		}

	</style>
<![endif]-->
<!-- 额外js -->

</body>
</html>