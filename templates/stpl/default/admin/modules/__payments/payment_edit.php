<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else { ?>

<style>
</style>

<script>
	function addField()
	{
		var list = $('#fields-list');
		var html = $('#fields-etalon').html();
		
		html = html.replace(/etalon\-/g, "");
		list.append(html);
	}
	function removeField(obj)
	{
		$(obj).closest('.field-group').remove();
	}
</script>

<div class="col-sm-10">
	<?
	if($vars['action'] == 'new_payment')
		$act = "Новая ПС";
	elseif($vars['action'] == 'edit_payment')
		$act = "Редактирование ПС";
	?>

	<ol class="breadcrumb">
		<? foreach($vars['crumbs'] as $crumb) { ?>
	  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
	  	<? } ?>
	  <li class="active"><?=$act?></li>
	</ol>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Платажная система</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
				<input type="hidden" name="id" value="<?=$vars['form']['PaymentID']?>" />

				<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Платежная система</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="pm-name" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">

						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('NameID')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Класс</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="pm-name" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>">
						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

				<div id="fields-etalon" style="display:none">
				  	<div class="form-group form-group-sm field-group">
		    			<div class="col-sm-2">
		    				<input type="text" class="form-control" name="Fields[]">
		    			</div>
		    			<div class="col-sm-2">
		    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить поле</button>
		    			</div>
		    		</div>
		    	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>Поля</strong></div>
			    	<div class="col-sm-10">
			    		<button type="button" class="btn btn-info btn-xs" onclick="addField()"><span class="glyphicon glyphicon-plus"></span> Добавить поле</button>
			    		<div id="fields-list" style="margin: 10px 0 0 0">
			    		<? foreach($vars['form']['Fields'] as $field) { ?>
				    		<div class="form-group form-group-sm field-group">
				    			<div class="col-sm-2">
				    				<input type="text" class="form-control" name="Fields[]" value="<?=$field?>">
				    			</div>
				    			<div class="col-sm-2">
				    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить поле</button>
				    			</div>
				    		</div>
			    		<? } ?>
			    		</div>
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


<? } ?>
