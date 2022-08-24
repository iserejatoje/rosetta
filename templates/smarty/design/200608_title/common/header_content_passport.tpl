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
{if $CURRENT_ENV.section == 'passport'}
<table cellspacing="0" cellpadding="3" border="0">
<tr>
	<td>
		<span class="section_title">
{if strpos($CURRENT_ENV.section, 'passport') !== false}
Паспорт
{else}
{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
{/if}
			
		</span>
	</td>
	<td valign="top" align="left">
		<sup><i style="color:red; font-size: 9pt; text-transform: lowercase;">beta</i></sup>
	</td>
</tr>
</table>
{else}
	<span class="section_title">
{if strpos($CURRENT_ENV.section, 'passport') !== false}
Паспорт
{elseif strpos($CURRENT_ENV.section,"blogs")>0 }
Блоги	
{elseif strpos($CURRENT_ENV.section,"gallery")>0 }
Фотогалерея
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
										{elseif $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl")}
											{include file="design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl"}
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