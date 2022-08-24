{if isset($smarty.get.tst)}{debug}{/if}
{if !(empty($BLOCK.rus.data) && empty($BLOCK.ino.data))}
<table width="100%" cellspacing="3" cellpadding="0" >
	<tr><td class="block_title_obl" style="padding-left: 15px;" align="left"><span>{$ENV.site.title.advertise}</span></td></tr>
</table>
<table border="0" cellspacing="3" cellpadding="4" width="100%">
<tr>
	{assign var="td_cnt_const" value=2}
	{assign var="td_cnt" value=0}
	{foreach from=$BLOCK.rus.data item=l name=avto}
	{if $l.count}
		<td valign="top" class="t7">
			{math equation="x % y" x=$smarty.foreach.avto.iteration y=$td_cnt_const assign=half}
			<nobr><a href="/advertise/search/?type=0&parent={$l.id}&search=%CD%E0%E9%F2%E8&model=-1" target="_blank"><strong>{$l.name}</strong></a> ({$l.count})</nobr><br/>
		</td>
		{if $half == 0}
			{assign var="td_cnt" value=0}
			</tr><tr valign="top" class="t7">
		{/if}
	{/if}
	{/foreach}
</tr>
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