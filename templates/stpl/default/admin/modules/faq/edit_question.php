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
    <input type="hidden" name="id" value="<?=$vars['form']['QuestionID']?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">Пользователь</td>
            <td class="data-column"><?=$vars['form']['Username']?></td>
        </tr>

        <tr>
            <td class="header-column">Телефон</td>
            <td class="data-column"><?=$vars['form']['Phone']?></td>
        </tr>

        <tr>
            <td class="header-column">E-mail</td>
            <td class="data-column"><?=$vars['form']['Email']?></td>
        </tr>

        <tr>
            <td class="header-column">Отображать насайте</td>
            <td class="data-column">
                <input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Вопрос</td>
            <td class="data-column">
                <textarea class="form-control" name="Question"><?=UString::ChangeQuotes($vars['form']['Question'])?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Ответ</td>
            <td class="data-column">
                <textarea class="form-control" name="Answer"><?=UString::ChangeQuotes($vars['form']['Answer'])?></textarea>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr><td class="separator" colspan="2"><div></div></td></tr>

        <tr>
            <td colspan="2" align="center">
                <br/>
                <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            </td>
        </tr>
    </table>
</form>

<? } ?>