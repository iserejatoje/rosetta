{include file='design/200608_title/mod_afisha/sectiontitle.tpl'}
{if !empty($page.message)}<br><br><br><br><center>{$page.message}</center>{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td>{if sizeof($page.data.photo.src)}<img src="{$page.data.photo.src}" {$page.data.photo.size} hspace="5" vspace="5" align="left" style="margin-right: 15px" alt="" />{/if}
			{$page.data.text}<br/><br/>
			{if $page.data.genre}
				<b>Жанр</b>: {$page.data.genre}<br/><br/>
			{/if}
			{if $page.data.country}
				<b>Страна</b>: {$page.data.country}<br/><br/>
			{/if}
			{if $page.data.length}
				<b>Продолжительность</b>: {$page.data.length}<br/><br/>
			{/if}
			{if $page.data.producer}<b>Режиссёр</b>: {$page.data.producer}<br/><br/> {/if}
			{if $page.data.role}<b>В ролях</b>: {$page.data.role}<br/><br/> {/if}
		</td>
		<td width="20">&nbsp;</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td>
			<table cellspacing="1" cellpadding="3" width="100%">
		{if is_array($page.data.seances)}
			<tr class="bg_color4">
				{if is_array($page.data.seances.0.link)}<th  width="30%" align="left"><span class="infa">Где</span></th>{/if}
				<th  width="25%" align="left"><span class="infa">Когда</span></th>
				<th  width="30%" align="left"><span class="infa">Начало</span></th>
				<th  width="15%" align="center"><span class="infa">Цена</span></th>
			</tr>
			{foreach from=$page.data.seances item=seance}
				<tr class="bg_color4">
					{if is_array($seance.link)}<td class="lit2" width="30%"><a href="{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a> {if !empty($seance.link.phones)} <font class="otzyv">(тел. {$seance.link.phones})</font>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}{/if}</td>{/if}
					<td class="lit2" width="25%">{$seance.date}</td>
					<td class="lit2" width="30%">{if !empty($seance.begin)}{$seance.begin}{/if}</td>
					<td class="lit2" width="15%" align="center">{$seance.price}</td>
				</tr>
			{/foreach}
		{/if}
			</table><br/>
		{$page.data.remark}
		</td>
		<td width="20">&nbsp;</td>
	</tr>
</table>

{if is_array($page.data.about) && sizeof($page.data.about)}
<br/><br/>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="20">&nbsp;</td>
			<td class="block_title2"><span>О фильме пишут</span></td>
			<td width="20">&nbsp;</td>
		</tr>
		<tr>
			<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
			<td bgcolor="#1F68A0"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
			<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
		</tr>
		<tr>
			<td width="20">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="20">&nbsp;</td>
		</tr>
	</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
	<tr valign="top">
		<td width="20">&nbsp;</td>
		<td>
			{foreach from=$page.data.about item=about}
				<font class="zag5">{$about.name}:</font><br/>
				<font class="lit2">{$about.descr}&nbsp;<a href="{$about.link}"><img src="/img/mark2.gif" width="10" height="9" border="0" align="absmiddle" alt=""/></a></font><br/><br/>
			{/foreach}
		</td>
		<td width="20">&nbsp;</td>
	</tr>
</table>
{/if}

{if is_array($page.data.also) && sizeof($page.data.also)}
<br/><br/>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="20">&nbsp;</td>
			<td class="block_title2"><span>Смотреть также</span></td>
			<td width="20">&nbsp;</td>
		</tr>
		<tr>
			<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
			<td bgcolor="#1F68A0"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
			<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
		</tr>
		<tr>
			<td width="20">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="20">&nbsp;</td>
		</tr>
	</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr valign="top">
	<td width="20">&nbsp;</td>
	<td><font class="lit2">
			{foreach from=$page.data.also item=also}
				<a href="{$also.href}">{$also.text}</a>&nbsp;&nbsp;
			{/foreach}
		</font><br/><br/>
	</td>
	<td width="20">&nbsp;</td>
</tr>
</table>
{/if}

{if isset($page.blocks.comments) && !empty($page.blocks.comments)}
	<br/>{$page.blocks.comments}
	{$page.blocks.askform}
{/if}