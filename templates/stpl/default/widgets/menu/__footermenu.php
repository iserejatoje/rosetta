<ul class="footer-menu">
	<? foreach($vars['menu'] as $item) { ?>
    	<li><a href="<?=$item->Link?>" class="f-menu-item <?if($item->ID==$vars['active']){?> active<?}?>"><?=$item->Name?></a></li>
    <? } ?>
</ul>