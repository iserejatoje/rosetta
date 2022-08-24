<tr>
<? foreach($vars['private']['columns'] as $index => $column) {?>
<td><? if(isset($column['href'])):?><a href="<?=$vars['private']['item'][$column['href']]?>"><? endif; ?><?=$vars['private']['item'][$column['field']]?><? if(isset($column['href'])):?></a><? endif; ?></td>
<? } ?>
<? if($vars['this']->GetSelectMode()=='single'): ?><td><input name="<?=$vars['this']->GetID?>_item[]" value="<?=$vars['private']['index']?>" type="radio" /></td><? endif ?>
<? if($vars['this']->GetSelectMode()=='multi'): ?><td><input name="<?=$vars['this']->GetID?>_item[]" value="<?=$vars['private']['index']?>" type="checkbox" /></td><? endif ?>
</tr>