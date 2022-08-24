{if $res.randr.text!=""}
<table width="100%" cellpadding="0" cellspacing="3" border="0">
<tr align="right">
	<td class="block_title_obl"><span>СЛУЧАЙНАЯ ЗАПИСЬ</span></td>
</tr>
</table>

<table align=center cellpadding=0 cellspacing=3 border=0 width=100%>
  <tr><td valign="top" colspan=3><img src="/_img/x.gif" width=1 height=3></td></tr>
<tr bgcolor="#F5F9FA"><td class="text11"><b><a href="{$CONFIG.files.get.journals_comment.string}?id={$res.randr.uid}&rid={$res.randr.id}">{$res.randr.login}</a>, {$res.randr.date|date_format:"%d.%m"}:</b> {$res.randr.text|scrap_text:0:0:6:33:20:"..."|strip_tags} </td></tr>
<tr><td align="right" class="text11"><a href="{$CONFIG.files.get.journals_comment.string}?id={$res.randr.uid}&rid={$res.randr.id}">читать далее</a></td></tr>
<tr><td><img src="/_img/x.gif" width=1 height=10></td></tr>
</table>
{/if}