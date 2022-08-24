{if !(empty($BLOCK.rus.data) && empty($BLOCK.ino.data))}
<table width="100%" cellspacing="3" cellpadding="0" >
	<tr><td class="block_title_obl" style="padding-left: 15px;" align="left"><span>{$ENV.site.title.advertise}</span></td></tr>
</table>
<table border="0" cellspacing="3" cellpadding="4" width="100%">
{if !empty($BLOCK.ino.data)}
<tr><td class="zag1" valign="top" bgcolor="#edf6f8">{$BLOCK.ino.name}{if $BLOCK.ino.cnt} <font class="t7">({$BLOCK.ino.cnt})</font>{/if}</td></tr>
<tr><td valign="top" class="text11">
	{foreach from=$BLOCK.ino.data item=l name=avto}
	{if $l.count}
		<nobr><a href="/advertise/search/?type=0&parent={$l.id}&search=%CD%E0%E9%F2%E8&model=-1" target="_blank">{$l.name}</a></nobr>{if !$smarty.foreach.avto.last},{/if}
	{/if}
	{/foreach}
</td></tr>
<tr><td align="right"><small><a href="/advertise/offer/{$BLOCK.ino.modname}/"><b>Все марки</b></a></small></td></tr>
{/if}
{if !empty($BLOCK.rus.data)}
<tr><td class="zag1" valign="top" bgcolor="#edf6f8">{$BLOCK.rus.name}{if $BLOCK.rus.cnt} <font class="t7">({$BLOCK.rus.cnt})</font>{/if}</td></tr>
<tr><td valign="top" class="text11">
	{foreach from=$BLOCK.rus.data item=l name=avto}
	{if $l.count}
		<nobr><a href="/advertise/search/?type=0&parent={$l.id}&search=%CD%E0%E9%F2%E8&model=-1" target="_blank">{$l.name}</a></nobr>{if !$smarty.foreach.avto.last},{/if}
	{/if}
	{/foreach}
</td></tr>
<tr><td align="right"><small><a href="/advertise/offer/{$BLOCK.rus.modname}/"><b>Все марки</b></a></small></td></tr>
{/if}
</table>
<table border="0" cellspacing="3" cellpadding="0" width="100%">
<tr>
<td align="right" class="otzyv">
	За сутки добавлено <b>{$BLOCK.allcnt|intval}</b> {word_for_number number=$BLOCK.allcnt first="объявление" second="объявления" third="объявлений"}
	<br/><a href="/advertise/add.html" target="_blank"><font color="red">Добавить объявление</font></a>
</td>
</tr>
</table>
{/if}