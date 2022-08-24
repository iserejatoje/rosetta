<ul class="s-menu">
	<? foreach($vars['menu'] as $item) { ?>
    	<li><a href="<?=$item->Link?>" <?if($item->ID==$vars['active']){?> class="active"<?}?>><?=$item->Name?></a></li>
    <? } ?>
</ul>