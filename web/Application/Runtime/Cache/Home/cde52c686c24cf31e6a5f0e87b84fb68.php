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
	
	<div class="panel panel-info">
		<div class="panel-heading">
			<button id="updateitem" type="button" class="btn btn-warning hide" disabled>修改</button>
			<button id="delitem" type="button" acurl="<?php echo U('del');?>" class="btn btn-danger " data-tb="<?php echo ($res['config']['TableName']); ?>" disabled>删除</button>
			<form class="form-inline pull-right" role="form" action="<?php echo U('export');?>">
				<input type="hidden" name="tbname" value="<?php echo ($res['config']['TableName']); ?>">
				<input type="hidden" name="task" value="<?php echo ($task); ?>">
				<div class="form-group">
					<input type="number" class="form-control" name="begin" placeholder="起始条" value="" min="1" required></div>
				<div class="form-group">
					<input type="number" class="form-control" name="needcount" placeholder="导出数量(最多1W)" value="" required min="1"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-expend">导出</button>
				</div>
			</form>
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
									<?php if(strtolower($vk)=='url'): ?><a href="<?php echo ($v[$vk]); ?>" target="_blank"><?php echo ($v[$vk]); ?></a>
										<?php else: ?>
										<?php echo ($v[$vk]); endif; ?>
								</td><?php endforeach; endif; ?>
							<td  class="text-center"><?php echo date('Y/m/d H:i',$v['SYS_AddTime']);?></td>
							<td  class="text-center">
								<a href="javascript:void(0);" class="getrec" geturl="<?php echo U('gettpl',array('id'=>$v['Id'],'tb'=>$res['config']['TableName']));?>" >查看</a>
							</td>
						</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
		<div class="page pull-right"><?php echo ($res['page']); ?></div>
	</div>
	<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-dialog modal-lg ">
			<div class="modal-content"></div>
		</div>
	</div>

</div>
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
		$('.getrec').on('click', function(event) {
			ajaxbyget($(this).attr('geturl'),"",function(res){
				if (!res||res.status==0||!res.data) {
					showerrormsg('加载失败！',1,900);
					return false;
				}
				loadingimg();
				$('#myModal').html(res.data);
				$('#myModal').modal('show');
			},'json')
		});
		$('#myModal').on('shown.bs.modal',  function(event) {
			removeloadingimg();
		});
	})
</script>

</body>
</html>