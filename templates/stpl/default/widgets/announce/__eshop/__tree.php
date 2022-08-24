<?
LibFactory::GetStatic('ustring');
?>
<script type="text/javascript" language="javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.hoverpulse.js" charset="utf-8"></script>
<script language="javascript">
	$(document).ready(function(){
		 $('.category-item IMG').hoverpulse({
			size: 11,
			speed: 150
		 });
		 
		  $('.pizza-noodles IMG').hoverpulse({
			size: 10,
			speed: 150
		 });
	});
</script>
<div class="categories-list">
	<? foreach($vars['childs'] as $node) { ?>
	<div class="category-item">
		<div class="category-photo">
			<img src="<?=$node->Icon['f']?>" title="<?=UString::ChangeQuotes($node->Title)?>" width="147px" height="147px" style="display:none;" onload="$('.category-item .loading<?=$node->ID?>').fadeOut('fast').remove();$(this).fadeIn('fast')" alt="<?=UString::ChangeQuotes($node->Title)?>" onclick="location.href='/eshop/<?=$node->NameID?>/'">
			<img src="/resources/img/design/takemix/loading.gif" class="loading<?=$node->ID?>" style="padding-left:57px;padding-top:57px;"/>
		</div>
		<div class="category-name"><a href="/eshop/<?=$node->NameID?>/"><?=strtolower($node->Title)?></a></div>
	</div>
	<? } ?>
	<br clear="both"/>
</div>