<? if($vars['private']['standalone']): ?>
<table width="100%">
<? endif; ?>
<tr>
<? foreach($vars['private']['columns'] as $k=>$l) { ?>
<th<?if(!empty($l['width']))echo ' width="'.$l['width'].'"';?>>
	<? if(!empty($l['url'])): ?><a href="<?=$l['url']?>"><? endif; ?><?=$l['title']?><? if(!empty($l['url'])): ?></a><? endif; ?>
<?
if($k==$vars['this']->GetSortColumn()){
	if(0 == $vars['this']->GetSortOrder())
		echo '/\\';
	else
		echo '\\/';
}?>
</th>
<? } ?>
</tr>
<? if($vars['private']['standalone']): ?>
</table>
<? endif; ?>