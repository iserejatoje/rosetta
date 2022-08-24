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

	$(document).ready(function(){

		// tinymce.init({
		//     selector: "textarea",
		//     language: "ru",
		//     theme: "modern",
		//     width: 1000,
		//     height: 400,
		//     plugins: [
		//         "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak",
		//         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		//         "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube code"
		//     ],
		//     toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		//     toolbar2: "| responsivefilemanager | link unlink anchor | image media youtube | forecolor backcolor  | print preview code",
		//     image_advtab: true,
		//     indentOnInit: true,

		//     relative_urls: false,
		//     external_filemanager_path: "/resources/static/filemanager/",
		//     filemanager_title:"Responsive Filemanager",
		//     external_plugins: {
		//    		"filemanager" : "/resources/static/filemanager/plugin.min.js"
		//     }
		// });
	});

</script>
<?
	session_start();
?>

<? $message = $_SESSION['user_message']['message'] ?>
<? if (!empty($message)) { ?>
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Успешно!</strong> <?=$message ?></div>
	<? unset($_SESSION['user_message']); ?>
<? } ?>

<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['BlockID']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">Идентификатор</td>
			<td class="data-column">
				<?=$vars['form']['ClassID']?>
			</td>
		</tr>

		<tr>
			<td class="header-column">Блок отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column">Текст блока</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Text')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<div class="input-group">
					<textarea class="form-control" name="Text"><?=UString::ChangeQuotes($vars['form']['Text'])?></textarea>
				</div>
			</td>
		</tr>

		<tr>
			<td class="header-column">Дополнительный текст</td>
			<td class="data-column">
				<div class="input-group">
					<textarea class="form-control" name="MoreText"><?=UString::ChangeQuotes($vars['form']['MoreText'])?></textarea>
				</div>
			</td>
		</tr>


		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>

	</table>
</form>


<?/*
<div class="panel panel-info ">
	<div class="panel-heading">
    	<h3 class="panel-title">Акция</h3>
  	</div>
	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="<?=$vars['action']?>" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
			<input type="hidden" name="id" value="<?=$vars['form']['ShareID']?>" />

		 	<div class="form-group">
	    		<div class="col-sm-offset-2 col-sm-10">
	      			<div class="checkbox">
	        			<label>
	        				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?> >
	        				Акция отображается на сайте
	        			</label>
	      			</div>
	    		</div>
	  		</div>
			<?
	    	$err_txt = '';
	    	if (($err = UserError::GetErrorByIndex('Title')) != '' ) {
	    		$cls = " has-error";
	    		$err_txt = $err;
	    	} ?>
		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Заголовок</label>
		    	<div class="col-sm-10">
			  		<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
		  			<? } ?>
			    	<div class="input-group">
  						<span class="input-group-addon"><span class="glyphicon glyphicon-link"></span></span>
  						<input type="text" class="form-control" name="Title" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>">
					</div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Цвет фона</label>
		    	<div class="col-sm-10">
			  		<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
		  			<? } ?>
			    	<div class="input-group colorpicker">
  						<span class="input-group-addon"><i></i></span>
  						<input type="text" class="form-control" id="share-bg-color" name="BGColor" value="<?=UString::ChangeQuotes($vars['form']['BGColor'])?>">
					</div>
		  		</div>
		  	</div>

	  		<div class="form-group">
		    	<label for="store-phonecode" class="col-sm-2 control-label">Текст акции</label>
		    	<div class="col-sm-10">
					<textarea class="form-control" id="ck-text-editor" name="Text"><?=UString::ChangeQuotes($vars['form']['Text'])?></textarea>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Изображение</label>
		    	<div class="col-sm-10">
					<? if (!empty($vars['form']['Thumb']['f'])) { ?>
						<img src="<?=$vars['form']['Thumb']['f']?>" alt="">
						<input type="checkbox" name="del_thumb" value="1"/> удалить<br/>
					<? } ?>

						<input type="file" name="Thumb"><br/>
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
*/?>
<? } ?>