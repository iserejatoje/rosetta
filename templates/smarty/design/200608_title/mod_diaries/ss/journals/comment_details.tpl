
{assign var=_nocomment value=`$res.record.nocomment`}
{if $res.record.uid}

	<table width=100% cellpadding=0 cellspacing=0 border=0>
		<tr>
			<td>
				<table width=100% cellpadding=3 cellspacing=0 border=0>
					{capture name=today}{$res.record.date|simply_date}{/capture}
					<tr>
						<td class="block_title2"><a name="r{$res.record.id}"></a>
							<b>{$res.record.date|dayofweek:1}, {if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$res.record.date|date_format:"%e"} {$res.record.date|date_format:"%m"|month_to_string:2} {$res.record.date|date_format:"%Y"}{/if}</b> &nbsp;&nbsp;&nbsp;{$res.record.date|date_format:"%H:%M"}
						</td>
					</tr>
					<tr>
						<td bgcolor="#F5F9FA">
						{if $res.record.name}
							<font class=sin>{$res.record.name|escape}</font><br><img src="/_img/x.gif" height=5 border=0><br>
						{/if}{$res.record.text|nl2br|screen_href|mailto_crypt}<br/><br/><br/>
						</td>
					</tr>
					{if count($res.record.attach)>0}
					<tr>
						<td bgcolor=#F5F9FA align="left">
							<TABLE width=100% cellpadding=2 cellspacing=0 border=0>
								<tr>
								{foreach from=$res.record.attach item=lat key=k}
								{if !$res.record.hideimages}
									{if $lat.prop == "img"}
										<img src="{$lat.url}" width={$lat.w} height={$lat.h} border=0 alt="">
									{else}
										<a target="_blank" href="{$CONFIG.files.get.imgzoom.string}?img={$lat.original.url}"onmouseover="window.status='Кликни для увеличения';return true;"onmouseout="window.status=defaultStatus" onclick="javascript:ImgZoom('{$CONFIG.files.get.imgzoom.string}?img={$lat.original.url}','imgr{$res.record.id}_{$k}',{$lat.original.w+20},{$lat.original.h+40});return false;"><img src="{$lat.url}" width={$lat.w} height={$lat.h} border=0 alt="Кликни для увеличения"></a>
									{/if}
								{else}Аттач{$k}{/if}
								{/foreach}
								</tr>
							</TABLE>
						</td>
					</tr>
					{/if}

					{assign var=_issubscribe value=`$res.record.issubscribe`}
					{if $USER->ID > 0}
					<tr>
						<td bgcolor=#F5F9FA>
							<TABLE width=100% cellpadding=2 cellspacing=0 border=0>
							<tr>
								<td align=left nowrap>
								{if !$res.record.issubscribe}
									<a href="{$CONFIG.files.get.subs_subscribe.string}?type=2&uid={$res.record.uid}&rid={$res.record.id}" class="s4" title="Уведомлять меня о новых комментариях на эту запись">Подписаться на новые комментарии</a>
								{/if}
								</td>
								<td align=right nowrap>
								{if $USER->IsAuth() && $res.record.uid==$USER->ID}
									<a href="{$CONFIG.files.get.journals_record_edit.string}?id={$res.record.uid}&rid={$res.record.id}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class=s4>Редактировать</a>
									&nbsp;&nbsp;&nbsp;
									<a href="{$CONFIG.files.get.journals_record_del.string}?id={$res.record.uid}&rid={$res.record.id}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class=s4>Удалить</a>
								{/if}
								</td>
							</tr>
							</TABLE>
						</td>
					</tr>
					{/if}
				</table>
			</td>
		</tr>
	</table>

{else}<br/><br/><br/>
{php}
$this->_tpl_vars['_nocomment'] = true;
{/php}

<center>Запись не найдена.</center><br/><br/>
{/if}