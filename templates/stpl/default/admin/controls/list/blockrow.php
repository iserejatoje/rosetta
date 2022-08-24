<?
//2514
$id = $vars['this']->GetHeader()->GetID(); 
$sort = $vars['this']->GetSortColumn();
$order = $vars['this']->GetSortOrder();
?>
<tr<? if($vars['private']['count'] % 2 == 1): ?> class="row_odd"<? endif ?>>
<? foreach($vars['private']['columns'] as $index => $column): ?>

<td <? if ($column['field'] == 'IsVisible'):?> align="center" bgcolor="<?if ($vars['private']['item']['IsVisible']): ?>#00FF00<?else:?>#FF0000<? endif; ?>"
<? elseif ($column['field'] == 'Cache'):?> align="center" bgcolor="<?if ($vars['private']['item']['Cache']): ?>#00FF00<?else:?>#FF0000<? endif; ?>"
<? elseif ($column['field'] == 'IsLast'):?> align="center" bgcolor="<?if ($vars['private']['item']['IsLast']): ?>#00FF00<?else:?>#FF0000<? endif; ?>"
<? elseif ($column['field'] == 'IsRand'):?> align="center" bgcolor="<?if ($vars['private']['item']['IsRand']): ?>#00FF00<?else:?>#FF0000<? endif; ?>"
<?endif?>>

<? if($column['field'] == 'IsVisible'):?><?if ($vars['private']['item']['IsVisible']): ?>Да<?else:?>Нет<? endif; ?>
<? elseif($column['field'] == 'Cache'):?><?if ($vars['private']['item']['Cache']): ?>Да<?else:?>Нет<? endif; ?>
<? elseif($column['field'] == 'IsLast'):?><?if ($vars['private']['item']['IsLast']): ?>Да<?else:?>Нет<? endif; ?>
<? elseif($column['field'] == 'IsRand'):?><?if ($vars['private']['item']['IsRand']): ?>Да<?else:?>Нет<? endif; ?>
<? elseif($column['field'] == 'Name'): ?>
	<a href=".editblock?blockid=<?=$vars['private']['item']['BlockID']?>&<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>">
		<?=$vars['private']['item'][$column['field']]?>
	</a>
<? elseif($column['field'] == 'Type'): ?><?=BL_system_blocks::$Types[$vars['private']['item'][$column['field']]]?>
<? elseif($column['field'] == 'Ord'): ?>
	<?=$vars['private']['item'][$column['field']]?>
	<a style="padding:2px 4px 2px 4px;border:solid 1px;text-decoration:none" href=".moveup?blockid=<?=$vars['private']['item']['BlockID']?>&<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>">&uarr;</a>
	<a style="padding:2px 4px 2px 4px;border:solid 1px;text-decoration:none" href=".movedn?blockid=<?=$vars['private']['item']['BlockID']?>&<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>">&darr;</a>
<? elseif($column['field'] == 'BlockID'): ?>
	<?=str_repeat('&bull;&nbsp;', $vars['private']['item']['Level'])?>
	<?=$vars['private']['item'][$column['field']]?>
<? else: ?>
	<?=$vars['private']['item'][$column['field']]?>
<? endif;?>
</td>

<? endforeach; ?>
<? if($vars['this']->GetSelectMode()=='single'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="radio"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
<? if($vars['this']->GetSelectMode()=='multi'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="checkbox"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
</tr>