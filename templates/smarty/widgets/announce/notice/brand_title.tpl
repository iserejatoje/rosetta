<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_caption_main" align="left" style="padding:1px 10px 1px 10px;">
		<a href="/service/go/?url={$res.title_url}" target="_blank">{$res.title}</a>
	</td></tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	{assign var="i" value="0"}
	{foreach from=$res.list item=l key=k}
			{if !$i}<td class="list" valign="top">{/if}
			<img src="/_img/x.gif" width="1" height="4" border="0" alt="" /><br /><img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <nobr><a class="a11" href="/service/go/?url={"`$res.title_url`search/?type=0&parent=`$k`&search="|escape:"url"}" target="_blank">{$l.name} (<b>{$l.cnt|number_format:0:' ':' '}</b>)</a></nobr><br/>
			{assign var="i" value="`$i+1`"}
			{if $res.rows==$i}</td>{assign var="i" value="0"}{/if}
	{/foreach}
</tr>
<tr>
<td colspan="3">
	<div align="right" class="otzyv">За неделю добавлено <b>{$res.period_cnt[0]|number_format:0:' ':' '}</b> {word_for_number number=$res.period_cnt[0] first="объявление" second="объявления" third="объявлений"}&nbsp;&nbsp;&nbsp;
	      <a href="/service/go/?url={"`$res.title_url`add.html"|escape:"url"}" target="_blank"><font color="#ff0000">Добавить объявление</font></a>
	</div></td>
</tr>
</table>    