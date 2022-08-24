<? 
$id = $vars['this']->GetHeader()->GetID(); 
$sort = $vars['this']->GetSortColumn();
$order = $vars['this']->GetSortOrder();
?>
<tr<? if($vars['private']['count'] % 2 == 1): ?> class="row_odd"<? endif ?>>
<? foreach($vars['private']['columns'] as $index => $column) {?>
<td<?if($column['field'] == 'visible'):?> align="center"<?endif?>>
<?if($column['field'] == 'visible'):?>
<?
	$toggle = ControlFactory::GetInstance('extend/toggle', null, array('id' => 'visible_'.$vars['private']['item']['id']));
	$toggle->SetAction(true, 'Да', $vars['private']['item']['fullpath'].'.togglevisible/?id='.$vars['private']['item']['id'].'&visible=1'); // сюда урл для экшена "ВЫКЛ"
	$toggle->SetAction(false, 'Нет', $vars['private']['item']['fullpath'].'.togglevisible/?id='.$vars['private']['item']['id'].'&visible=0'); // сюда урл для экшена "ВКЛ"
	$toggle->SetState($vars['private']['item']['visible']);
	echo $toggle->Render();
?>
<? else: ?>
<?if($column['field'] == ''):?><nobr>
[<? 
	$cmd = array();
	if($vars['this']->GetCustomParam('can_section_view'))
		$cmd[] = '<a href="'.$vars['private']['item']['fullpath'].'.edit/?'.$id.'_scol='.$sort.'&'.$id.'_sord='.$order.'">править</a>';
	if ( $vars['this']->GetCustomParam('can_config_view') )
		$cmd[] = '<a href="javascript:void(0);" onclick="configList(this,'.$vars['private']['item']['id'].');">конфиг</a>';
	if($vars['this']->GetCustomParam('can_env_view'))
		$cmd[] = '<a href="'.$vars['private']['item']['fullpath'].'.env/?'.$id.'_scol='.$sort.'&'.$id.'_sord='.$order.'">окружение</a>';
	if ( $vars['private']['item']['type']==1 && $vars['this']->GetCustomParam('can_block_view') )
		$cmd[] = '<a href="'.$vars['private']['item']['fullpath'].'.blocks?'.$id.'_scol='.$sort.'&'.$id.'_sord'.$order.'">блоки</a>';
	$cmd[] = '<a target="_blank" href="'.$vars['private']['item']['sitepath'].'">на сайте</a>';
	echo '<nobr>'.implode(' | ',$cmd).'</nobr>';
?>]
<? elseif($column['field'] == 'ord'): ?>
	<?=$vars['private']['item'][$column['field']]?>
	<a style="padding:2px 4px 2px 4px;border:solid 1px;text-decoration:none" href=".smoveup?id=<?=$vars['private']['item']['id']?>&<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>">&uarr;</a>
	<a style="padding:2px 4px 2px 4px;border:solid 1px;text-decoration:none" href=".smovedn?id=<?=$vars['private']['item']['id']?>&<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>">&darr;</a>
<? else: ?>
<?if($column['field'] == 'name'): ?><a href="<?=$vars['private']['item']['fullpath']?><?
if($vars['private']['item']['type']==2 || $vars['private']['item']['type']==4):?>.module/<?endif?>?<?=$id?>_scol=<?=$sort?>&<?=$id?>_sord=<?=$order?>"><? endif; ?>
	<?if($vars['private']['item']['deleted']==1):?><span style="color:#CCCCCC;font-size:-1;"><?endif;?>
	<?=$vars['private']['item'][$column['field']]?>
	<?if($vars['private']['item']['deleted']==1):?></span><?endif;?>
<?if($column['field'] == 'name'): ?></a><? endif; ?>
<? endif ?>
<? endif ?>
</td>
<? } ?>
<? if($vars['this']->GetSelectMode()=='single'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="radio"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
<? if($vars['this']->GetSelectMode()=='multi'): ?><td><input name="<?=$vars['this']->GetID()?>_item[]" value="<?=$vars['private']['index']?>" type="checkbox"<?if($vars['this']->IsSelected($vars['private']['index'])):?> checked="checked"<? endif ?> /></td><? endif ?>
</tr>