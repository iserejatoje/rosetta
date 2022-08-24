

{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы:
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}
<br/>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td align="left"><font class="place_title"><span>Новые записи</span></font></td>
<td align="right" class="s4">
	{foreach from=$res.date_show item=l key=k name=show}
		{if $l.select}
			{$l.t}
		{else}
			<a class="s4" href="{$CONFIG.files.get.last.string}?date_show={$k}">{$l.t}</a>
		{/if}
		{if !$smarty.foreach.show.last}&nbsp;&nbsp;|&nbsp;&nbsp;{/if}
	{/foreach}
</td>
</tr>
</table><br/>

{* временная вставка на момент перевода *}
{*	<table width=100% cellpadding=3 cellspacing=1 border=0>
	<tr>
		<td class="block_title2">
				<b>сегодня</b> &nbsp;&nbsp;&nbsp;{$smarty.now|date_format:"%H:%M"}
		</td>
	</tr>
	<tr>
		<td bgcolor=#F5F9FA>
			<font class=sin>Если у кого-то потерялся Дневник</font>
			<br><img src="/_img/x.gif" height="5" border="0"><br/>
			{assign var='my_email' value="nd@info74.ru"}
Если у кого-то потерялся Дневник, то необходимо {$my_email|mailto_crypt}<br/>
--------------------------------<br/>
Хочу вернуть дневник.<br/>
Название дневника (ник): ______________<br/>
свой текущий Ник: ______________<br/>
Email для связи: ______________<br/>
---------------------------------<br/>
Обязательно укажите контактные данные (E-mail)!
<br/>
в течение рабочего дня будет исправлено.<br/>
		<br/><img src="/_img/x.gif" height="5" border="0"><br/>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width=0 height=5 border=0></td>
	</tr>
	</table>*}
{* временная вставка на момент перевода : END*}


{assign var=_show_title value=false}
{if is_array($res.list) && sizeof($res.list)}
	<table width=100% cellpadding=3 cellspacing=1 border=0>
		{foreach from=$res.list item=l}
		{capture name=today}{$l.date|simply_date}{/capture}
		<tr>
			<td class="block_title2">
					<a class=shop href="{$CONFIG.files.get.journals_record.string}?id={$l.uid}&rid={$l.id}">{$l.nickname}</a>&nbsp;&nbsp;&nbsp;<b>{$l.date|dayofweek:1}, {if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$l.date|date_format:"%e"} {$l.date|date_format:"%m"|month_to_string:2} {$l.date|date_format:"%Y"}{/if}</b> &nbsp;&nbsp;&nbsp;{$l.date|date_format:"%H:%M"}
			</td>
		</tr>
		<tr>
			<td bgcolor=#F5F9FA>
			{if $l.name}
				<font class=sin>{$l.name|escape}</font><br><img src="/_img/x.gif" height="5" border="0"><br/>
			{/if}
			{$l.text|truncate:200:"...":false|nl2br}<br/><img src="/_img/x.gif" height="5" border="0"><br/>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F5F9FA" align="right" nowrap="nowrap"><a href="{$CONFIG.files.get.journals_comment.string}?id={$l.uid}&rid={$l.id}" class=s4>читать далее</a></td>
		</tr>
		<tr>
			<td><img src="/_img/x.gif" width=0 height=5 border=0></td>
		</tr>
		{/foreach}

		{if $smarty.capture.pageslink!="" }
		<tr align="center">
			<td>
				{$smarty.capture.pageslink}
			</td>
		</tr>
		{/if}
	</table>
{else}
	<center>Нет записей.</center>
{/if}
