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
	#lat, #lon {
		width: 100px;
	}

	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	fieldset { padding:0; border:0; margin-top:25px; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	a.set-user-link {
		display:inline-block;
		font-size: 15px;
		text-decoration: none;
		line-height: 22px;
		height: 25px;
		padding-left:10px;
		padding-right: 10px;
		background-color: #c3c3c3;
		color: #000000;
		-webkit-border-radius: 11px;
		-moz-border-radius: 11px;
		border-radius: 11px;
		text-shadow: #3d3d3d 1px 1px 2px;
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


<div class="panel panel-info ">
	<div class="panel-heading">
    	<h3 class="panel-title">Баннер</h3>
  	</div>
	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="<?=$vars['action']?>" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

		 	<div class="form-group">
	    		<div class="col-sm-offset-2 col-sm-10">
	      			<div class="checkbox">
	        			<label>
	        				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?> >
	        				Баннерное место активно
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
			<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Название</label>
		    	<div class="col-sm-10">
					<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
		  			<? } ?>
			    	<div class="input-group">
  						<span class="input-group-addon"><span class="glyphicon glyphicon-font"></span></span>
  						<input type="text" class="form-control" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
					</div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<div class="col-sm-2"></div>
		    	<div class="col-sm-10">
					<input class="btn btn-success" type="submit" value="Сохранить" />
		  		</div>
		  	</div>
	  	</form>
	</div>
</div>

<br/><br/>
<? } ?>