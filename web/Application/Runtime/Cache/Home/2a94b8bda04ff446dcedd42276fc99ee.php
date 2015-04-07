<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="copyright" content="Nener">
	<meta name="author" content="Nener -周孟">
	<title>智能爬虫</title>
	<!-- Bootstrap Core CSS -->
	<link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://cdn.bootcss.com/normalize/3.0.1/normalize.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/Public/css/crawler.css" rel="stylesheet">
	<!-- <link rel="shortcut icon" href="/Public/Img/favicon.png" type="image/x-icon" > -->
	
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
							<a href="/">首页</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
<div id="main" class="container">
	
	<div class="panel panel-success">
		<div class="panel-heading">
			<form class="form-inline" role="form" action="<?php echo U('juzi/Prize/index');?>">
				<div class="form-group">
					<input type="text" class="form-control" name="code" value="<?php echo ($prizecode); ?>" placeholder="兑换码"></div>
				<div class="form-group">
					<input type="text" class="form-control" name="nick" value="<?php echo ($nick); ?>" placeholder="用户"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-expend">搜索</button>
				</div>
			</form>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<th ><input type="checkbox" id="select-all"> </th>
					<th  class="text-center" >关键字</th>
					<th  class="text-center">配置项</th>
					<th  class="text-center">单次数量</th>
					<th  class="text-center">周期</th>
					<th  class="text-center">添加时间</th>
					<th  class="text-center">到期时间</th>
					<th class="text-center">状态</th>
					<th class="text-center">已收录</th>
					<th class="text-center">备注</th>
				</thead>
				<tbody>
					<?php if(is_array($res["list"])): foreach($res["list"] as $key=>$v): ?><tr>
								<td><input type="checkbox" id="item-<?php echo ($v['Id']); ?>" class="check-item" value="<?php echo ($v['Id']); ?>"></td>
								<td  class="text-center"><?php echo ($v['KeyWords']); ?></td>
								<td  class="text-center"><?php echo ($v['ConfigName']); ?></td>
								<td  class="text-center"><?php echo ($v['SingleCount']); ?></td>
								<td  class="text-center"><?php echo ($v['Cycle']/(24*60*60)); ?></td>
								<td  class="text-center"><?php echo date('Y/m/d H:i',$v['AddTime']);?></td>
								<td  class="text-center"><?php echo date('Y/m/d H:i',$v['ExpireTime']);?></td>
								<td  class="text-center"><?php echo ($v['StatusNote']); ?></td>
								<td  class="text-center"><?php echo ($v['Note']); ?></td>
						</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
		<div class="page pull-right"><?php echo ($res['page']); ?></div>
	</div>

</div>
</div>
<footer>
<div class="container">
	<div class="row hidden-xs">
		<div class="col-md-12 text-center text-p">
			<p>
				<a href="#">Copyright &copy; 2014, Nener</a>
			</p>

		</div>
	</div>
	<div class="row visible-xs-inline">
		<div class="col-md-12 text-center text-p">
			<p>
				<a href="#">Copyright &copy; 2014, Nener</a>
			</p>
		</div>
	</div>
</div>
</footer>
<div  class="loadingimg" ><img src="/Public/img/loading.gif" /></div>
<script src="http://libs.baidu.com/jquery/1.8.0/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
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

	<script type="text/javascript">
	$(function(){
		initPagination();

	})
</script>

</body>
</html>