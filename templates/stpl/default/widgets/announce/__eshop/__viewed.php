<? if (count($vars['list']) > 0) { ?>
	<span class="hot-title"><?=UString::AccentFirstWord("Недавно просмотренные товары", "#00aeef", "#83bc2b")?></span><br/>
	<div class="viewed">
	<? foreach($vars['list'] as $item) { ?>
		<div class="viewed-item" style="background-image:url(<?=$item['logotype']?>)" onclick="location.href='<?=$item['url']?>'">
			<div class="viewed-name"><a href="<?=$item['url']?>"><?=$item['name']?><? if ($item['manufacturer'] != "") { ?>, <?=$item['manufacturer']?><? } ?></a></div>
			<div class="viewed-price"><?=$item['price']?> руб.</div>
		</div>
	<? } ?>
	</div>
	<br clear="both"/>
<? } ?>