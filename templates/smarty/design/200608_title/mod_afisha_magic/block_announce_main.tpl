<table width="100%" border="0" cellspacing="10" cellpadding="0">
<tr>
	<td class="block_title_obl" align="left" style="padding-left: 10px;">
		<a title="Твоя афиша" href="/afisha/">
			<font class="zag7" style="text-decoration: none;">Твоя афиша</font>
		</a>
	</td>
</tr>
<tr>
	<td align="left" style="padding-left: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	{foreach from=$res.list item=l}
		<tr> 
		<td class="text11" nowrap><img height="14" width="12" alt="" src="/_img/design/200710_afisha/bull1.gif"/>&nbsp;<a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.name}" class="afisha">{$l.title}</a>{if $l.count}&nbsp;({$l.count}){/if}
		</td>
		</tr>
	{/foreach}
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
	</table>
	</td>
</tr>
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
</table>