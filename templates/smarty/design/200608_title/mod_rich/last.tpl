<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
	<tr><th><span>{if $res.title}{$res.title}{else}Версия 2010{/if}</span></th></tr>
</table>

<table class="menu-klass" width="100%" bgcolor="#ffffff" border="0" cellpadding="3" cellspacing="1">
{foreach from=$res.list item=l}
		<tr bgcolor="#f1f6f9"> 
			<td valign="top" width="100%" style="padding-left: 16px;" class="descr"><li>
			&nbsp;&nbsp;<a href="/{$SITE_SECTION}/about.html#s{$l.id}">{$l.name}</a></li>
      			</td>
		</tr>
{/foreach}
</table>