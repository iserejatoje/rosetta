<? if (count($vars['list']) > 0) { ?>
	<div class="header-hot-title" onclick="$('#hot-offer-container').slideToggle('fast');"><span class="hot-title"><?=UString::AccentFirstWord("Похожие товары", "#f8285c", "#069dc4")?></span></div>
	<div class="hot-offer-container" id="hot-offer-container">
		<? foreach($vars['list'] as $item) { ?>
			<div class="hot-offer-usual" 
				style="background-image:url(<?=$item['product']['logo']['f']?>)" 
				title="<?=Ustring::ChangeQuotes($item['product']['name'])?>"
				onclick="location.href='<?=($vars['link'].$item['url'])?>';">
				<div class="hot-offer-price-container">
					<?
						$price_str = number_format($item['product']['price'], 0, "", "");
					?>
					<div class="hot-offer-price" style="font-size:<?=(24/strlen($price_str) * 3)?>px">
						<?=$price_str?><span class="val">р</span>
					</div>					
				</div>
				<div class="hot-offer-name">
					<a href="<?=($vars['link'].$item['url'])?>" title="<?=Ustring::ChangeQuotes($item['product']['name'])?>"><?=UString::Truncate($item['product']['name'], 80)?><? if ($item['manufacturer'] !== null) { ?>, <?=$item['manufacturer']['name']?><? } ?></a>
				</div>
			</div>		
		<? } ?>
		<br clear="both"/>
	</div>
<? } ?>