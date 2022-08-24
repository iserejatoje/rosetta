{capture name="link"}{if $ENV.regid == 74 && $res.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
{capture name="target"}{if $ENV.regid == 74 && in_array($res.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.image.file)}<td><img src="{$res.image.file}" width="{$res.image.w}" height="{$res.image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
				{if $res.city}
				<tr>
					<td align="right" width="130"><b>Город:</b></td>
					<td>{$res.city}</td>
				</tr>
				{/if}
				{if $res.grafik}
				<tr>
					<td align="right" width="130"><b>График работы:</b></td>
					<td>{$res.grafik}</td>
				</tr>
				{/if}
				{if $res.educat}
				<tr>
					<td align="right" width="130"><b>Образование:</b></td>
					<td>{$res.educat}</td>
				</tr>
				{/if}
				{if $res.stage}
				<tr>
					<td align="right" width="130"><b>Стаж:</b></td>
					<td>{$res.stage}</td>
				</tr>
				{/if}
				{if $res.dopsv}
				<tr>
					<td align="right" width="130"><b>Дополнительные<br/>сведения:</b></td>
					<td>{$res.dopsv|nl2br}</td>
				</tr>
				{/if}
				<tr>
					<td colspan="2" align="right"><a href="{$smarty.capture.link}resume/{$res.id}.html{if $res.archive == 1}?archive{if $res.rid}&rid={$res.rid}{/if}{elseif $res.rid}?rid={$res.rid}{/if}" class="tip"{$smarty.capture.target}>подробнее...</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>