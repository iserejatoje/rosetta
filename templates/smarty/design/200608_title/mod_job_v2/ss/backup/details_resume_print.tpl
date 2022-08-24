{$res.script}

<script language="javascript">
{literal}
<!--
window.print();
-->
{/literal}
</script>
{capture name="rname"}
	<b>Просмотр данных по резюме {$res.id}</b>
{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`" hide_search=true}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.image.file)}<td><img src="{$res.image.file}" width="{$res.image.w}" height="{$res.image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				{if $res.fio}
				<tr>
					<td class="bg_color2" align="right" width="130">Ф.И.О.</td>
					<td class="bg_color4">{$res.fio}</td>
				</tr>
				{/if}
				{if $res.city}
				<tr>
					<td class="bg_color2" align="right" width="130">Город</td>
					<td class="bg_color4">{$res.city}</td>
				</tr>
				{/if}
				{if $res.dolgnost}
				<tr>
					<td class="bg_color2" align="right" width="130">Должность</td>
					<td class="bg_color4">{$res.dolgnost}</td>
				</tr>
				{/if}
				{if $res.pay}
				<tr>
					<td class="bg_color2" align="right" width="130">Зарплата</td>
					<td class="bg_color4">{$res.pay}</td>
				</tr>
				{/if}
				{if $res.grafik}
				<tr>
					<td class="bg_color2" align="right" width="130">График работы</td>
					<td class="bg_color4">{$res.grafik}</td>
				</tr>
				{/if}
				{if $res.jtype}
				<tr>
					<td class="bg_color2" align="right" width="130">Тип работы</td>
					<td class="bg_color4">{$res.jtype}</td>
				</tr>
				{/if}
				{if $res.educat}
				<tr>
					<td class="bg_color2" align="right" width="130">Образование</td>
					<td class="bg_color4">{$res.educat}</td>
				</tr>
				{/if}
				{if $res.vuz}
				<tr>
					<td class="bg_color2" align="right" width="130">Уч. заведение</td>
					<td class="bg_color4">{$res.vuz|nl2br}</td>
				</tr>
				{/if}
				{if $res.stage}
				<tr>
					<td class="bg_color2" align="right" width="130">Стаж</td>
					<td class="bg_color4">{$res.stage}</td>
				</tr>
				{/if}
				{if $res.prevrab}
				<tr>
					<td class="bg_color2" align="right" width="130">Предыдущие места<br>работы</td>
					<td class="bg_color4">{$res.prevrab|nl2br}</td>
				</tr>
				{/if}
				{if $res.lang}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание языков</td>
					<td class="bg_color4">{$res.lang|nl2br}</td>
				</tr>
				{/if}
				{if $res.comp}
				<tr>
					<td class="bg_color2" align="right" width="130">Знание компьютера</td>
					<td class="bg_color4">{$res.comp|nl2br}</td>
				</tr>
				{/if}
				{if $res.baeduc}
				<tr>
					<td class="bg_color2" align="right" width="130">Бизнес-образование</td>
					<td class="bg_color4">{$res.baeduc|nl2br}</td>
				</tr>
				{/if}
				{if $res.dopsv}
				<tr>
					<td class="bg_color2" align="right" width="130">Дополнительные<br/>сведения</td>
					<td class="bg_color4">{$res.dopsv|nl2br}</td>
				</tr>
				{/if}
				{if $res.imp_type}
				<tr>
					<td class="bg_color2" align="right" width="130">Важность</td>
					<td class="bg_color4">{$res.imp_type}</td>
				</tr>
				{/if}
				{if $res.pol}
				<tr>
					<td class="bg_color2" align="right" width="130">Пол</td>
					<td class="bg_color4">{$res.pol}</td>
				</tr>
				{/if}
				{if $res.ability}
				<tr>
					<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности</td>
					<td class="bg_color4">{$res.ability}</td>
				</tr>
				{/if}
				{if $res.age}
				<tr>
					<td class="bg_color2" align="right" width="130">Возраст</td>
					<td class="bg_color4">{$res.age}</td>
				</tr>
				{/if}
				{if $res.http}
				<tr>
					<td class="bg_color2" align="right" width="130">http://</td>
					<td class="bg_color4">{if $res.http!=""}<noindex><a href="http://{$res.http|url:false}" target="_blank">{$res.http|url:false}</a></noindex>{/if}</td>
				</tr>
				{/if}
				<tr>
					<td class="bg_color2" align="right" width="130">E-mail</td>
					<td class="bg_color4">{if $res.email != ""}{$res.email}{/if}</td>
				</tr>
				{if $res.phoneh}
				<tr>
					<td class="bg_color2" align="right" width="130">Домашний тел.</td>
					<td class="bg_color4">{$res.phoneh}</td>
				</tr>
				{/if}
				{if $res.phoner}
				<tr>
					<td class="bg_color2" align="right" width="130">Рабочий тел.</td>
					<td class="bg_color4">{$res.phoner}</td>
				</tr>
				{/if}
				{if $res.faxes}
				<tr>
					<td class="bg_color2" align="right" width="130">Факс</td>
					<td class="bg_color4">{$res.faxes}</td>
				</tr>
				{/if}
				{if $res.addr}
				<tr>
					<td class="bg_color2" align="right" width="130">Адрес</td>
					<td class="bg_color4">{$res.addr}</td>
				</tr>
				{/if}
			</table>
		</td>
	</tr>
</table>
<br/>
<div style="text-align:center"><a href='javascript:window.close()'>Закрыть</a></div><br/>