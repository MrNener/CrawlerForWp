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
			<button id="additem" geturl="<?php echo U('getconf');?>" data-p="add" acurl="<?php echo U('savetask');?>" type="button" class="btn btn-success ">添加</button>
			<button id="updateitem"  geturl="<?php echo U('gettask');?>" data-p="update" acurl="<?php echo U('savetask');?>" type="button" class="btn btn-warning" disabled>修改</button>
			<button id="delitem" type="button" acurl="<?php echo U('del');?>" class="btn btn-danger " data-tb="" disabled>删除</button>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<th >
						<input type="checkbox" id="select-all"></th>
					<th  class="text-center" >关键字</th>
					<th  class="text-center">配置项</th>
					<th  class="text-center">单次数量</th>
					<th  class="text-center">周期</th>
					<th  class="text-center">添加时间</th>
					<th  class="text-center">到期时间</th>
					<th class="text-center">状态</th>
					<th class="text-center">已收录</th>
					<th class="text-center">操作</th>
				</thead>
				<tbody>
					<?php if(is_array($res["list"])): $i = 0; $__LIST__ = $res["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v['Id']); ?>" data-tb="<?php echo ($v['TableName']); ?>">
							<td>
								<input type="checkbox"  class="check-item" value="<?php echo ($v['Id']); ?>"></td>
							<td  class="text-center"><?php echo ($v['KeyWords']); ?></td>
							<td  class="text-center"><?php echo ($v['ConfigName']); ?></td>
							<td  class="text-center"><?php echo ($v['SingleCount']); ?></td>
							<td  class="text-center"><?php echo floor($v['Cycle']/86400);?></td>
							<td  class="text-center"><?php echo date('Y/m/d H:i',$v['AddTime']);?></td>
							<td  class="text-center"><?php echo date('Y/m/d H:i',$v['ExpireTime']);?></td>
							<td  class="text-center"><?php echo ($v['StatusNote']); ?></td>
							<td  class="text-center " data-count>
								<img src="/Public/img/min-load.gif" />
							</td>
							<td  class="text-center">
								<a target="_blank" href="<?php echo U('Record/index',array('id'=>$v['Id']));?>" style="display:none;">查看记录</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
		<div class="page pull-right"><?php echo ($res['page']); ?></div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">修改</h4>
				</div>
				<form action="">
					<div class="modal-body">
						<input type="hidden" name="Id" value="">
						<input type="hidden" name="Modif" value="add">
						<div class="form-group">
							<label for="KeyWords">关键字：</label>
							<input type="text" class="form-control" name="KeyWords" id="KeyWords" placeholder="关键字" required></div>
						<div class="form-group">
							<label for="ConfigId">配置：</label>
							<input type="email" class="form-control" name="ConfigId" id="ConfigId" placeholder="配置" required></div>
						<div class="form-group">
							<label for="SingleCount">单次数量</label>
							<input type="number" class="form-control" name="SingleCount" id="SingleCount" placeholder="单次数量" required></div>
						<div class="form-group">
							<label for="Cycle">周期：</label>
							<input type="number" class="form-control" name="Cycle" id="Cycle" placeholder="周期" required></div>
						<div class="form-group">
							<label for="ExpireTime">到期时间：</label>
							<input type="date" class="form-control" name="ExpireTime" id="ExpireTime" placeholder="到期时间" required></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-success">保存</button>
					</div>
				</form>
			</div>
		</div>
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
	function getCount(){
		var tsls=$('tbody').find('tr');
		$.each(tsls, function(index, val) {
			 var thisid=$(this).attr('data-id');
			 ajaxbypost("<?php echo U('getCount');?>",{id:thisid,tb:$(this).attr('data-tb')},function(res,thisid){
			 	if(!res||!res.status||res.data==0){
			 		res.data=0;
			 		$('tr[data-id="'+thisid+'"]').find('a').hide();
			 	}else{
			 		$('tr[data-id="'+thisid+'"]').find('a').show();
			 	}
			 	$('tr[data-id="'+thisid+'"]').find('td[data-count]').text(res.data);
			 	$('tr[data-id="'+thisid+'"]').removeAttr('data-id');
			 },'json',thisid);
			 $('tr[data-id="'+thisid+'"]').removeAttr('data-tb');
		});
	}
	function add_update_get(params,_callback,eventhis){
		$('form').attr('action', $(eventhis).attr('acurl'));
		$('form').find('input[name="Modif"]').val($(eventhis).attr('data-p'));
		$('form').find('input[name="Id"]').val("");
		ajaxbypost($(eventhis).attr('geturl'),params,function(res){
			_callback(res);
		},'json');
	}
	$(function(){
		initPagination();
		getCount();
		$('#additem').on('click', function(event) {
			add_update_get("",function(res){
				alert(res.status);
			},this);
		});
	})
</script>

</body>
</html>