<select name="<?=$vars['this']->GetID()?>_value[]">
<? foreach($vars['private']['items'] as $item) { ?>
<option value="<?=$item['id']?>"><?=$item[$vars['private']['field']]?></option>
<? } ?>
</select>