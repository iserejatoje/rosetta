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
    <input type="hidden" name="id" value="<?=$vars['form']['serviceid']?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">Страница отображается на сайте</td>
            <td class="data-column">
                <input type="checkbox" name="isvisible" value="1"<? if ($vars['form']['isvisible'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">В форме запрашивать дату</td>
            <td class="data-column">
                <input type="checkbox" name="withdate" value="1"<? if ($vars['form']['withdate'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Включить фильтрацию</td>
            <td class="data-column">
                <input type="checkbox" name="hasfilter" value="1"<? if ($vars['form']['hasfilter'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column important">Заголовок<span class="required">*</span></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('title')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="title" value="<?=UString::ChangeQuotes($vars['form']['title'])?>">
            </td>
        </tr>

        <tr>
            <td class="header-column important">URL страницы<span class="required">*</span></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('url')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="url" value="<?=UString::ChangeQuotes($vars['form']['url'])?>">
            </td>
        </tr>

        <tr>
            <td class="header-column">Заголовок формы<br/><small>Необходимо обращать внимание на размер текста</small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('formtitle')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input type="text" name="formtitle" class="form-control" value="<?=$vars['form']['formtitle']?>" />
            </td>
        </tr>

        <tr>
            <td class="header-column">Тема</td>
            <td class="data-column">
                <select name="theme"class="form-control">
                    <option value="0">- укажите тему -</option>
                    <? foreach(ServiceMgr::$THEMES as $k => $item) { ?>
                        <option value="<?=$k?>" <?if($k == $vars['form']['theme']){?> selected="selected"<?}?> ><?=$item['name']?></option>
                    <? } ?>
                </select>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Описание</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('text')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <textarea name="text" class="form-control"><?=$vars['form']['text']?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Текст<br/><small>Рядом с формой</small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('addtext')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <textarea name="addtext" class="form-control"><?=$vars['form']['addtext']?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Фото<br/><small><b>1 920px × 747px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Thumb')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['thumb']['f'])) { ?>
                    <img src="<?=$vars['form']['thumb']['f']?>" style="width: 600px; height: auto;"><br/>
                    <input type="checkbox" name="del_Thumb" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="Thumb" value="" />
            </td>
        </tr>

         <tr>
            <td class="header-column">SeoTitle</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('seotitle')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="seotitle" value="<?=UString::ChangeQuotes($vars['form']['seotitle'])?>">
            </td>
        </tr>
        <tr>
            <td class="header-column">SeoKeywords</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('seokeywords')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="seokeywords" value="<?=UString::ChangeQuotes($vars['form']['seokeywords'])?>">
            </td>
        </tr>
        <tr>
            <td class="header-column">SeoDescription</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('seodescription')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="seodescription" value="<?=UString::ChangeQuotes($vars['form']['seodescription'])?>">
            </td>
        </tr> 


        <tr>
            <td class="header-column">SeoText</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('seotext')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <textarea name="seotext" class="form-control"><?=$vars['form']['seotext']?></textarea>
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