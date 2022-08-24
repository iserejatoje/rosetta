<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
 		<td width="20">&nbsp;</td>
		<td class="text11"><b><a href="/" >Главная</a> /
		{if is_array($page.title_path)}
			{foreach from=$page.title_path item=path name=path}
				{if isset($path.url) && !empty($path.url)}
					<a href="{$path.url}" >{$path.text}</a>
				{elseif empty($path.url)}{$path.text}
				{/if}
				{if !$smarty.foreach.path.last } / {/if}
			{/foreach}
		{/if}</b>
		</td>
		<td class="text11" align="right" style="padding-right: 50px">{* <a href="/afisha/?cmd=show&type=5&id=2767" class="zag3">День города</a> *}</td>
	</tr>
	{if $smarty.get.cmd!='list'}
	<tr>
		<td width="20">&nbsp;</td>
		<td class="place_title"><span>{$page.title}</span></td>
		<td></td>
	</tr>
        {/if}	
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
{*	<tr>
		<td style="padding: 3px 0px 16px 20px" class="text11"><a href="mailto:{$CURRENT_ENV.site.domain}%20<kapitova@info74.ru>?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}">Прислать информацию о событии</a></td>
	</tr>*}
	{if $page.title_sub.phones || $page.title_sub.address}
	<tr>
		<td>
			<table cellspacing="1" cellpadding="3" width="100%" style="padding-bottom:10px;" >
				{if $page.title_sub.phones}
				<tr bgcolor="#edf6f8">
					<td style="padding-left:20px;">Телефон:</td>
					<td width="100%">{$page.title_sub.phones}</td>
				</tr>
				{/if}
				{if $page.title_sub.address}
				<tr bgcolor="#edf6f8">
					<td align="right">Адрес:</td>
					<td>{$page.title_sub.address}</td>
				</tr>
				{/if}
				{if $page.title_sub.phones}
				<tr>
					<td></td>
					<td>Внимание! Время начала сеансов уточняйте по телефонам</td>
				</tr>
				{/if}
			</table>
		</td>
	</tr>
	{/if}
</table>
<br/>