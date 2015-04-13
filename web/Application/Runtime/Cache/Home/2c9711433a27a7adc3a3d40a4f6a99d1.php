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
	
	<style>
	td {
		max-width: 160px !important;
		min-width: 50px !important;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	.x-blg{
		min-width: 80%;
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
	
	<div class="panel panel-warning">
		<div class="panel-heading">
			<button id="additem" geturl="<?php echo U('getcof',array('modif'=>'add'));?>" data-p="add" acurl="" type="button" class="btn btn-success ">添加</button>
			<button id="updateitem"  geturl="<?php echo U('getcof',array('modif'=>'update'));?>" data-p="update" acurl="" type="button" class="btn btn-warning" disabled>修改</button>
			<button id="delitem" type="button" acurl="<?php echo U('del');?>" class="btn btn-danger " data-tb="" disabled>删除</button>
			<form class="form-inline pull-right" role="form" action="<?php echo U('index');?>">
				<div class="form-group">
					<input type="text" class="form-control" name="wd" placeholder="配置名" value="<?php echo htmlspecialchars($wd);?>"></div>
				<div class="form-group">
					<button type="submit" class="btn btn-default btn-expend"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<th >
						<input type="checkbox" id="select-all"></th>
					<th  class="text-center" >配置名</th>
					<th  class="text-center">提交Url</th>
					<th  class="text-center">关键字标识符</th>
					<th  class="text-center">翻页标识符</th>
					<th  class="text-center">分页大小</th>
					<th class="text-center">最大翻页</th>
					<th class="text-center">对应表</th>
					<th class="text-center">添加/更新时间</th>
					<th class="text-center">操作</th>
				</thead>
				<tbody>
					<?php if(is_array($res["list"])): $i = 0; $__LIST__ = $res["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v['Id']); ?>">
							<td>
								<input type="checkbox"  class="check-item" value="<?php echo ($v['Id']); ?>"></td>
							<td wd  class="text-center"><?php echo ($v['Name']); ?></td>
							<td  class="text-center"><?php echo ($v['SubmitUrl']); ?></td>
							<td  class="text-center"><?php echo ($v['KeyWordField']); ?></td>
							<td  class="text-center"><?php echo ($v['PageField']); ?></td>
							<td  class="text-center"><?php echo ($v['PageSize']&&$v['PageSize']!=0?$v['PageSize']:'自动'); ?></td>
							<td  class="text-center"><?php echo ($v['MaxPage']); ?></td>
							<td  class="text-center"><?php echo ($v['TableName']); ?></td>
							<td  class="text-center"><?php echo date('Y/m/d H:i',$v['AddTime']);?></td>
							<td  class="text-center">
								<a class="getdetil" href="javascript:void(0);" geturl="<?php echo U('getcof',array('id'=>$v['Id'],'modif'=>'get'));?>">查看详细</a>&nbsp;&nbsp;|&nbsp;&nbsp;
								<a class="getregex" href="javascript:void(0);" geturl="<?php echo U('listregex',array('id'=>$v['Id']));?>" >正则配置</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
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

	<script type="text/javascript">
	function submitform(){
		$('#myModal').find('form').on('submit', function(event) {
			ajaxbypost($(this).attr('action'),$(this).serialize(),function(res){
				if (!res||res.status==0) {
					showerrormsg('保存失败！',1,900);
					return false;
				}
				showsuccessmsg('OK!',1,900);
				$('#myModal').modal('hide');
				window.location.href=window.location.href;
				return false;
			},'json');
			return false;
		});
	}
	$(function(){
		$('.getregex').on('click', function(event) {
			loadingimg();
			$("#myModal").find('.modal-dialog').addClass('x-blg');
			$("#myModal").find('.modal-content').html('');
			$("#myModal").modal({
			    remote: $(this).attr( 'geturl')
			});
		});
		$('#myModal').on('loaded.bs.modal',  function(event) {
			$("#myModal").modal('show');
		});
		$('.getdetil').on('click', function(event) {
			ajaxbyget($(this).attr('geturl'),"",function(res){
				if (!res||res.status==0||!res.data) {
					showerrormsg('加载配置失败！',1,900);
					return false;
				}else{
					loadingimg();
					$('#myModal').html(res.data);
					$('#myModal').modal('show');
				}
			},'json');
		});
		$('#additem').on('click', function(event) {
			ajaxbyget($(this).attr('geturl'),"",function(res){
				if (!res||res.status==0||!res.data) {
					showerrormsg('加载配置失败！',1,900);
					return false;
				}else{
					loadingimg();
					$('#myModal').html(res.data);
					$('#myModal').modal('show');
					submitform();
				}
			},'json');
		});
		$('#myModal').on('shown.bs.modal',  function(event) {
			removeloadingimg();
		});

		$('#myModal').on('hidden.bs.modal',  function(event) {
			$(this).removeData("bs.modal");
		});
		$('#updateitem').on('click', function(event) {
			var len=$('tbody').find('input:checked');
			if(!len.length==1){
				showerrormsg('请选择一项数据进行操作！',1,900);
				return false;
			}
			ajaxbyget($(this).attr('geturl'),{id:$(len).val()},function(res){
				if (!res||res.status==0||!res.data) {
					showerrormsg('加载配置失败！',1,900);
					return false;
				}else{
					loadingimg();
					$('#myModal').html(res.data);
					$('#myModal').modal('show');
					submitform();
				}
			},'json');
		});
		selectwd();
	});
	</script>

</body>
</html>