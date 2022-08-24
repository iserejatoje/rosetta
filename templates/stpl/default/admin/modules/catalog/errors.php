<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<div class="panel panel-default">
  		<div class="panel-heading">
  			<h3 class="panel-title">Внимание</h3>
  		</div>
  		<div class="panel-body">
			<div class="alert alert-danger" role="alert"><?=$err?></div>
  		</div>
	</div>
<? } ?>