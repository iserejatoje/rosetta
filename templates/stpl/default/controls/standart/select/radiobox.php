<div style="height:<?=$vars['this']->GetRows()* 20?>px;overflow-y:scroll;">
<? foreach($vars['private']['items'] as $item) { ?>
<input type="radio" id="<?=$vars['this']->GetID()?>_item_<?=$item['id']?>" name="<?=$vars['this']->GetID()?>_value[]" value="<?=$item['id']?>"<? if($item['selected']):?> checked="checked"<?endif?>><label for="<?=$vars['this']->GetID()?>_item_<?=$item['id']?>"> <?=$item['title']?></label><br />
<? } ?>
</div>