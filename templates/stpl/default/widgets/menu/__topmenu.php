<? foreach($vars['menu'] as $item) { ?>
	<li <?if($item->ID==$vars['active']){?> class="active"<?}?>><a href="<?=$item->Link?>"><?=$item->Name?></a></li>
<? } ?>