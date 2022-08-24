
	{capture name="rname"}
		Просмотр данных по резюме {$res.id}
	{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>
<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr valign="top">
		{if !empty($res.image.file)}<td><img src="{$res.image.file}" width="{$res.image.w}" height="{$res.image.h}" alt="{$res.fio|escape:"html"}" hspace="2" vspace="2" align="left"/></td>{/if}
		<td width="100%">
			<table cellpadding="4" cellspacing="1" border="0" width="100%">
				{if $res.fio}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Ф.И.О.</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.fio}</td>
				</tr>
				{/if}
				{if $res.city}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Город</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.city}</td>
				</tr>
				{/if}
				{if $res.dolgnost}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Должность</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.dolgnost}</td>
				</tr>
				{/if}
				{if $res.pay}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Зарплата</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.pay}</td>
				</tr>
				{/if}
				{if $res.grafik}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">График работы</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.grafik}</td>
				</tr>
				{/if}
				{if $res.jtype}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Тип работы</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.jtype}</td>
				</tr>
				{/if}
				{if $res.educat}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Образование</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.educat}</td>
				</tr>
				{/if}
				{if $res.vuz}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Уч. заведение</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.vuz|nl2br}</td>
				</tr>
				{/if}
				{if $res.stage}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Стаж</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.stage}</td>
				</tr>
				{/if}
				{if $res.prevrab}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Предыдущие места<br>работы</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.prevrab|nl2br}</td>
				</tr>
				{/if}
				{if $res.lang}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Знание языков</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.lang|nl2br}</td>
				</tr>
				{/if}
				{if $res.comp}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Знание компьютера</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.comp|nl2br}</td>
				</tr>
				{/if}
				{if $res.baeduc}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Бизнес-образование</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.baeduc|nl2br}</td>
				</tr>
				{/if}
				{if $res.dopsv}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Дополнительные<br/>сведения</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.dopsv|nl2br}</td>
				</tr>
				{/if}
				{if $res.imp_type}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Важность</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.imp_type}</td>
				</tr>
				{/if}
				{if $res.pol}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Пол</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.pol}</td>
				</tr>
				{/if}
				{if $res.ability}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Степень ограничения трудоспособности</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.ability}</td>
				</tr>
				{/if}
				{if $res.age}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Возраст</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.age}</td>
				</tr>
				{/if}
				{if $res.http}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">http://</td>
					<td class="dopp" bgcolor="#F6FBFB">{if $res.http != ""}<noindex><a href="http://{$res.http}" target="_blank">{$res.http|trim:" / "}</a></noindex>{/if}</td>
				</tr>
				{/if}
				{if $res.email}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">E-mail</td>
					{php}
					if ($this->_tpl_vars['res']['email'] != '') {
						$this->_tpl_vars['res']['email'] = explode(',',$this->_tpl_vars['res']['email']);
						foreach($this->_tpl_vars['res']['email'] as &$m)
							$m = '<a href="mailto:'.trim($m).'"/>'.trim($m).'</a>';
						$this->_tpl_vars['res']['email'] = implode(', ',$this->_tpl_vars['res']['email']);
					}
					{/php}
					<td class="dopp" bgcolor="#F6FBFB">{*if $res.email != ""}{$res.email|mailto_crypt}{/if*}{$res.email}</td>
				</tr>
				{/if}
				{if $res.phoneh}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Домашний тел.</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.phoneh}</td>
				</tr>
				{/if}
				{if $res.phoner}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Рабочий тел.</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.phoner}</td>
				</tr>
				{/if}
				{if $res.faxes}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Факс</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.faxes}</td>
				</tr>
				{/if}
				{if $res.addr}
				<tr>
					<td class="dopp" bgcolor="#E3F6FF" align="right" width="130">Адрес</td>
					<td class="dopp" bgcolor="#F6FBFB">{$res.addr}</td>
				</tr>
				{/if}
				{if $USER->IsAuth() && !$res.fav}
				<tr id="ln{$res.id}">
					<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/favorites/add/resume/{$res.id}.php" onclick="mod_job.toFavorites({$res.id}, 'resume'); return false;">Добавить резюме в избранное</a></td>
				</tr>
				{/if}
				<tr>
					<td colspan="2" align="center" class="s1"><a href="http://74.ru/job/my/resume.php" target="_blank">Редактировать резюме</a></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="s1"><a href="http://74.ru/job/my/resume.php" target="_blank">Удалить резюме</a></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="s1"><a href="/{$ENV.section}/resume/{$res.id}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br/>
{*include file="`$TEMPLATE.midbanner`"*}<br/><br/>