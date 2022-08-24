
<!-- begin content -->
<br/>
{if $TEMPLATE.searchform}{include file="`$TEMPLATE.searchform`"}
{else}
<table border="0" cellpadding="0" cellspacing="0" align=center width="100%">
	<tr>
		<td>&#160;</td>
	</tr>
	<tr>
		<td class="gl" height="22" align="center" >
						<b>
						{if !empty($res.rtitle)}{$res.rtitle}
						{else}
							{foreach from=$res.pathdesc item=path}
							{if $path.path!=$res.base}<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$path.path}/">{/if}{$path.data.name}{if $path.path!=$res.base}</a>&nbsp;/&nbsp;{/if}
							{/foreach}
						{/if}</b>
		</td>
	</tr>
	<tr>
		<td height="3"><img src="/_img/x.gif" width="1" height="3"></td>
	</tr>
</table>
{/if}
<br/>

<table cellpadding="0" cellspacing="7" align="center">
	<tr> 
		<td height="1" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" height="1"></td> 
	</tr>
{foreach from=$res.list item=l}
{if $l.data.cnt > 0}
	<tr>
		<td class="medium">
			<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$res.base}{if !empty($res.base)}/{/if}{$l.name|rtrim:"/"}/" class="medium">{$l.data.name}</a> ({$l.data.cnt})
		</td>
	</tr>
	<tr> 
		<td height="1" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" height="1"></td> 
	</tr>
{/if}
{/foreach}
</table><br/><br/>
<!-- end content -->
