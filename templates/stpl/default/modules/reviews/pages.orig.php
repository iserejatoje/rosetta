<?
if (is_array($vars['pages']['btn']) && sizeof($vars['pages']['btn'])) {
	ob_start();

	if (!empty($vars['pages']['back'])) {
		?><li class="prev"><a href="<?=$vars['pages']['back']?>"></a></li><?
	} /* else {
	?>
	<div class="page prev"><a href="javascript:void(0)" title="налево сейчас нельзя"><img src="/resources/img/design/takemix/larrow-unactive.png"/></a></div>
	<?
	} */
	foreach ($vars['pages']['btn'] as $l) {
		if (!$l['active']) {
			?><li><a href="<?=$l['link']?>"><?=$l['text']?></a></li><?
		} else {
			?><li class="active"><a href="<?=$l['link']?>"><?=$l['text']?></a></li><?
		}
	}
	if (!empty($vars['pages']['next'])) {
		?><li class="next"><a href="<?=$vars['pages']['next']?>"></a></li><?
	} /* else {
	?>
	<div class="page next"><a href="javascript:void(0)" title="направо сейчас нельзя"><img src="/resources/img/design/takemix/rarrow-unactive.png"/></a></div>
	<?
	} */

	$pageslink = ob_get_clean();
?>

<ul class="pagination">
<?=$pageslink?>
</ul>
<? } ?>