<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog ">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">查看</h4>
		</div>
		<div class="modal-body">
			<?php if(is_array($list)): foreach($list as $k=>$v): ?><div class="form-group">
					<label for="<?php echo ($k); ?>"><?php echo ($k); ?>：</label>
					<div>
					<?php if(strtolower($k)=='url'): ?><a href="<?php echo ($v); ?>" target="_blank"><?php echo htmlspecialchars($v);?></a>
					<?php else: ?>
						<?php echo htmlspecialchars($v); endif; ?>
					</div>
				</div><?php endforeach; endif; ?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		</div>
	</div>
</div>