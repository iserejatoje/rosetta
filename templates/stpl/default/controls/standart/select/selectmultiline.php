<select name="<?=$vars['this']->GetID()?>_value[]" multiple="multiple" size="<?=$vars['this']->GetRows()?>">
<? foreach($vars['private']['items'] as $item) { ?>
<option value="<?=$item['id']?>"<? if($item['selected']):?> selected="selected"<?endif?>><?=$item['title']?></option>
<? } ?>
</select>