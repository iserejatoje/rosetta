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
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
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
	}
</style>

<script>
	var placemark = null;
	var map  = null;

	$(function() {
		$(".input-number-field").keypress(function(e){
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				return false;
		});

		$(".input-float-field").keypress(function(e){

			if( e.which!=8 && e.which!=0 && e.which != 46 && (e.which<48 || e.which>57))
				return false;
		});

	});
	
</script>


<div class="col-sm-10">
	<?
	if($vars['action'] == 'new_delivery')
		$act = "Новый город";
	elseif($vars['action'] == 'edit_delivery')
		$act = "Редактирование города";
	?>

	<ol class="breadcrumb">
		<? foreach($vars['crumbs'] as $crumb) { ?>
	  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
	  	<? } ?>
	  <li class="active"><?=$act?></li>
	</ol>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Город</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
				<input type="hidden" name="сityid" value="<?=$vars['form']['CityID']?>" />
				<input type="hidden" name="id" value="<?=$vars['form']['DeliveryID']?>" />

			  	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?> >
		        				Доступен
		        			</label>
		      			</div>
		    		</div>
		  		</div>

		  		<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
			  	<div class="form-group<?=$cls?>">
			    	<label for="delivery-name" class="col-sm-2 control-label">Название</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="delivery-name" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
						<? if($err_txt) { ?>
			  				<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Email')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
			  	<div class="form-group<?=$cls?>">
			    	<label for="delivery-email" class="col-sm-2 control-label">E-mail для уведомлений</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
	  						<input type="text" class="form-control" id="delivery-email" name="Email" value="<?=UString::ChangeQuotes($vars['form']['Email'])?>">
						</div>
						<? if($err_txt) { ?>
			  				<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
			  			<? } ?>
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


<?/*
<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
	<input type="hidden" name="сityid" value="<?=$vars['form']['CityID']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['DeliveryID']?>" />

	<table class="form">
		<tr>
			<td class="header-column">Доступен</td>
			<td class="data-column">
				<input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr>
			<td class="header-column">Название <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">E-mail для уведомлений</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Email" value="<?=UString::ChangeQuotes($vars['form']['Email'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить">
			</td>
		</tr>
	</table>
</form>
<br/><br/>
*/?>

<? } ?>