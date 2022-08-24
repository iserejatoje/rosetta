{include file="`$TEMPLATE.sectiontitle`" type="0"}

{if $page.node}

{$page.node.text}
<br/><br/>
{else}
	<div align="center"><span class="error">Запрошенный Вами раздел не найден.</span><br/><br/>
	<a href="#" onclick="window.history.go(-1);return false;">Назад</a>
	</div>
{/if}