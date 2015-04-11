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
							<a  href="<?php echo U('Task/index');?>">任务列表</a>
						</li>
						<li>
							<a  href="<?php echo U('Config/index');?>">配置列表</a>
						</li>
						<li><a href="<?php echo U('Log/index');?>">日志</a></li>
						<li>
							<a id="settingnav" geturl="<?php echo U('Setting/index');?>" href="javascript:void(0)">设置</a>
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
	
	<div class="panel panel-info">
		<div class="panel-heading">
			<form class="form-inline " role="form" action="<?php echo U('index');?>">
			<div class="form-group">
					<select name="type" class="form-control">
						<option value="">全部日志</option>
						<option value="2" <?php echo ($type==2?'selected':''); ?>>用户日志</option>
						<option value="1" <?php echo ($type==1?'selected':''); ?>>爬虫日志</option>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="wd" placeholder="内容" value="<?php echo htmlspecialchars($wd);?>"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-expend"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<th >
						#</th>
					<th  class="text-center" >时间</th>
					<th  class="">内容</th>
					<th  class="text-center">类型</th>
				</thead>
				<tbody>
					<?php if(is_array($res["list"])): $i = 0; $__LIST__ = $res["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v['Id']); ?>">
							<td><?php echo ($v['Id']); ?></td>
							<td   class="text-center"><?php echo date('Y/m/d H:i:s',$v['AddTime']);?></td>
							<td wd class=""><?php echo ($v['Contents']); ?></td>
							<td  class="text-center"><?php echo ($v['TypeName']); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
		<div class="page pull-right"><?php echo ($res['page']); ?></div>
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

	<script>
	$(function(){
		selectwd();
		initPagination();
	});
	</script>

</body>
</html>