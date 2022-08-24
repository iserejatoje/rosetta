<?
/*
 *	Постраничная навигация
 *		pageslink (array) - массив с постраничкой
*/
?>

<? if ( is_array($vars['pageslink']) ): ?>
	<? if ( !empty($vars['pageslink']['back']) ): ?><a href="<?=$vars['pageslink']['back']?>">&lt;&lt;</a>&nbsp;<? endif; ?>
	<? foreach ( $vars['pageslink']['btn'] as $l ): ?>
		<? if ( $l['active'] == 0 ): ?><a href="<?=$l['link']?>"><? else: ?><b><? endif; ?><?=$l['text']?><? if ( $l['active'] == 0 ): ?></a><? else: ?></b><? endif; ?>&nbsp;
	<? endforeach; ?>
	<? if ( !empty($vars['pageslink']['next']) ): ?><a href="<?=$vars['pageslink']['next']?>">&gt;&gt;</a><? endif; ?>
<? endif; ?>
