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
		<div id="main" class="container">
			
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="panel panel-default">
				<div class="modal-header text-center">
					<h3 class="modal-title" id="myModalLabel"><?php echo ($title); ?></h3>
				</div>
				<div class="modal-body">
					<form action="<?php echo U('login');?>" class="form-horizontal" method="post" onsubmit="return false;">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="Name"  name="Name" placeholder="用户名" required></div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">密 &nbsp;&nbsp; 码</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="PWD"  name="PWD" placeholder="密码" required></div>
						</div>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="submit" class="btn btn-success">登录</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row hidden-xs">
				<div class="col-md-12 text-center text-p">
					<a href="http://weibo.com/nener1107" target="_blank">Copyright &copy; <?php echo date('Y');?>, Nener</a>
				</div>
			</div>
			<div class="row visible-xs-inline">
				<div class="col-md-12 text-center text-p">
					<a href="http://weibo.com/nener1107" target="_blank">Copyright &copy; <?php echo date('Y');?>, Nener</a>
				</div>
			</div>
		</div>
	</footer>
	<div  class="loadingimg" >
		<img src="/Public/img/loading.gif" />
	</div>
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
	
	<script>
	$(function(){
		$('form').on('submit', function(event) {
			ajaxbypost($(this).attr('action'),$(this).serialize(),function(res){
				if (!res||res.status==0) {
					showerrormsg(res.data,1,900);
					return false;
				}
				showsuccessmsg('登录成功！',1,900);
				window.location.href="<?php echo U('Index/index');?>";
				return false;
			},'json');
			return false;
		});
	});
	</script>

</body>
</html>