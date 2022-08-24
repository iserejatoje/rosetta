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
/*	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	.acl-field {
		padding-top: 4px;
		padding-bottom: 4px;
		border-bottom: dotted 1px #898989;
	}
	.search {
		border:1px solid #DDD;
		border-radius: 3px;
		padding: 4px 7px;
		display:inline-block;
		cursor:pointer;

		transition: background .3s;
	}
	.search:hover {
		background: #EEE;
	}*/
</style>

<div class="col-sm-10">
	<?
	if($vars['action'] == 'new_district')
		$act = "Новый район";
	elseif($vars['action'] == 'edit_district')
		$act = "Редактирование района";
	?>

	<ol class="breadcrumb">
		<? foreach($vars['crumbs'] as $crumb) { ?>
	  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
	  	<? } ?>
	  <li class="active"><?=$act?></li>
	</ol>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Район доставки</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
				<input type="hidden" name="id" value="<?=$vars['form']['DistrictID']?>" />
				<input type="hidden" name="cityid" value="<?=$vars['form']['CityID']?>" />

		    	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
			  	<div class="form-group<?=$cls?>">
			    	<label for="district-name" class="col-md-2 control-label">Район доставки</label>
			    	<div class="col-sm-10">
						<input id="district-name" type="text" class="form-control" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>"  placeholder="Район доставки">
			  			<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="district-price" class="col-sm-2 control-label">Стоимость доставки</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon">$</span>
	  						<input type="text" class="form-control" id="district-price" name="Price" value="<?=UString::ChangeQuotes($vars['form']['Price'])?>">
	  						<span class="input-group-addon">руб.</span>
						</div>
			  		</div>
			  	</div>


			  	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?> > Район доступен для доставки
		        			</label>
		      			</div>
		    		</div>
		  		</div>

		  		<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsDefault" value="1"<? if ($vars['form']['IsDefault'] == 1) { ?> checked="checked"<? } ?> > Район доставки по-умолчанию
		        			</label>
		      			</div>
		    		</div>
		  		</div>

				<? /*
		  		<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('PMAccount')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Аккаунт ПС</label>
			    	<div class="col-sm-10">
			    		<select name="AccountID" class="form-control">
			    			<option value="0">- аккаунт платежной системы -</option>
			    		<? foreach($vars['pm_accounts'] as $account) { ?>
			    			<option value="<?=$account->ID?>" <? if($account->ID == $vars['form']['AccountID']) { ?>selected="selected"<? } ?>><?=$account->Name?> (<?=$account->type->Name?>)</option>
			    		<? } ?>
			    		</select>
						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>
			  	*/?>

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