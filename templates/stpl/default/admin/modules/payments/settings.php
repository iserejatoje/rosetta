<style>
    .field-block {
        margin: 3px;
    }
</style>

<script>

    var api = null;
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

    //  ====================================

    function addField(fieldname)
    {
        var list = $('#'+fieldname+'-list');
        var html = $('#'+fieldname+'-etalon').html();

        html = html.replace(/etalon\-/g, "");
        list.append(html);
    }

    function removeField(obj)
    {
        $(obj).closest('.field-block').remove();
    }

</script>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="action" value="<?=$vars['action']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <table class="form table table-sriped">
        <? foreach($vars['config']['payment_types'] as $k => $item) { ?>
        <tr>
            <td class="header-column" colspan="2">
                <label>
                    <input type="checkbox" name="system_enabled[<?=$k?>]" value="1" <?if($item['enabled']==1){?> checked="checked"<?}?>>
                </label>
                <?=$item['name']?>

                <input type="hidden" name="system_name[<?=$k?>]" value="<?=UString::ChangeQuotes($item['name'])?>">
                <input type="hidden" name="system_class[<?=$k?>]" value="<?=$item['class']?>">
                <input type="hidden" name="system_nofolding[<?=$k?>]" value="<?=$item['nofolding']?>">
            </td>
        </tr>
        <tr>
        </tr>
            <? foreach($item['list'] as $code => $type) { ?>
                <tr>
                    <td class="header-column">
                        <?=$type['name']?>

                        <input type="hidden" name="type_name[<?=$k?>][<?=$code?>]" value="<?=UString::ChangeQuotes($type['name'])?>">
                        <input type="hidden" name="type_class[<?=$k?>][<?=$code?>]" value="<?=$type['class']?>">
                        <input type="hidden" name="type_haslabel[<?=$k?>][<?=$code?>]" value="<?=$type['haslabel']?>">
                    </td>
                    <td class="data-column">
                        <input type="checkbox" name="type_enabled[<?=$k?>][<?=$code?>]" value="1" <?if($type['enabled']==1){?> checked="checked"<?}?>>
                    </td>
                </tr>
            <? } ?>
            <td colspan="2"></td>
        <? } ?>

        <tr>
            <td colspan="2" align="center">
                <br/>
                <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            </td>
        </tr>
    </table>
</form>
