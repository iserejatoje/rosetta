{foreach from=$res item=l}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0>
	<tr><td class="title2_news"><a name="s{$l.id}"></a>
		{$l.name}
	</td></tr>
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="justify">
<!-- Text article -->
{$l.text|screen_href}
<!-- Text article: end -->
</td></tr>
<tr><td height="1px"></td></tr>
</table>
{/foreach}