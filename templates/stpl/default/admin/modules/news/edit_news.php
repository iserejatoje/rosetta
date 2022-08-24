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
    <input type="hidden" name="id" value="<?=$vars['form']['NewsID']?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">Отображать на сайте</td>
            <td class="data-column">
                <input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Заголовок</td>
            <td class="data-column">
                <input type="text" name="Title" class="form-control" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>">
            </td>
        </tr>

        <tr>
            <td class="header-column">Дата публикации</td>
            <td class="data-column">
                <input type="text" name="Published" class="form-control" value="<?=UString::ChangeQuotes(date('d.m.Y', $vars['form']['Published']))?>">
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Анонс</td>
            <td class="data-column">
                <textarea class="form-control" name="Announce"><?=UString::ChangeQuotes($vars['form']['Announce'])?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Текст новости</td>
            <td class="data-column">
                <textarea class="form-control" name="Text"><?=UString::ChangeQuotes($vars['form']['Text'])?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Фото<br/><small><b>(392px × 392px)</b></small></td>
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