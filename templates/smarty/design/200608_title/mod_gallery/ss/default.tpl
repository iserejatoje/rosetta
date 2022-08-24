{if $page.errors.global}<br/><br/>
<div align="center"><font color="red"><b>{$page.errors.global}</b></font></div>
{else}
<table cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td width="100%" align="right"><a href="/{$ENV.section}/list/albums/c0.html" class="menu"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="Последние поступления" /></a></td>
	<td style="padding:0px 0px 0px 10px" nowrap="nowrap">
		<a href="/{$ENV.section}/list/albums/c0.html" class="s1" title="Последние поступления">Последние поступления</a>
	</td>
</tr>
<tr>
	<td colspan="2"><font class="t5gb">Новые фото</font></td>
</tr>
<tr>
	<td colspan="2" bgcolor="#005A52"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
</table>

{$page.photos}
{$page.categories}
<br/>
{/if}
