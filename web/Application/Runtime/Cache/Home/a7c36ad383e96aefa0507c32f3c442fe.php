<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog ">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"><?php echo ($title); ?></h4>
		</div>
		<?php if($allowsave): ?><form action="<?php echo U('saveconfig');?>" method="post" >
			<?php else: ?>
			<form action="#" method="get" onsubmit="return false;" ><?php endif; ?>
			<div class="modal-body">

				<input type="hidden" name="Id" value="<?php echo ($model['Id']); ?>">				
				<input type="hidden" name="Modif" value="<?php echo ($modif); ?>">				
				<div class="form-group">
					<label for="Name">配置名：</label>
					<input type="text" class="form-control" name="Name" id="Name" placeholder="配置名" required value="<?php echo ($model['Name']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="SubmitUrl">提交Url：</label>
					<input type="url" class="form-control" name="SubmitUrl" id="SubmitUrl" placeholder="提交Url" required value="<?php echo ($model['SubmitUrl']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="KeyWordField">关键字标识：</label>
					<input type="text" class="form-control" name="KeyWordField" id="KeyWordField" placeholder="关键字标识" required value="<?php echo ($model['KeyWordField']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="PageField">翻页标识：</label>
					<input type="text" class="form-control" name="PageField" id="PageField" placeholder="翻页标识" required value="<?php echo ($model['PageField']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="PageSize">分页大小：(0标示自动)</label>
					<input type="number" class="form-control" name="PageSize" id="PageSize" placeholder="分页大小" required value="<?php echo ($model['PageSize']); ?>" <?php echo ($readonly); ?>  min="0" max="100000"></div>
				<div class="form-group">
					<label for="Fields">字段：</label>
					<input type="text" class="form-control" name="Fields" id="Fields" placeholder="字段" required value="<?php echo ($model['Fields']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="FieldsNote">字段备注：（用于显示）</label>
					<input type="text" class="form-control" name="FieldsNote" id="FieldsNote" placeholder="字段备注" required value="<?php echo ($model['FieldsNote']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="AllRowConfig">内容正则：</label>
					<input type="text" class="form-control" name="AllRowConfig" id="AllRowConfig" placeholder="内容正则" required value="<?php echo htmlspecialchars($model['AllRowConfig']);?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group">
					<label for="MaxPage">最大页码：</label>
					<input type="number" class="form-control" name="MaxPage" id="MaxPage" placeholder="最大页码" required value="<?php echo ($model['MaxPage']); ?>" <?php echo ($readonly); ?>  min="1" max="100000"></div>
				<div class="form-group <?php echo ($chide); ?>">
					<label for="TableName">对应表：</label>
					<input type="text" class="form-control" id="TableName" placeholder="对应表"  value="<?php echo ($model['TableName']); ?>" <?php echo ($readonly); ?> ></div>
				<div class="form-group <?php echo ($chide); ?>">
					<label for="AddTime">更新时间：</label>
					<input type="text" class="form-control"  id="AddTime" placeholder="更新时间"  value="<?php echo date('Y-m-d H:i:s',$model['AddTime']);?>" <?php echo ($readonly); ?> ></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<?php if($allowsave): ?><button type="submit" class="btn btn-success">保存</button><?php endif; ?>
			</div>
		</form>
	</div>
</div>