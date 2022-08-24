<? 
$id = $vars['this']->GetHeader()->GetID(); 
$sort = $vars['this']->GetSortColumn();
$order = $vars['this']->GetSortOrder();
?>
<tr>
<? foreach($vars['private']['columns'] as $index => $column) {?>
<td>
<?if($column['field'] == 'name'): ?><a href="<?=$vars['private']['item']['fullpath']?>?<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>"><? endif; ?>
	<?=$vars['private']['item'][$column['field']]?>
<?if($column['field'] == 'name'): ?></a><? endif; ?>
</td>
<? } ?>
<? if($vars['this']->GetSelectMode()=='single'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="radio"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
<? if($vars['this']->GetSelectMode()=='multi'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="checkbox"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
</tr>