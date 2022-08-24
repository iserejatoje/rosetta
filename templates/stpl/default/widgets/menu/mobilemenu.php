<ul class="mobile-menu">
<? foreach($vars['catalog'] as $item) { ?>
	<? if($item['isvisible'] == 0)
		continue;
	?>
	<li class="menu-item<?if(strpos($_SERVER['REQUEST_URI'],'/catalog/'.$item["url"].'/') !== false){?> active<?}?>">
		<a href="/catalog/<?=$item['url']?>/">
		<?=$item['name']?></a>
	</li>

<? } ?>
</ul>