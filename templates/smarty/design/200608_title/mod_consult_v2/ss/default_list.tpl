<br/>
<!-- begin content -->
<table width="100%" cellpadding="0" cellspacing="0">
{foreach from=$res.rubrics.list item=l}
	<tr>
		<td>
			<strong>
				{if !empty($l.child)}
					{if $res.open != $l.id}
						<a href="/{$ENV.section}/{$l.id}.html">
					{/if}
						<font style="FONT-SIZE: 16px">{$l.name}</font>
					{if $res.open != $l.id}
						</a>
					{/if}
				{else}
					<a href="/{$ENV.section}/{$l.path}/">
					<font style="FONT-SIZE: 16px">{$l.name}</font>
					</a>
				{/if}
			</strong>
			{if $res.open && $res.open == $l.id}
			<br/>
			<table width="100%" cellpadding="0" cellspacing="0">
			{foreach from=$l.child item=ch}
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="padding-left:30px">
						<strong>
						<a href="/{$ENV.section}/{$ch.path}{if !empty($ch.path)}/{/if}" style="FONT-SIZE: 16px">{$ch.name}</a>
						</strong>
					</td>
				</tr>
			{/foreach}
			</table>
			{/if}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
{/foreach}
</table>
<!-- end content -->
