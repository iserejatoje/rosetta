<?php if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<?php } else { ?>

<style>
</style>

<div class="col-sm-10">
<?php
	if($vars['action'] == 'new_worker') {
		$act = "Добавить сотрудника!";
	} elseif($vars['action'] == 'edit_worker') {
		$act = "Редактировать сотрудника";
	}
?>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Сотрудники</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

				<?php
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Имя сотрудника</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="pm-name" name="name" value="<?=UString::ChangeQuotes($vars['form']['name'])?>">

						<?php if($err_txt) { ?>
			  				<span class="help-block text-danger"><?= $err_txt?></span>
			  			<?php } ?>
			  		</div>
			  	</div>

			  	<?php
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('position')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Должность</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="pm-name" name="position" value="<?=UString::ChangeQuotes($vars['form']['position'])?>">
						<?php if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<?php } ?>
			  		</div>
			  	</div>

		  		<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		  				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
		    		</div>
		  		</div>
			</form>
		</div>
	</div>
</div>


<?php } ?>
