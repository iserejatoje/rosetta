
<table cellpadding="0" cellspacing="0" width="100%" border="0">
	<tr>
		<td valign="top" height="14">
			{$BLOCKS.header.header_stat}
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:60px">
				<tr>
					<td>
						<span class="section_title">
							{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
						</span>
					</td>
					<td valign="middle" bgcolor="#E0F3F3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:60px">
							<tr>
								{if isset($BLOCKS.header.header_hot_link)}
									<td height="40" align="center">
										{$BLOCKS.header.header_hot_link}
									</td>
								{/if}
								{if isset($BLOCKS.header.header_bunner)}
									<td align="center" style="padding-top: 5px">{$BLOCKS.header.header_bunner}</td>
								{elseif $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl")}
									<td align="center" style="padding-top: 5px">{include file="design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl"}</td>
								{else}
									<td align="center" style="padding-top: 5px">{include file="design/200608_title/common/header_bunner.tpl"}</td>
								{/if}
							</tr>
						</table>
					</td>
					<td align="right">
						{$BLOCKS.header.login_form}
					</td>
				</tr>
			</table>
		</td>
	</tr>
{*	<tr>
		<td valign="top" height="14">
		</td>
	</tr>
*}
</table>
