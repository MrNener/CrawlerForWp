<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="copyright" content="Nener">
	<meta name="author" content="Nener -周孟">
	<title>智能爬虫
	<?php if($title): ?>-<?php echo ($title); endif; ?>
	</title>
	<!-- Bootstrap Core CSS -->
	<link href="/Public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Public/css/normalize.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/Public/css/crawler.css" rel="stylesheet">
	<!-- <link rel="shortcut icon" href="/Public/Img/favicon.png" type="image/x-icon" > -->
	
	<style>
	td {
		max-width: 160px !important;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	</style>

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
			<button id="updateitem" type="button" class="btn btn-warning hide" disabled>修改</button>
			<button id="delitem" type="button" acurl="<?php echo U('del');?>" class="btn btn-danger " data-tb="<?php echo ($res['config']['TableName']); ?>" disabled>删除</button>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<th >
						<input type="checkbox" id="select-all"></th>
						<?php if(is_array($res["config"]["Fields"])): foreach($res["config"]["Fields"] as $k=>$v): ?><th class="text-center" >
							<?php if($res['config']['FieldsNote'][$k]): echo ($res['config']['FieldsNote'][$k]); ?>
							<?php else: ?>
								<?php echo ($res['config']['Fields'][$k]); endif; ?>
						</th><?php endforeach; endif; ?>
					<th  class="text-center" >收录时间</th>
					<th class="text-center">操作</th>
				</thead>
				<tbody >
					<?php if(is_array($res["list"])): foreach($res["list"] as $key=>$v): ?><tr>
							<td >
								<input type="checkbox"  class="check-item" value="<?php echo ($v['Id']); ?>"></td>
							<?php if(is_array($res["config"]["Fields"])): foreach($res["config"]["Fields"] as $k=>$vk): ?><td  class="text-center record">
									<?php echo ($v[$vk]); ?>
								</td><?php endforeach; endif; ?>
							<td  class="text-center"><?php echo date('Y/m/d H:i',$v['SYS_AddTime']);?></td>
							<td  class="text-center">
								<a target="_blank" href="<?php echo U('record',array('id'=>$v['Id']));?>" >查看记录</a>
							</td>
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
				<a href="#">Copyright &copy; <?php echo date('Y');?>, Nener</a>
			</p>

		</div>
	</div>
	<div class="row visible-xs-inline">
		<div class="col-md-12 text-center text-p">
			<p>
				<a href="#">Copyright &copy; <?php echo date('Y');?>, Nener</a>
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

	<script type="text/javascript">

	$(function(){
		initPagination();
	})
</script>

</body>
</html>