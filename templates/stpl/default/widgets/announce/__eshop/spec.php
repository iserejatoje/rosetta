<div class="main-special col-md-12 clearfix">
	<? foreach($vars['banners'] as $item) { ?>
		<? if($item->Url) { ?>
			<a class="special-item col-md-4" href="<?=$item->Url?>">
				<div class="special-item-title"><?=$item->BannerText?></div>
				<div class="special-item-image">
					<img src="<?=$item->File['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($item->BannerText)?>">
				</div>
			</a>
		<? } else { ?>
			<div class="special-item col-md-4">
				<div class="special-item-title"><?=$item->BannerText?></div>
				<div class="special-item-image">
					<img src="<?=$item->File['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($item->BannerText)?>">
				</div>
			</div>
		<? } ?>
	<? } ?>
</div>