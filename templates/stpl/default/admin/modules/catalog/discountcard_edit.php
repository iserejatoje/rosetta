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

<?
    $order = $vars['order'];
    $card = $vars['discountcard'];
?>

<form name="new_object_form" method="post" enctype="multipart/form-data">

    <input type="hidden" name="action" value="<?=$vars['action']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <input type="hidden" name="id" value="<?=$vars['discountcard']->id?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">Активация</td>
            <td class="data-column">
                <input type="checkbox" name="isactive" value="1"<? if ($vars['form']['isactive'] == 1) { ?> checked="checked"<? } ?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Номер карты</td>
            <td class="data-column"><?=$card->code?></td>
        </tr>

        <tr>
            <td class="header-column">Скидка, %</td>
            <td class="data-column">
                <input type="number" name="discount" value="<?= $vars['form']['discount'] ?>" class="form-control">
            </td>
        </tr>

        <tr>
            <td class="header-column">Дата создания</td>
            <td class="data-column"><?=date('d.m.Y H:i:s', $card->created)?></td>
        </tr>


        <tr>
            <td class="header-column">Номер заказа</td>
            <td class="data-column">
                <?=$card->orderid?>
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_order&id=<?=$order->id?>" target="_blank">
                    <span class="label label-info">Посмотреть заказ</span>
                </a>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Имя получателя карты</td>
            <td class="data-column"><?=$order->customername?></td>
        </tr>

        <tr>
            <td class="header-column">Телефон получателя карты</td>
            <td class="data-column"><?=$order->customerphone?></td>
        </tr>

        <tr>
            <td class="header-column">Email получателя карты</td>
            <td class="data-column"><?=$order->customeremail?></td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <br/>
                <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            </td>
        </tr>
        <? /*
        */?>
    </table>
</form>

<? } ?>