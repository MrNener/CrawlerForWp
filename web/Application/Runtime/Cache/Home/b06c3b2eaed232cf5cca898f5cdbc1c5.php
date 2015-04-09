<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-warning">
	<div class="panel-heading text-right">
			<span aria-hidden="true" id="close">&times;</span>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<th >#</th>
				<th  class="text-center" >字段</th>
				<th  class="text-center">正则</th>
				<th  class="text-center">默认值</th>
				<th  class="text-center">前缀</th>
				<th  class="text-center">后缀</th>
				<th class="text-center">操作</th>
			</thead>
			<tbody id="regextb">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v['Id']); ?>">
						<td><?php echo ($v['Id']); ?></td>
						<td  class="text-center"><?php echo ($v['ColName']); ?></td>
						<td  class="text-center">
							<input type="text" class="form-control" name="Regex"  placeholder="正则" required value="<?php echo htmlspecialchars($v['Regex']);?>" ></td>
						<td  class="text-center">
							<input type="text" class="form-control" name="DefaultValue"  placeholder="默认值"  value="<?php echo htmlspecialchars($v['DefaultValue']);?>" ></td>
						<td  class="text-center">
							<input type="text" class="form-control" name="Prdfix"  placeholder="前缀"  value="<?php echo htmlspecialchars($v['Prdfix']);?>" ></td>
						<td  class="text-center">
							<input type="text" class="form-control" name="Suffix"  placeholder="后缀"  value="<?php echo htmlspecialchars($v['Suffix']);?>" ></td>
						<td  class="text-center">
							<a class="save" data-id="<?php echo ($v['Id']); ?>" href="javascript:void(0);" >保存</a>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
</div>
<style>
td {
	max-width: 250px !important;
	min-width: 50px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
#regextb tr:hover{
	background-color: #d9edf7;
}
#close{
	font-size: 22px;
	font-weight: 800;
	color: #A0814C;
}
#close:hover{
	cursor: pointer;
	font-size: 22px;
	font-weight: 900;
	color: #5A4624;
}
</style>
<script>
	$(function(){
		$('#close').on('click',  function(event) {
			$("#myModal").modal('hide');
		});
		$('.save').on('click', function(event) {
			var _id=$(this).attr('data-id');
			var se='tr[data-id="'+_id+'"]';
			var _par=$('#regextb').find(se);
			var _data={
				Id:_id,
				Regex:$(_par).find('input[name="Regex"]').val(),
				DefaultValue:$(_par).find('input[name="DefaultValue"]').val(),
				Prdfix:$(_par).find('input[name="Prdfix"]').val(),
				Suffix:$(_par).find('input[name="Suffix"]').val()
			}
			if (!$.trim(_data.Regex)) {
				showerrormsg('正则不能为空！',1,900);
				$(_par).find('input[name="Regex"]').focus();
				return false;
			}
			ajaxbypost("<?php echo U('Config/saveregex');?>",_data,function(res){
				if (!res||res.status==0) {
					showerrormsg('保存失败！',1,900);
					return false;
				}
				showsuccessmsg('保存成功！',1,900);
				return false;
			},'json');
		});
	})
</script>