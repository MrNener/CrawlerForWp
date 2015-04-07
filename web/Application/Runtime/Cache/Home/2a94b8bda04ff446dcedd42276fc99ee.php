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
	
 <div>
 	<h1>Hello Word!</h1>
 	<table>
 		<tr>
 			<th>1</th>
 			<th>2</th>
 			<th>3</th>
 			<th>4</th>
 			<th>5</th>
 		</tr>

 	</table>
 	<div class="page">
 	<?php echo ($res['page']); ?>
 	</div>
 </div>

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
						<th>编号</th>
						<th >用户</th>
						<th >奖项</th>
						<th >奖品</th>
						<th >抽奖时间</th>
						<th style="min-width: 80px;">兑奖时间</th>
						<th >状态</th>
						<th >操作</th>
					</thead>
					<tbody>
						<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="<?php echo ($v['Status']==-1?warning:''); ?>">
								<td><?php echo ($v['Code']); ?></td>
								<td><?php echo ($v['Nick']); ?></td>
								<td><?php echo ($v['PraiseName']); ?></td>
								<td><?php echo ($v['PraiseContent']); ?></td>
								<td><?php echo date('y-m-d H:i:s',$v['CreateTime']);?></td>
								<td>
									<?php echo ($v['UpdateTime']==0?'':date('y-m-d H:i:s',$v['UpdateTime'])); ?>
								</td>
								<td><?php echo ($v['Status']==-1?'已兑换':'未兑换'); ?></td>
								<td>
									<?php if($v['Status'] == 10): ?><a href="javascript:void(0)" class="btn btn-success btn-small save" action="<?php echo U('juzi/Prize/saveprize',array('Id'=>$v['Id']));?>" >兑奖</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
			</div>
			<div class="page pull-right"><?php echo ($page); ?></div>
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

</div>
</div>
</body>
</html>