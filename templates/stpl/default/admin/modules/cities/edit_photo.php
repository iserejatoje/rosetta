<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }
</style>

<? if (($err = UserError::GetErrorByIndex('global')) != '' )
{?>
    <h3><?=$err?></h3><br/>
<? }
else
{ ?>


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
    <input type="hidden" name="id" value="<?=$vars['form']['PhotoID']?>" />
    <input type="hidden" name="storeid" value="<?=$vars['storeid']?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">Отображать на сайте</td>
            <td class="data-column">
                <input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Название</td>
            <td class="data-column">
                <input type="text" class="form-control" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
            </td>
        </tr>

        <tr>
            <td class="header-column">Маленькое фото для списка<br/><small><b>262px × 262px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('PhotoSmall')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoSmall']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoSmall']['f']?>"><br/>
                    <input type="checkbox" name="del_PhotoSmall" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoSmall" value="" />
            </td>
        </tr>

        <tr>
            <td class="header-column">Большое фото в списке<br/><small><b>393px × 392px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('PhotoBig')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoBig']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoBig']['f']?>"><br/>
                    <input type="checkbox" name="del_PhotoBig" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoBig" value="" />
            </td>
        </tr>

        <tr>
            <td class="header-column">Большое фото всплывающее<br/><small><b>в пределах 1024px × 1024px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['Photo']['f'])) { ?>
                    <img src="<?=$vars['form']['Photo']['f']?>"><br/>
                    <input type="checkbox" name="del_Photo" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="Photo" value="" />
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