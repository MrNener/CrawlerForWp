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
	<link rel="shortcut icon" href="/Public/img/favicon.png" type="image/x-icon" >
	
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
					<a class="navbar-brand navbar-brand-expend" href="/">Web Crawler</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a  href="/">系统状态</a>
						</li>
						<li>
							<a  href="<?php echo U('Task/index');?>">任务管理</a>
						</li>
						<li>
							<a  href="<?php echo U('Config/index');?>">配置管理</a>
						</li>
						<li><a href="<?php echo U('Log/index');?>">日志</a></li>
						<li>
							<a id="settingnav" geturl="<?php echo U('Setting/index');?>" href="javascript:void(0)">爬虫设置</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" href="javascript:void(0);">
								<span><?php echo ($username); ?></span>
								&nbsp
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo U('Login/logout');?>">退出</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
<div id="main" class="container">
	
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">状态</div>
			<table class="table table-striped">
				<thead>
					<th>项目</th>
					<th >结果</th>
				</thead>
				<tbody>
					<?php if(is_array($sls)): $i = 0; $__LIST__ = $sls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($v['Note']); ?></td>
							<td><?php echo ($v['Value']); ?>次</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">今日新增任务</div>
			<table class="table table-striped">
				<thead>
					<th>关键字</th>
					<th width="100">添加时间</th>
				</thead>
				<tbody>
					<?php if(is_array($tls)): $i = 0; $__LIST__ = $tls;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($v['KeyWords']); ?></td>
							<td><?php echo date('H:i:s',$v['AddTime']);?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="panel-footer">
				<div class="text-right">
					共计
					<span><?php echo ($tc?$tc:0); ?></span>
					个
					<a href="<?php echo U('Task/index');?>" class="btn btn-success">更多</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-warning">
			<div class="panel-heading">今日已完成任务</div>
			<table class="table table-striped">
				<thead>
					<th>关键字</th>
					<th width="100">完成时间</th>
				</thead>
				<tbody>
					<?php if(is_array($tlsc)): $i = 0; $__LIST__ = $tlsc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($v['KeyWords']); ?></td>
							<td><?php echo date('H:i:s',$v['UpdateTime']);?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="panel-footer">
				<div class="text-right">
					共计
					<span><?php echo ($tcc?$tcc:0); ?></span>
					个
					<a href="<?php echo U('Task/index');?>" class="btn btn-success">更多</a>
				</div>
			</div>
		</div>
	</div>

</div>
</div>


<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="false">
</div>
<footer>
<div class="container">
	<div class="row hidden-xs">
		<div class="col-md-12 text-center text-p">
			<a href="http://weibo.com/nener1107" target="_blank">
				Copyright &copy; <?php echo date('Y');?>, Nener
			</a>
		</div>
	</div>
	<div class="row visible-xs-inline">
		<div class="col-md-12 text-center text-p">
			<a href="http://weibo.com/nener1107" target="_blank">
				Copyright &copy; <?php echo date('Y');?>, Nener
			</a>
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
<script>
	function submitsettingform(){
		$('form[setting]').on('submit', function(event) {
			ajaxbypost($(this).attr('action'),$(this).serialize(),function(res){
				if (!res||res.status==0) {
					showerrormsg('保存失败！',1,900);
					return false;
				}
				showsuccessmsg('OK!',1,900);
				$('#settingModal').modal('hide');
				return false;
			},'json');
			return false;
		});
	}
	$(function(){

		$('#settingnav').on('click',function(event) {
			ajaxbyget($(this).attr('geturl'),"",function(res){
				if (!res||res.status==0||!res.data) {
					showerrormsg('加载配置失败！',1,900);
					return false;
				}else{
					loadingimg();
					$('#settingModal').html(res.data);
					$('#settingModal').modal('show');
					submitsettingform();

				}
			},'json');
		});
		$('#settingModal').on('shown.bs.modal',  function(event) {
			removeloadingimg();
		});

		$('#settingModal').on('hidden.bs.modal',  function(event) {
			$(this).removeData("bs.modal");
		});
	});
</script>
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