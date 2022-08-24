{if count($res.values)}
<table width="100%" cellspacing="0" cellpadding="3" border="0">
{foreach from=$res.values item=l}
	<tr><td class="dop3"><img src="/_img/design/200710_auto/bull-spis.gif" width="9" height="7"> {$l}</td></tr>
{/foreach}
	<tr><td align="right"><a href="http://www.carkarta.ru/traffic/" target="_blank">Пробки Уфы на Каркарта.ру</a></td></tr>
</table>
{/if}