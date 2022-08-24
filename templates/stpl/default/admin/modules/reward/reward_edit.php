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
            <td class="header-column">Видимость</td>
            <td class="data-column">
                <input type="checkbox" name="is_visible" value="1"<?php if ($vars['form']['is_visible']) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

    	<tr>
            <td class="header-column">Фото для списка<br/><small><b>224x320px</b></small></td>
            <td class="data-column">
                <?php if (($err = UserError::GetErrorByIndex('thumb')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <?php } ?>

                <?php if (!empty($vars['form']['thumb']['f'])) { ?>
                    <div style="max-width: 250px">
                        <img src="<?=$vars['form']['thumb']['f']?>" class="img-responsive"><br/>
                    </div>
                    <input type="checkbox" name="del_thumb" value="1"/> удалить<br/>
                <?php } ?>
                <input type="file" name="thumb" value="" />
            </td>
        </tr>

        <tr>
            <td class="header-column">Фото большое<br/><small><b>432x608px</b></small></td>
            <td class="data-column">
                <?php if (($err = UserError::GetErrorByIndex('image')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <?php } ?>

                <?php if (!empty($vars['form']['image']['f'])) { ?>
                    <div style="max-width: 250px">
                        <img src="<?=$vars['form']['image']['f']?>" class="img-responsive"><br/>
                    </div>
                    <input type="checkbox" name="del_image" value="1"/> удалить<br/>
                <?php } ?>
                <input type="file" name="image" value="" />
            </td>
        </tr>

    	<?php
    	$err_txt = '';
    	if (($err = UserError::GetErrorByIndex('title')) != '' ) {
    		$cls = " has-error";
    		$err_txt = $err;
    	} ?>
        <tr>
            <td class="header-column">Заголовок</td>
            <td class="data-column">
                <input type="text" class="form-control" name="title" value="<?= UString::ChangeQuotes($vars['form']['title'])?>">

				<?php if($err_txt) { ?>
	  				<span class="help-block text-danger"><?= $err_txt?></span>
	  			<?php } ?>
            </td>
        </tr>

        <?php
    	$err_txt = '';
    	if (($err = UserError::GetErrorByIndex('text')) != '' ) {
    		$cls = " has-error";
    		$err_txt = $err;
    	} ?>
        <tr>
            <td class="header-column">Описание</td>
            <td class="data-column">
                <textarea name="text"><?= UString::ChangeQuotes($vars['form']['text'])?></textarea>

				<?php if($err_txt) { ?>
	  				<span class="help-block text-danger"><?= $err_txt?></span>
	  			<?php } ?>
            </td>
        </tr>

        <?php
        $err_txt = '';
        if (($err = UserError::GetErrorByIndex('worker_id')) != '' ) {
            $cls = " has-error";
            $err_txt = $err;
        } ?>
        <tr>
            <td class="header-column">Сотрудник</td>
            <td class="data-column">                
                <select name="worker_id" class="form-control">
                    <option>- Выбрать сотрудника -</option>
                    <?php foreach($vars['workers'] as $id => $worker) {?>
                        <option value="<?= $id?>" <?php if($id == $vars['form']['worker_id']) {?> selected="selected"<?php } ?>><?= $worker->name?></option>
                    <?php } ?>
                </select>

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