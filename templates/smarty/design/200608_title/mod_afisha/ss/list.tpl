{include file='design/200608_title/mod_afisha/sectiontitle.tpl'}
{if !empty($smarty.get.type) || !empty($smarty.get.range)}
{if is_array($page.data.pub)}
{include file='design/200608_title/mod_afisha/ss/filter.tpl'}
{/if}
{/if}
{if !empty($page.message)}<br><br><br><br><center>{$page.message}</center>{/if}
<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
					{if is_array($page.data.categories)}
					{foreach from=$page.data.categories item=category}
					{if sizeof($category.events)}<tr>
						<td width="20">&nbsp;</td>
						<td class="place_title"><span>{$category.name}</span></td>
						<td width="20">&nbsp;</td>
					</tr>
					<tr>
						<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
						<td bgcolor="#005a52"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
						<td width="20"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
					</tr>
					<tr>
						<td width="20">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>{/if}
					{foreach from=$category.events item=event}
					<tr>
						<td width="20">&nbsp;</td>
						<td>
						<table width="100%"  border="0" cellspacing="1" cellpadding="1">
							<tr valign="top">
								<td width="96">{if sizeof($event.photo)}<a href="?cmd=show&type={$event.type}&id={$event.id}"><img src="{$event.photo.src}" {$event.photo.size} border="0"></a>{/if}</td>
								<td><a href="?cmd=show&type={$event.type}&id={$event.id}"><b>{$event.name}</b></a>
								<br/>
									{if $event.genre}
										<font class="lit2">жанр: {$event.genre}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
									{/if}
									{if $event.country}
										<font class="lit2">страна: {$event.country}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
									{/if}
									{if $event.length}
										<font class="lit2">продолжительность: {$event.length}</font>
									{/if}

									<div class="lit2" style="margin-top: 5px">
							             <table cellspacing="1" cellpadding="3" width="100%">
											{if is_array($event.seances)}
												<tr class="bg_color4">
													{if is_array($event.seances.0.link)}<th width="30%" align="left"><span class="infa">Где</span></th>{/if}
													<th width="25%" align="left"><span class="infa">Когда</span></th>
													<th  width="30%" align="left"><span class="infa">Начало</span></th>
													<th  width="15%" align="center"><span class="infa">Цена</span></th>
												</tr>
												{foreach from=$event.seances item=seance}
													<tr class="bg_color4">
														{if is_array($seance.link)}<td class="lit2" width="30%"><a href="{$seance.link.href}" title="Афиша заведения">{$seance.link.text}</a>{if $seance.auditorium}<br/>Зал: {$seance.auditorium}{/if}</td>{/if}
														<td class="lit2" width="25%">{$seance.date}</td>
														<td class="lit2" width="30%">{if !empty($seance.begin)}{$seance.begin}{/if}</td>
														<td class="lit2" width="15%" align="center">{$seance.price}</td>
													</tr>
												{/foreach}
											{/if}
											</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
								</tr>
							</table>
						</td>
						<td>&nbsp;</td>
					</tr>
					{/foreach}
					{/foreach}
                    {/if}

					{*<tr>
						<td width="20">&nbsp;</td>
						<td>
						<table width="100%"  border="0" cellspacing="1" cellpadding="1">
							".$html_ev."
						</table>
						</td>
						<td>&nbsp;</td>
					</tr> *}
				</table>