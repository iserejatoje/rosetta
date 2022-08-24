<?
if (is_array($vars['pages']['btn']) && sizeof($vars['pages']['btn'])) {
	ob_start();

	if (!empty($vars['pages']['back'])) {
		?><div class="page prev"><a href="<?=$vars['pages']['back']?>" title="Предыдущая страница">предыдущая</a></div><?
	}
	foreach ($vars['pages']['btn'] as $l) {
		if (!$l['active']) {
			?><div class="page"><a href="<?=$l['link']?>"><?=$l['text']?></a></div><?
		} else {
			?><div class="page active"><?=$l['text']?></div><?
		}
	}
	if (!empty($vars['pages']['next'])) {
		?><div class="page next"><a href="<?=$vars['pages']['next']?>" title="Следующая страница">следующая</a></div><?
	}

	$pageslink = ob_get_clean();
} ?>

<div class="pages">
	<?=$pageslink?>
</div>