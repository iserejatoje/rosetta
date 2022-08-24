<select name="<?=$vars['this']->GetID()?>_value[]">
<? foreach($vars['private']['items'] as $item) { ?>
<option value="<?=$item['id']?>"<? if($item['selected']):?> selected="selected"<?endif?>><?=$item['title']?></option>
<? } ?>
</select>