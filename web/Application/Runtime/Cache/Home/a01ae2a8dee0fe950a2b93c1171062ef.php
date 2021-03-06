<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="settingModalLabel">爬虫设置</h4>
		</div>
		<form setting action="<?php echo U('save');?>" method="post" onsubmit="return false;">
			<div class="modal-body">
				<div class="form-group">
					<label for=" StopCount">失败重试次数:</label>
					<input type="number" class="form-control" name="StopCount" id="StopCount" placeholder="失败重试次数" required value="<?php echo ($StopCount); ?>" min="1" max="20" ></div>
				<div class="form-group">
					<label for=" MonitorInterval">监听时间间隔（秒）:</label>
					<input type="number" class="form-control" name="MonitorInterval" id="MonitorInterval" placeholder="最大线程数" required value="<?php echo ($MonitorInterval); ?>" min="1" max="43200" ></div>
				<div class="form-group">
					<label for=" MaxThread">最大线程数:</label>
					<input type="number" class="form-control" name="MaxThread" id="MaxThread" placeholder="最大线程数" required value="<?php echo ($MaxThread); ?>" min="1" max="10" ></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</form>

	</div>
</div>