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

<? if ($vars['form']['ProductID'] > 0) { ?>
    <?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

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
    <input type="hidden" name="id" value="<?=$vars['form']['ProductID']?>" />
    <input type="hidden" name="TypeID" value="<?=$vars['form']['TypeID']?>" />
    <input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />

    <table class="form table table-sriped">
        <?php /*

        <tr>
            <td class="header-column">Товар отображается на сайте</td>
            <td class="data-column">
                <input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        */ ?>

        <tr>
            <td class="header-column important">Артикул<span class="required">*</span></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Article')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="Article" value="<?=UString::ChangeQuotes($vars['form']['Article'])?>">
            </td>
        </tr>

        <tr>
            <td class="header-column">Хит</td>
            <td class="data-column">
                <input type="checkbox" name="IsHit" value="1"<? if ($vars['form']['IsHit'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">New</td>
            <td class="data-column">
                <input type="checkbox" name="IsNew" value="1"<? if ($vars['form']['IsNew'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Акция</td>
            <td class="data-column">
                <input type="checkbox" name="IsShare" value="1"<? if ($vars['form']['IsShare'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Товар есть в наличии</td>
            <td class="data-column">
                <input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Отображать на главное<br/>(в слайдере)</td>
            <td class="data-column">
                <input type="checkbox" name="InSlider" value="1"<? if ($vars['form']['InSlider'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Скидка <?php //= CatalogMgr::getDiscountValue() ?>%</td>
            <td class="data-column">
                <input type="checkbox" name="ExcludeDiscount" value="1"<? if ($vars['form']['ExcludeDiscount'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Процент скидки</td>
            <td class="data-column">
                <input class="form-control"  type="text" name="Discount" value="<?= $vars['form']['Discount']?>">
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Тема</td>
            <td class="data-column">
                <select name="Theme" class="form-control">
                    <option value="0">- Укажите тему -</option>
                    <? foreach(CatalogMgr::$THEMES as $k => $theme) { ?>
                        <option value="<?=$k?>" <?if($k == $vars['form']['Theme']){?> selected="selected"<?}?>><?=$theme['name']?></option>
                    <? } ?>
                </select>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column important">Название товара<span class="required">*</span></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
            </td>
        </tr>

        <? if($vars['category']->Kind == CatalogMgr::CK_ROSE) { ?>
            <tr>
                <td class="header-column important">Количество<span class="required">*</span></td>
                <td class="data-column">
                    <? if (($err = UserError::GetErrorByIndex('RoseCount')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                    <? } ?>
                    <input class="form-control" name="Count" value="<?=UString::ChangeQuotes($vars['form']['Count'])?>">
                </td>
            </tr>

            <tr><td class="separator" colspan="2"></td></tr>
        <? } ?>

        <tr>
            <td class="header-column">Описание<br/><small>Отображает в карточке товара</small></td>
            <td class="data-column">
                <textarea class="form-control" name="Text"><?=UString::ChangeQuotes($vars['form']['Text'])?></textarea>
            </td>
        </tr>

        <tr>
            <td class="header-column">Состав</td>
            <td class="data-column">
                <textarea class="form-control" name="CompositionText"><?=UString::ChangeQuotes($vars['form']['CompositionText'])?></textarea>
            </td>
        </tr>
<?/*
        <tr>
            <td class="header-column">Отметка о сезонности составляющих букета</td>
            <td class="data-column">
                <textarea class="form-control" name="ShortDesc"><?=UString::ChangeQuotes($vars['form']['ShortDesc'])?></textarea>
            </td>
        </tr>
*/?>
        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Фото для каталога<br/><small><b>768х973px</b></small></td>
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
            <td class="header-column">Фото для корзины основная<br/><small><b>392х341px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('PhotoCart')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoCart']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoCart']['f']?>"><br/>
                    <input type="checkbox" name="del_PhotoCart" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoCart" value="" />
            </td>
        </tr>

        <tr>
            <td class="header-column">Фото отображение в слайдере на главной<br/><small><b>1920 × 400px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('PhotoSlider')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoSlider']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoSlider']['f']?>" style="max-width: 1000px"><br/>
                    <input type="checkbox" name="del_PhotoSlider" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoSlider" value="" />
            </td>
        </tr>

        <? /*
        <tr>
            <td class="header-column">Фото для корзины маленькая<br/></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('PhotoCartSmall')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoCartSmall']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoCartSmall']['f']?>"><br/>
                    <input type="checkbox" name="del_PhotoCartSmall" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoCartSmall" value="" />
            </td>
        </tr>
        */ ?>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">SEO Title</td>
            <td class="data-column">
                <input type="text" class="input-text-field" name="SeoTitle" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoTitle']))?>"><br/>
            </td>
        </tr>

        <tr>
            <td class="header-column">SEO Description</td>
            <td class="data-column">
                <input type="text" class="input-text-field" name="SeoDescription" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoDescription']))?>"><br/>
            </td>
        </tr>

        <tr>
            <td class="header-column">SEO Keywords</td>
            <td class="data-column">
                <input type="text" class="input-text-field" name="SeoKeywords" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoKeywords']))?>"><br/>
            </td>
        </tr>

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