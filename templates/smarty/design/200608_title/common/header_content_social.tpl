				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr align="center" valign="middle" colspan="3">
									<td align="left" style="padding-left: 20px; padding-bottom: 5px;">
										{if isset($BLOCKS.header.header_line_small_1)}
											{$BLOCKS.header.header_line_small_1}
										{/if}
									</td>
								</tr>
								<tr>
									<td>
{if $CURRENT_ENV.section == 'social'}
<table cellspacing="0" cellpadding="3" border="0">
<tr>
	<td>
		<span class="section_title">
			{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
		</span>
	</td>
	<td valign="top" align="left">
		<sup><i style="color:red; font-size: 9pt; text-transform: lowercase;">alpha</i></sup>
	</td>
</tr>
</table>
{else}
	<span class="section_title">
		{if $CURRENT_ENV.section=='svoi'}
			Блоги										
		{else}
			{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
		{/if}		
	</span>
{/if}
									</td>
									<td valign="middle" align="center">
										{if isset($BLOCKS.header.weather)}
											{$BLOCKS.header.weather}
										{elseif isset($BLOCKS.header.header_bunner)}
											{$BLOCKS.header.header_bunner}
										{else}
											{include file="design/200608_title/common/header_bunner.tpl"}
										{/if}
									</td>
									<td width="150" align="right">
										{$BLOCKS.header.login_form}
									</td>
								</tr>
								<tr align="center" valign="middle" colspan="3">
									<td align="left" style="padding-left: 20px; padding-bottom: 5px;">
										{if isset($BLOCKS.header.header_line_small_2)}
											{$BLOCKS.header.header_line_small_2}
										{/if}
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>