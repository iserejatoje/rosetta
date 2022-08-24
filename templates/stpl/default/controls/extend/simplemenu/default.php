<ul id="<?=$vars['this']->GetID()?>_menu">
<? foreach($vars['private']['items'] as $i): ?>
	<? DisplayItem($i) ?>
<? endforeach; ?>
</ul>

<?
	function DisplayItem($item) {?>
		<li><a href="<? if ( !empty($item->url) ): ?><?=$item->url?><? else: ?>javascript:;<? endif; ?>"<? if ( !empty($item->action) ): ?>onclick="<?=$item->action?>"<? endif; ?>><?=$item->title?></a>
		<?
		if ( is_array($item->items) && count($item->items) > 0 ) {
			echo "<ul>";
			foreach($item->items as $i)
				DisplayItem($i);
			echo "</ul>";
		}
		?>
		</li>
	<?}
?>

<script type="text/javascript" language="javascript">
$('#<?=$vars['this']->GetID()?>_menu').simplemenu();
</script>

<div style="clear:both"></div>