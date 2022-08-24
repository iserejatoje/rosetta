<table width="100%" class="block_left" cellspacing="3" cellpadding="0" >
	<tr><th><span>{if $data.title}{$data.title}{else}Онлайн-консультация{/if}</span></th></tr>
</table>
{if !empty($data.person.name)}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
                <td valign="top"><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td>
	</tr>
	<tr>
                <td valign="top" style="padding: 0px 0px 5px 5px">
			<a href="{$data.module_url}{$data.path}/{$data.cid}/" target="_blank"><b>{$data.person.name}</b></a>
		</td>
	</tr>
	<tr>
                <td valign="top">
                <a href="{$data.module_url}{$data.path}/{$data.cid}/" target="_blank"><img src="{$data.person.photo.src}" align="left" border="0" hspace="5" vspace="1" width="{$data.person.photo.w}" height="{$data.person.photo.h}"></a>
                <a href="{$data.module_url}{$data.path}/{$data.cid}/" target="_blank">{$data.person.dolg}</a>
                </td>
              </tr>
	{if !empty($data.question.otziv)}
	<tr>
		<td class="otzyv" style="padding-top:2px">
			<em>{$data.question.name|truncate:20:"...":false}</em>: {$data.question.otziv|truncate:100:"...":false} <a href="{$data.module_url}{$data.path}/{$data.cid}" target="_blank">далее</a>
		</td>			
	</tr>
	{/if}
</table>
{/if}