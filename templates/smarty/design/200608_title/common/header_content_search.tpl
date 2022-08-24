<!-- aaxxiiss -->
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
							<table style="height:85px" width="100%" border="0" cellspacing="0" cellpadding="">
								<tr align="center" valign="middle">
									<td align="left" style="padding-left: 20px; padding-bottom: 5px;" colspan="2">
										{if isset($BLOCKS.header.header_line_small_1)}
											{$BLOCKS.header.header_line_small_1}
										{/if}
									</td>
								</tr>
								<tr>
									<td>
										<span class="section_title">Поиск</span>
									</td><td align="center">
										{if $CURRENT_ENV.section!='passport' && $CURRENT_ENV.section!='help' && strpos($CURRENT_ENV.section, 'social')!==0}
										{if isset($BLOCKS.header.header_bunner)}
											{$BLOCKS.header.header_bunner}
										{elseif $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl")}
											{include file="design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl"}
										{else}
											{include file="design/200608_title/common/header_bunner.tpl"}
										{/if}
										{/if}
									</td>
									</td>
									<td>
										{if $BLOCKS.header.search_form}{$BLOCKS.header.search_form}{/if}
									</td>
								</tr>
								<tr align="center" valign="middle">
									<td align="left" valign="bottom" style="padding-left: 20px;" colspan="2">
										{if isset($BLOCKS.header.header_line_small_2)}
											{$BLOCKS.header.header_line_small_2}
										{/if}
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>