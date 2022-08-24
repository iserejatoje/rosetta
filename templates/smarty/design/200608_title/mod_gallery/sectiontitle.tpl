<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	{if sizeof($TITLE->Path)}
	<tr>
		<td style="padding-left:20px" class="zag3"><a href="/" class="zag3">Главная</a>
		 / <a href="/{$SITE_SECTION}/" class="zag3">{$GLOBAL.title[$SITE_SECTION]}</a>
		{foreach from=$TITLE->Path item=url name=path}
			{if !$smarty.foreach.path.last}
				 / <a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{elseif $url.link != ''}
				/ <a href="/{$SITE_SECTION}/{$url.link}" class="zag3">{$url.name}</a>
			{else}
				/ {$url.name}
			{/if}
		{/foreach}
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px" class="zag6">{php}echo $this->_tpl_vars['TITLE']->Path[sizeof($this->_tpl_vars['TITLE']->Path)-1]['name'];{/php}</td>
	</tr>
	{else}
	<tr>
		<td style="padding-left:20px" class="zag3"><a href="/" class="zag3">Главная</a> / {$GLOBAL.title[$SITE_SECTION]}</td>
	</tr>
	<tr>
		<td style="padding-left:20px" class="zag6">{$GLOBAL.title[$SITE_SECTION]}</td>
	</tr>
	{/if}
</table>      
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#C1211D"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	</tr>
</table>
<br/>