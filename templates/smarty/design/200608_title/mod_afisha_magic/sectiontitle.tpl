<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	{if sizeof($TITLE->Path)}
	<tr>
		<td style="padding-left:20px" colspan="2"><b><a href="/" colspan="3">Главная</a>
		 / <a href="/{$SITE_SECTION}/">{$GLOBAL.title[$SITE_SECTION]}</a>
		{foreach from=$TITLE->Path item=url name=path}
			{if !$smarty.foreach.path.last}
				 / <a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{elseif $url.link != ''}
				/ <a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{else}
				/ {$url.name}
			{/if}
		{/foreach}</b>
		</td>
	</tr>
	{*<tr>
		<td width="20"> </td>
		<td colspan="2" class="place_title"><span>{php}echo $this->_tpl_vars['TITLE']->Path[sizeof($this->_tpl_vars['TITLE']->Path)-1]['name'];{/php}</span></td>
		<td width="20"> </td>
	</tr>
	<tr>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
		<td bgcolor="#005a52"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
	</tr>*}
	{else}
	<tr>
		<td style="padding-left:20px" colspan="3"><b><a href="/" class="zag3">Главная</a> / {$GLOBAL.title[$SITE_SECTION]}</b></td>
	</tr>
	{*<tr>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
		<td class="place_title"><span>{$GLOBAL.title[$SITE_SECTION]}</span></td>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
	</tr>
	<tr>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
		<td bgcolor="#005a52"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
		<td width="20"><img height="2" width="1" alt="" src="/_img/x.gif"/></td>
	</tr>*}
	{/if}
</table>
{*<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding: 3px 0px 3px 20px"><a class="a11" href="mailto:{$CURRENT_ENV.site.domain}%20&lt;afisha@info74.ru&gt;?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}" class="red_big">Прислать информацию о событии</a></td>
	</tr>
</table>*}
<br/>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if $TITLE->Tags.group[0].desc}
	<tr>
		<td style="padding-left:20px" class="zag6">{$TITLE->Tags.group[0].name}</td>
	</tr>
	<tr>
		<td style="padding: 0px 5px 3px 20px" align="right"><a href="mailto:{$CURRENT_ENV.site.domain}%20&lt;afisha@info74.ru&gt;?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}" class="red_big">Прислать информацию о новом событии</a></td>
	</tr>
	<tr>
		<td style="padding-left:20px;padding-right:40px;">
			{$TITLE->Tags.group[0].desc}
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px" class="zag6" colspan="2">{php}echo $this->_tpl_vars['TITLE']->Path[sizeof($this->_tpl_vars['TITLE']->Path)-1]['name'];{/php}</td>
	</tr>
{else}
	<tr>
		<td style="padding-left:20px" class="zag6" colspan="2">{if $TITLE->Tags.group[0].name}{$TITLE->Tags.group[0].name}. {/if}{php}echo $this->_tpl_vars['TITLE']->Path[sizeof($this->_tpl_vars['TITLE']->Path)-1]['name'];{/php}</td>
	</tr>
	<tr>
		<td style="padding: 0px 5px 3px 20px" align="right"><a href="mailto:{$CURRENT_ENV.site.domain}%20&lt;afisha@info74.ru&gt;?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}" class="red_big">Прислать информацию о новом событии</a></td>
	</tr>
{/if}

{if !empty($TITLE->Tags.firm[0].url)}
	<tr>
		<td style="padding: 3px 0px 3px 20px"><a href="{$TITLE->Tags.firm[0].url}" class="red_big">Посмотреть информацию о заведении</a></td>
	</tr>
{/if}

</table>

{*<table width="100%"  border="0" cellspacing="0" cellpadding="0">
{if !empty($TITLE->Tags.firm[0].url)}
	<tr>
		<td style="padding: 3px 0px 3px 20px"><a href="{$TITLE->Tags.firm[0].url}" class="red_big">Посмотреть информацию о заведении</a></td>
	</tr>
{/if}
</table>*}
<br/>
