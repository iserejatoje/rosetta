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
	$(document).ready(function() {
		$("#payment-type").change(function() {
			var paymentid = $(this).val();
			var accountid = $("#account-id").val();

			if(isNaN(parseInt(paymentid)))
				return false;

			if(isNaN(parseInt(accountid)))
				accountid = 0;

			$.ajax({
				dataType: "json",
				type: "get",
				data: {
					action: 'ajax_get_payment_fields',
					paymentid: paymentid,
					accountid: accountid
				},
				success: function(data){
					if (data.status == 'error')
						return false;

					$("#fields-list").html(data.html);
				}
			});
		})
	});
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
	    	<h3 class="panel-title">Платежная система</h3>
	  	</div>

	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
				<input type="hidden" name="id" value="<?=$vars['form']['AccountID']?>" id="account-id"/>

				<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Название</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="pm-name" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">

						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Type')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Тип</label>
			    	<div class="col-sm-10">
			    		<select name="PaymentID" class="form-control" id="payment-type">
			    			<option value="0">- тип платежной системы -</option>
			    		<? foreach($vars['payments'] as $payment) { ?>
			    			<option value="<?=$payment->ID?>" <? if($payment->ID == $vars['form']['PaymentID']) { ?>selected="selected"<? } ?>><?=$payment->Name?></option>
			    		<? } ?>
			    		</select>
						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>Поля</strong></div>
			    	<div class="col-sm-10">
			    		<div id="fields-list" style="margin: 10px 0 0 0">
							<?=$vars['html']?>
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
