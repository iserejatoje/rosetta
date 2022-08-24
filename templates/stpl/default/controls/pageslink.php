<?
/*
 *	Постраничная навигация
 *		pageslink (array) - массив с постраничкой
 *		[aclass (char)] - класс ссылки
*/
?>
<?

	if ( empty($vars['active_page_class']) )
		$vars['active_page_class'] = 'pageslink_active';
		
	if ( empty($vars['aclass']) )
		$vars['aclass'] = 'pageslink';

?>
<? if ( is_array($vars['pageslink']) && count($vars['pageslink']['btn']) ): ?>
<div class="pager">
	<? if ( !isset($vars['showtitle']) || $vars['showtitle'] === true ): ?>
		<span class="ptitle">Страницы:</span>
	<? endif; ?>
	<? if ( $vars['pageslink']['first'] != "" && $vars['pageslink']['first'] != $vars['pageslink']['current']): ?>
		<a href="<?=$vars['pageslink']['first']?>" <? if ($vars['aclass']): ?>class="<?=$vars['aclass']?>"<? endif; ?>/>первая</a>
	<? endif; ?>
		
	<? if ($vars['pageslink']['back'] != ""): ?>
		<a href="<?=$vars['pageslink']['back']?>" title="предыдущая страница" <? if ($vars['aclass']): ?>class="<?=$vars['aclass']?>"<? endif; ?>/>&lt;&lt;</a>
	<? endif; ?>
	
	<? foreach ($vars['pageslink']['btn'] as $l): ?>
		<? if ( !$l['active'] ): ?>
			&nbsp;<a  href="<?=$l['link']?>" <? if ($vars['aclass']): ?>class="<?=$vars['aclass']?>"<? endif; ?>><?=$l['text']?></a>&nbsp;
		<? else: ?>
			&nbsp;<span class="<?=$vars['active_page_class']?>"><?=$l['text']?></span>&nbsp;
		<? endif; ?>
	<? endforeach; ?>

	<? if ( $vars['pageslink']['next'] != "" ): ?>
		<a href="<?=$vars['pageslink']['next']?>" title="следующая страница" <? if ($vars['aclass']): ?>class="<?=$vars['aclass']?>"<? endif; ?>>&gt;&gt;</a>
	<? endif; ?>
	<? if ( $vars['pageslink']['last'] != "" && $vars['pageslink']['last'] != $vars['pageslink']['current']): ?>
		<a href="<?=$vars['pageslink']['last']?>" <? if ($vars['aclass']): ?>class="<?=$vars['aclass']?>"<? endif; ?>>последняя</a>
	<? endif; ?>
<br clear="both"/>
</div><br clear="both"/>
<? endif; ?>