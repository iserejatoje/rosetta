<ul class="ctrl_extend_menu_items" id="<?=$vars['this']->GetID()?>_menu">
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
var <?=$vars['this']->GetID()?>_timeout;
$('#<?=$vars['this']->GetID()?>_menu').dropDownMenu({timer: 500, parentMO: 'parent-hover', childMO: 'child-hover1'});
$('#<?=$vars['this']->GetID()?>_menu').bind("mouseleave", function() {
	<?=$vars['this']->GetID()?>_timeout = setTimeout(function(){
		$('#config_list_container').remove();
	}, 500);
}).bind("mouseenter", function() {
	clearTimeout(<?=$vars['this']->GetID()?>_timeout);
});
</script>

<div style="clear:both"></div>
