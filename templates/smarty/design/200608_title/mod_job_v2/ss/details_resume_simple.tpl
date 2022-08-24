{capture name="link"}{if $ENV.regid == 74 && $res.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($res.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
{capture name="target"}{if $ENV.regid == 74 && in_array($res.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.Image.file)}<td><img src="{$res.Image.file}" width="{$res.Image.w}" height="{$res.Image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
				{if $res.CityText}
				<tr>
					<td align="right" width="130"><b>Город:</b></td>
					<td width="100%">{$res.CityText}</td>
				</tr>
				{/if}
				{if $res.Schedule}
				<tr>
					<td align="right" width="130"><b>График&nbsp;работы:</b></td>
					<td width="100%">{$res.Schedule}</td>
				</tr>
				{/if}
				{if $res.Education}
				<tr>
					<td align="right" width="130"><b>Образование:</b></td>
					<td width="100%">{$res.Education}</td>
				</tr>
				{/if}
				{if $res.Stage}
				<tr>
					<td align="right" width="130"><b>Стаж:</b></td>
					<td width="100%">{$res.Stage}</td>
				</tr>
				{/if}
				{if $res.About}
				<tr>
					<td align="right" width="130"><b>Дополнительные<br/>сведения:</b></td>
					<td width="100%">{$res.About|nl2br}</td>
				</tr>
				{/if}
				<tr>
					<td colspan="2">
						<table cellspacing="0" cellpadding="0" width="100%"><tr>
							<td width="75%" align="left">
								{if $res.show_incorrect == 1}Это объявление некорректно? <a class="tip" href="#" onclick="mod_job_incorrect_obj.show({$res.ResumeID}, 'resume'); return false;">Сообщите нам об этом</a>.{/if}
							</td>
							<td width="25%" align="right">		
								<a href="{$smarty.capture.link}resume/{$res.ResumeID}.html{if $res.archive == 1}?archive{if $res.BranchID}&rid={$res.BranchID}{/if}{elseif $res.BranchID}?rid={$res.BranchID}{/if}" class="tip"{$smarty.capture.target}>подробнее...</a>
							</td>	
						</tr></table>
					</td>			
				</tr>		
			</table>
		</td>
	</tr>
</table>
<div id="incorrect_container_{$res.ResumeID}" class="incorrect_container" align="center" style="display: none;">&nbsp;</div>