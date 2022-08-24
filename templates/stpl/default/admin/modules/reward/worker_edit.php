<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }
</style>

<?php if (($err = UserError::GetErrorByIndex('global')) != '' ) {?>
    <h3><?=$err?></h3><br/>
<?php } else { ?>


<script type="text/javascript">
    $(document).ready(function(){
        tinymce.init({
            selector: "textarea",
            language: "ru",
            theme: "modern",
            width: 1000,
            height: 400,
            plugins: [
                "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media youtube | forecolor backcolor  | print preview code",
            image_advtab: true,
            indentOnInit: true,

            relative_urls: false,
            external_filemanager_path: "/resources/static/filemanager/",
            filemanager_title:"Responsive Filemanager",
            external_plugins: {
                "filemanager" : "/resources/static/filemanager/plugin.min.js"
            }
        });
    });
</script>

<form name="new_object_form" method="post" enctype="multipart/form-data">

    <input type="hidden" name="action" value="<?=$vars['action']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <input type="hidden" name="id" value="<?=$vars['form']['id']?>" />

    <table class="form table table-sriped">
    	<tr>
            <td class="header-column">Фото для списка<br/><small><b>88x88px</b> (без ресайза)</small></td>
            <td class="data-column">
                <?php if (($err = UserError::GetErrorByIndex('thumb')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <?php } ?>

                <?php if (!empty($vars['form']['thumb']['f'])) { ?>
                    <img src="<?=$vars['form']['thumb']['f']?>"><br/>
                    <input type="checkbox" name="del_thumb" value="1"/> удалить<br/>
                <?php } ?>
                <input type="file" name="thumb" value="" />
            </td>
        </tr>

        <?php /*
        <tr>
            <td class="header-column">Фото большое<br/><small><b></b></small></td>
            <td class="data-column">
                <?php if (($err = UserError::GetErrorByIndex('image')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <?php } ?>

                <?php if (!empty($vars['form']['image']['f'])) { ?>
                    <img src="<?=$vars['form']['image']['f']?>"><br/>
                    <input type="checkbox" name="del_image" value="1"/> удалить<br/>
                <?php } ?>
                <input type="file" name="image" value="" />
            </td>
        </tr>
        */?>

    	<?php
    	$err_txt = '';
    	if (($err = UserError::GetErrorByIndex('name')) != '' ) {
    		$cls = " has-error";
    		$err_txt = $err;
    	} ?>
        <tr>
            <td class="header-column">Имя сотрудника</td>
            <td class="data-column">
                <input type="text" class="form-control" name="name" value="<?= UString::ChangeQuotes($vars['form']['name'])?>">

						<?php if($err_txt) { ?>
			  				<span class="help-block text-danger"><?= $err_txt?></span>
			  			<?php } ?>
            </td>
        </tr>

        <?php
    	$err_txt = '';
    	if (($err = UserError::GetErrorByIndex('position')) != '' ) {
    		$cls = " has-error";
    		$err_txt = $err;
    	} ?>
        <tr>
            <td class="header-column">Должность</td>
            <td class="data-column">
                <input type="text" class="form-control" name="position" value="<?= UString::ChangeQuotes($vars['form']['position'])?>">

					<?php if($err_txt) { ?>
		  				<span class="help-block text-danger"><?= $err_txt?></span>
		  			<?php } ?>
            </td>
        </tr>
 
        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td colspan="2" align="center">
                <br/>
                <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            </td>
        </tr>
    </table>
</form>

<? } ?>