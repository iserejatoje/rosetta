{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}{if !$l.active}&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>{else}&nbsp;<span class="pageslink_active"> {$l.text} </span>{/if}{/foreach}
	{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td align="right">
		{$smarty.capture.pageslink}
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
{/if}
	<tr>
		<td>
			{if is_array($res.list) && sizeof($res.list)>0}
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			{foreach from=$res.list item=l key=i}
				<tr>
					<td class="zag3">
					<table cellpadding="0" cellspacing="0" border="0" class="block_right">
						<tr>
							<td>
								<a href="/{$ENV.section}/{$l.link}" class="anon"><span class="anon_name">{$l.name}</span></a>
							</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="3" border="0" alt="" /></td>
				</tr>
				<tr>
					<td class="ssyl">
						{if is_array($l.img1) && isset($l.img1.url)}
							<a href="/{$ENV.section}/{$l.link}"><img src="{$l.img1.url}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
						{/if}
						{*<font class="dop">{$l.date|date_format:"%e"} {$l.date|month_to_string:2} {$l.date|date_format:"%Y"}</font><br />*}
						{$l.anon}
					</td>
				</tr>
				<tr>
					<td height="10px"></td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td>
				</tr>
				<tr>
					<td height="10px"></td>
				</tr>
			{/foreach}
			</table>
			{/if}
		</td>
	</tr>
{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td align="right">{$smarty.capture.pageslink}</td>
	</tr>
{/if}
</table>