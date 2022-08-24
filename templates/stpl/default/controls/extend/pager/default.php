<? if(!empty($vars['private']['pages']['btn']) && count($vars['private']['pages']['btn'])>1): ?>
	<div><? $count = $vars['this']->GetItemsCount()?><? if ( $count !== false ): ?>Всего: <?=$count?> <? endif; ?>Страницы:
	<? if($vars['private']['pages']['first']): ?>
		<a href="<?=$vars['private']['pages']['first']?>" class="fpageslink">первая</a>
	<? endif; ?>
	<? if($vars['private']['pages']['back']!=""): ?><a href="<?=$vars['private']['pages']['back']?>" class="fpageslink">&lt;&lt;</a><? endif; ?>
	<? foreach($vars['private']['pages']['btn'] as $l) { ?>
		<? if(!$l['active']) { ?>
			&nbsp;<a href="<?=$l['link']?>" class="fpageslink"><?=$l['text']?></a>
		<? } else { ?>
			&nbsp;<span class="current"> <?=$l['text']?> </span>
		<? } ?>
	<? } ?>
	<? if($vars['private']['pages']['next']!=""): ?>&nbsp;<a href="<?=$vars['private']['pages']['next']?>" class="fpageslink">&gt;&gt;</a><? endif; ?>
	<? if($vars['private']['pages']['last']): ?>
		<a href="<?=$vars['private']['pages']['last']?>" class="fpageslink">последняя</a>
	<? endif; ?>
	<br clear="both"/>
	</div><br clear="both"/>
<? endif; ?>