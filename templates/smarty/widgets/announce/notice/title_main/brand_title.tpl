<div class="title">
	<span><a href="/service/go/?url={$res.title_url}" target="_blank">{$res.title}</a></span>
</div>

<div class="content">
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	{assign var="i" value="0"}
	{foreach from=$res.list item=l key=k}
		{if !$i}<td class="container-vertical-align-top">{/if}
		<div class="line">
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="absmiddle" alt="" /> <a href="/service/go/?url={"`$res.title_url`search/?type=0&parent=`$k`&search="|escape:"url"}" target="_blank">{$l.name}</a> <span class="count">(<span>{$l.cnt|number_format:0:' ':' '}</span>)</span>
		</div>
		{assign var="i" value="`$i+1`"}
		{if $res.rows==$i}</td>{assign var="i" value="0"}{/if}
	{/foreach}
	</tr>
	</table>
</div>

<div class="info">
	<span>За неделю добавлено <span class="boldtext">{$res.period_cnt[0]|number_format:0:' ':' '}</span> {word_for_number number=$res.period_cnt[0] first="объявление" second="объявления" third="объявлений"}</span>
	<a href="/service/go/?url={"`$res.title_url`add.html"|escape:"url"}" target="_blank" class="redtext">Добавить объявление</a>
</div>