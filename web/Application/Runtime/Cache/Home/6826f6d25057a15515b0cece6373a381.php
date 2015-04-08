<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo ($title); ?></h4>
		</div>
		<form action="<?php echo U('savetask');?>" method="post" >
			<div class="modal-body">
				<input type="hidden" name="Id" value="<?php echo ($model['Id']); ?>">		
				<input type="hidden" name="Modif" value="<?php echo ($modif); ?>">		
				<div class="form-group">
					<label for="KeyWords">关键字：</label>
					<input type="text" class="form-control" name="KeyWords" id="KeyWords" placeholder="关键字" required value="<?php echo ($model['KeyWords']); ?>"></div>
				<div class="form-group">
					<label for="ConfigId">配置：</label>
					<select class="form-control" name="ConfigId" id="ConfigId" required>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v['Id']); ?>" <?php echo ($v['Id']==$model['ConfigId']?'selected':''); ?>>
								<?php echo ($v['Name']); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>	
					</select>
				</div>
				<div class="form-group">
					<label for="SingleCount">单次数量</label>
					<input type="number" class="form-control" name="SingleCount" id="SingleCount" placeholder="单次数量" required value="<?php echo ($model['SingleCount']); ?>" max="1000" min="1"></div>
				<div class="form-group">
					<label for="Cycle">周期：</label>
					<input type="number" class="form-control" name="Cycle" id="Cycle" placeholder="周期" required value="<?php echo floor($model['Cycle']/86400);?>"  max="1000" min="1"></div>
				<div class="form-group">
					<label for="ExpireTime">到期时间：</label>
					<input type="date" class="form-control" name="ExpireTime" id="ExpireTime" placeholder="到期时间" required value="<?php echo date('Y-m-d',$model['ExpireTime']?$model['ExpireTime']:time());?>"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</form>
	</div>
</div>