{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<b>{$l.text}</b>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
{if $res.title}
<tr><td height="10px"></td></tr>
<tr><td align="left" class="title">{$res.title}</td></tr>
<tr><td height="5px"></td></tr>
<tr><td align="left"><div style="text-align:justify;">В данном разделе представлен рейтинг техники, составленный на основе голосования посетителей проекта {$CURRENT_ENV.site.domain}. Приглашаем всех принять участие в голосовании и повлиять на ТОП 10.</div></td></tr>
{else}
<tr><td height="10px"></td></tr>
<tr><td align="left"><b>Найдено:</b> {$res.count|number_format:0:".":" "}.</td></tr>
	{if count($res.sort)}
	<tr><td height="10px"></td></tr>
	<tr><td align="left"><b>Сортировать по:</b>
	{foreach from=$res.sort item=l key=k}
	{if $smarty.get.sort==$k}
	<span style="padding-left:3px;padding-right:3px;" class="bg_color4">
	<img src="/_img/design/200710_2074/{if $smarty.get.sord=='asc'}asc{else}desc{/if}.gif" width="9" height="10" align="absmiddle" border="0" />
	<a href="?sort={$k}&sord={if $smarty.get.sord=='asc'}desc{else}asc{/if}{if $res.url_params_sort}&{$res.url_params_sort}{/if}">{$l.name}</a>
	</span>
	{else}
	<span style="padding-left:3px;padding-right:3px;">
	<a href="?sort={$k}&sord={$smarty.get.sord}{if $res.url_params_sort}&{$res.url_params_sort}{/if}">{$l.name}</a>
	</span>
	{/if}
	{/foreach}
	</td></tr>
	{/if}
{/if}
{if $smarty.capture.pageslink!="" }
<tr><td height="10px"></td></tr>
<tr><td align="center">
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
<tr><td>

{if count($res.list)}
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
{assign var="cols_item" value="2"}
{math equation="floor(100/x)" x=$cols_item assign="cols_item_width"}
{assign var="cur_col" value=1}
{foreach from=$res.list item=l key=k}
	{if $cur_col==1}
		<tr valign="top" align="left">
	{/if}

	<td width="{$cols_item_width}%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
			<td width="110px" align="right">{if $l.img1.url}<a href="/{$ENV.section}/{$l.id}.html"><img src="{$l.img1.url}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|escape:"quotes"}"></a>{else}&nbsp;{/if}</td>
			<td width="10px"><img src="/_img/x.gif" width="10" height="1" border="0"/></td>
			<td>
<a href="/{$ENV.section}/{$l.id}.html"><b>{$res.common.arrays.p2[$l.brand].name} {$l.name}</b></a><br/><br/>
{if $l.p4>0}
<b>Цена:</b> {$res.property_list.p4.params.prefix}{$l.p4|number_format:$res.property_list.p4.params.precision:".":" "}{$res.property_list.p4.params.postfix}<br/>
{/if}
{if $l.p8>0 && array_key_exists($l.p8, $res.common.arrays.p8)}
<b>Дипазон:</b> {$res.property_list.p8.params.prefix}{$res.common.arrays.p8[$l.p8].name}{$res.property_list.p8.params.postfix}<br/>
{/if}
{if $l.p19>0 && array_key_exists($l.p19, $res.common.arrays.p19)}
<b>Аккумулятор:</b> {$res.common.arrays.p19[$l.p19].name}{if $l.p20>0}, {$res.property_list.p20.params.prefix}{$l.p20|number_format:0:".":" "}{$res.property_list.p20.params.postfix}{/if}<br/>
{/if}
{if $l.p27>0}
<b>Вес:</b> {$res.property_list.p27.params.prefix}{$l.p27|number_format:0:".":" "}{$res.property_list.p27.params.postfix}<br/>
{/if}
{if $l.p33>0 && $l.p34>0}
<b>Экран:</b> {$res.property_list.p33.params.prefix}{$l.p33}x{$l.p34}{$res.property_list.p33.params.postfix}<br/>
{/if}
{if $l.p36>0}
<b>Цветов:</b> {$res.property_list.p36.params.prefix}{$l.p36|number_format:0:".":" "}{$res.property_list.p36.params.postfix}<br/>
{/if}
{if $l.p63 || $l.p64 || $l.p65 || $l.p66}
{assign var="add_text" value=""}
{if $l.p63}{assign var="add_text" value="`$add_text`HSCSD"}{/if}
{if $add_text}{assign var="add_text" value="`$add_text`, "}{/if}
{if $l.p64}{assign var="add_text" value="`$add_text`GPRS"}{/if}
{if $add_text}{assign var="add_text" value="`$add_text`, "}{/if}
{if $l.p65}{assign var="add_text" value="`$add_text`EDGE"}{/if}
{if $add_text}{assign var="add_text" value="`$add_text`, "}{/if}
{if $l.p66}{assign var="add_text" value="`$add_text`Java"}{/if}
<b>Дополнительно:</b> {$add_text}<br/>
{/if}
<table border="0" cellpadding="0" cellspacing="0" title="Рейтинг: {$l.rating}">
<tr valign="bottom">
<td><b>Рейтинг:</b> {$l.rating|number_format:1:".":" "}&nbsp;&nbsp;</td>
<td>{$l.rating_bar}</td>
</tr>
</table>
			</td>
		</tr>
	{if sizeof($l.comment) > 0}
		<tr><td height="3px"></td></tr>
		<tr>
			<td colspan="3" align="left">
			{foreach from=$l.comment item=o}
				<b><font class="user">{if $o.user}<a href="{$o.user.url}" target="_blank">{$o.user.name|truncate:20:"...":false}</a>{else}{$o.name|truncate:20:"...":false}{/if}, {$o.crated|date_format:"%e.%m"}:</font></b>
				&nbsp;{$o.text|truncate:80:"...":false}&nbsp;<a href="/{$ENV.section}/{$l.id}.html?act=last#comment{$o.id}"><img src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" align="middle" alt="читать далее" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{/foreach}
			</td>
		</tr>
	{/if}
		</table>
	</td>

	{assign var="cur_col" value="`$cur_col+1`"}
	{if $cur_col > $cols_item}
		</tr>
		<tr><td height="10px"></td></tr>
		{assign var="cur_col" value=1}
	{/if}
{/foreach}



	</table>
{/if}

</td></tr>
{if $smarty.capture.pageslink!="" }
<tr><td height="10px"></td></tr>
<tr><td align="center">
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
</table>