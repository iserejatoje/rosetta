<div class="pagination clearfix">
	<? if (!empty($vars['pages']['back'])) {?>
		<a href="<?=$vars['pages']['back']?>" class="arrow arrow-left"></a>
	<? }  ?>

	<? foreach ($vars['pages']['btn'] as $l) { ?>
		<? if (!$l['active']) { ?>
			<a href="<?=$l['link']?>" class="page"><?=$l['text']?></a>
		<? } else { ?>
			<a href="<?=$l['link']?>" class="page active"><?=$l['text']?></a>
		<?}
	} ?>

    <? if (!empty($vars['pages']['next'])) { ?>
    	<a href="<?=$vars['pages']['next']?>" class="arrow arrow-right"></a>
    <? } ?>
</div>