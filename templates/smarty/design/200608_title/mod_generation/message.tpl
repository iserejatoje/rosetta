<p><font class="title">{$page.title}</font></p>
<table width="100%" cellpadding="15" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td align="center">
						{foreach from=$page.err item=l key=k}
							{$l}<br />
						{/foreach}
					</td>
				</tr>
				{if $page.main}
				<tr>
					<td align="center"><br/>[ <a href="/{$ENV.section}/">На главную</a> ]</td>
				</tr>
				{/if}
				{if $page.back}
				<tr>
					<td align="center"><br/>[ <a href="javascript:void(0)" onclick="window.history.go(-1)">Назад</a> ]</td>
				</tr>
				{/if}
			</table>
		</td>
	</tr>
</table>
