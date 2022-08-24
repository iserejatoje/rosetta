<form id="<?=$vars['this']->GetID()?>_form" method="<?=$vars['this']->GetMethod()?>" enctype="<?=$vars['this']->GetEncType()?>">
<table width="100%">
<? $count = 0; foreach($vars['private']['items'] as $item) { ?>
<tr<?if($count%2==0):?> class="row_odd"<?endif?>><td class="cell_title"><?=$item['title']?></td><td class="cell_field"><?=$item['ctrl']->Render();?></td></tr>
<? $count++; } ?>
<tr class="row_button"><td class="cell_title">&nbsp;</td><td class="cell_field">
<? foreach($vars['this']->GetButtons() as $item) { ?>
<?=$item->Render();?>
<? } ?>
</td></tr>
</table>
</form>