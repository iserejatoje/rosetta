<?
	LibFactory::GetStatic('ustring');
?>
<div class="hot-container">	
	<span class="hot-title"><?=UString::AccentFirstWord("Горячее предложение", "#f8285c", "#069dc4")?><br/><br/>
	<div class="hot-offer-container">
		<? foreach($vars['list'] as $item) { ?>
			<div class="hot-offer-usual" 
				style="background-image:url(<?=$item['product']->LogotypeSmall['f']?>)" 
				title="<?=Ustring::ChangeQuotes($item['product']->Name)?>"
				onclick="location.href='<?=($vars['link'].$item['url'])?>';">
				<div class="hot-offer-price-container">
					<?
						$price_str = number_format($item['product']->Price, 0, "", "");
					?>
					<div class="hot-offer-price" style="font-size:<?=(24/strlen($price_str) * 3)?>px">
						<?=$price_str?><span class="val">р</span>
					</div>					
				</div>
				<div class="hot-offer-name">
					<a href="<?=($vars['link'].$item['url'])?>" title="<?=Ustring::ChangeQuotes($item['product']->Name)?>"><?=UString::Truncate($item['product']->Name, 80)?><? if ($item['manufacturer'] !== null) { ?>, <?=$item['manufacturer']->Name?><? } ?></a>
				</div>
			</div>		
		<? } ?>
		<br clear="both"/>
	</div>
</div>
