				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td>
							<table style="height:85px" width="100%" border="0" cellspacing="0" cellpadding="">
								<tr align="center" valign="middle" colspan="2">
									<td align="left" style="padding-left: 20px; padding-bottom: 5px;">
										{if isset($BLOCKS.header.header_line_small_1)}
											{$BLOCKS.header.header_line_small_1}
										{/if}
									</td>
								</tr>
								<tr>
									<td>
										<span class="section_title">
										{if isset($BLOCKS.header.header_menu_bottom) && in_array($CURRENT_ENV.section,array('exchange','newsline_fin','tech','skills','newscomp_fin'))}
											Финансы
										{elseif isset($BLOCKS.header.header_menu_bottom) && in_array($CURRENT_ENV.section,array('articles','newsline_dom','sale','rent','change','commerce','users','hints','design'))}
											Недвижимость
										{elseif isset($BLOCKS.header.header_menu_bottom) && in_array($CURRENT_ENV.section,array('newsline_auto','autostop','opinion','advertise','accident','pdd','instructor','photoreport','poputchik','car'))}
											Авто
										{elseif isset($BLOCKS.header.header_menu_bottom) && in_array($CURRENT_ENV.section,array('weekfilm','starspeak','love','dream','horoscope','gallery','afisha'))}
											{*if in_array($CURRENT_ENV.regid,array(174))}
											Афиша
											{else*}
											Отдых
											{*/if*}
										{elseif $CURRENT_ENV.section == 'help'}
											Помощь
										{elseif $CURRENT_ENV.section == 'baraholka'}
											<a href="http://{$CURRENT_ENV.site.domain}/{$CURRENT_ENV.section}/"><img src="/_img/modules/board/baru2.gif" border="0" alt="БАРАХОЛКА" title="Барахолка"  style="margin-top:28px" /></a>
										{elseif $CURRENT_ENV.section == 'pages'}
										{else}
											{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
										{/if}
										</span>
									</td>
									<td valign="middle" align="center">
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
									{if $BLOCKS.header.login_form}<td align="right">
										{$BLOCKS.header.login_form}
									</td>
									{/if}
								</tr>
								<tr align="center" valign="middle" colspan="2">
									<td align="left" valign="bottom" style="padding-left: 20px;">
										{if isset($BLOCKS.header.header_line_small_2)}
											{$BLOCKS.header.header_line_small_2}
										{/if}
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>