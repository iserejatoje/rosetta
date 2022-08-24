
{if $res.place !== null}

<!-- Details [BEGIN] -->

<table cellspacing="0" border="0" width="100%" class="table2">
	<tr>
		<td colspan="2">&#160;</td>
	</tr>
	{if $res.place->LogotypeSmall.file}
	<tr>
		<td colspan="2" align="center"><img src="{$res.place->LogotypeSmall.file}" width="{$res.place->LogotypeSmall.w}" height="{$res.place->LogotypeSmall.h}" /></td>
	</tr>
	{/if}
	<tr>
		<td colspan="2" align=center class="title2">{$res.place->LegalType} {$res.place->Name}</td>
	</tr>
	<tr>
		<td colspan="2" class="text11" align="center"><b>{foreach from=$TITLE->Path item=url name=path}{
				if !$smarty.foreach.path.first}&nbsp;/&nbsp;{/if
				}{if !$smarty.foreach.path.last || !empty($url.link)
					}<a href="/{$ENV.section}/{$url.link}">{$url.name}</a>{
				else
					}{$url.name}{
				/if}{/foreach}</b></td>
	</tr>
	<tr>
		<td colspan="2">&#160;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="2" width="100%" class="table2">
				<tr>
					<td class="bg_color2" align="right" width="130">Город</td>
					<td class="bg_color4">{$res.place->Address->CityAsText}</td>
				</tr>
{if !empty($res.place->Address->Text) || !empty($res.place->Address->StreetText) || !empty($res.place->Address->HouseText)}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес</td>
					<td class="bg_color4">{if $res.place->Address->Text}{$res.place->Address->Text}{else}{$res.place->Address->StreetText}{if $res.place->Address->HouseText}, {$res.place->Address->HouseText}{/if}{/if}</td>
				</tr>
{/if}
{if !empty($res.place->Director)}
				<tr>
					<td class="bg_color2" align="right" width="130">Руководитель</td>
					<td class="bg_color4">{$res.place->Director}</td>
				</tr>
{/if}
{if !empty($res.place->ContactInfo->Name)}
				<tr>
					<td class="bg_color2" align="right" width="130">Контактное лицо</td>
					<td class="bg_color4">{$res.place->ContactInfo->Name}</td>
				</tr>
{/if}
{if !empty($res.place->ContactInfo->Phone)}
				<tr>
					<td class="bg_color2" align="right" width="130">Телефон</td>
					<td class="bg_color4">{$res.place->ContactInfo->Phone}</td>
				</tr>
{/if}
{if !empty($res.place->ContactInfo->Fax)}
				<tr>
					<td class="bg_color2" align="right" width="130">Факс</td>
					<td class="bg_color4">{$res.place->ContactInfo->Fax}</td>
				</tr>
{/if}
{if !empty($res.place->ContactInfo->Email)}
				<tr>
					<td class="bg_color2" align="right" width="130">E-Mail</td>
					<td class="bg_color4">{$res.place->ContactInfo->Email|mailto_crypt}</td>
				</tr>
{/if}
{if !empty($res.place->ContactInfo->Url)}
				<tr>
					<td class="bg_color2" align="right" width="130">HTTP</td>
					<td class="bg_color4"><noindex><a href="http://{$res.place->ContactInfo->Url}" target="_blank">{$res.place->ContactInfo->Url}</a></noindex></td>
				</tr>
{/if}
			</table>
		</td>
	</tr>
	<tr>
		<td class="text11"><a onclick="window.open('about:blank', 'attention','width=600,height=550,resizable=1,menubar=0,scrollbars=1').focus();" target="attention" href="/{$ENV.section}/attention/{$res.place->ID}/">Сообщить о неточностях</a></td>
		<td align="right" class="text11"><a href="/{$ENV.section}/list/{$res.scid}/">Вернуться</a></td>
	</tr>
	<tr>
		<td colspan="2">{$res.place->Info}</td>
	</tr>
</table>

<!-- Details [END] -->

{/if}
