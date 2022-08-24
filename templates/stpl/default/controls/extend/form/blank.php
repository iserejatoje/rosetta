<form id="<?=$vars['this']->GetID()?>_form" method="<?=$vars['this']->GetMethod()?>" enctype="<?=$vars['this']->GetEncType()?>">
<? $count = 0; foreach($vars['private']['items'] as $item) { ?>
<?=$item['ctrl']->Render();?>
<? $count++; } ?>
<br />
<? foreach($vars['this']->GetButtons() as $item) { ?>
<?=$item->Render();?>
<? } ?>
</form>