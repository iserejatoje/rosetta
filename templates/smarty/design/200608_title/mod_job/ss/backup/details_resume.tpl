	{capture name="rname"}
		Просмотр данных по резюме {$res.id}
	{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

{if $res.in_state == 1 && !$res.archive}

	<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	{if $res.city}
		<tr>
			<td class="bg_color2" align='right' width="130">Город</td>
			<td class="bg_color4">{$res.city}</td>
		</tr>
	{/if}
	{if $res.dolgnost}
	<tr>
			<td class="bg_color2" align='right' width="130">Должность</td>
			<td class="bg_color4">{$res.dolgnost}</td>
	</tr>
	{/if}
	<tr>
		<td class="bg_color2" align='right' width="130"></td>
		<td class="bg_color4">Срок размещения резюме истек</td>
	</tr>
	</table>
{elseif is_array($res) && !sizeof($res) }
	<div align="center">
		<span style="color:red;"><b>Запрошенное вами резюме не найдено</b></span><br/><br/>
		<a href="/{$ENV.section}/resume/1.php">Перейти к списку резюме</a>
	</div>
{else}

	<div align="right" class="text11" style="padding-bottom:3px">
	{if $USER->IsAuth() && !$res.fav}<span id="ln{$res.id}"><a class="ssyl" href="/{$ENV.section}/favorites/add/resume/{$res.id}.php" onclick="mod_job.toFavorites({$res.id}, 'resume'); return false;">Добавить резюме в избранное</a>&nbsp;|&nbsp;</span>{/if
	}<a href="/{$ENV.section}/resume/{$res.id}.html?print" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
	</div>

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
					{if !empty($res.replyjs) && !isset($rjs)}
					<tr>
						<td class="bg_color2" align="right" width="130"></td>
						<td class="bg_color4"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
					</tr>
					{/if}
					{if $res.email}
					<tr>
						<td class="bg_color2" align="right" width="130">E-mail</td>
						{php}
						if ($this->_tpl_vars['res']['email'] != '') {
							$this->_tpl_vars['res']['email'] = explode(',',$this->_tpl_vars['res']['email']);
							foreach($this->_tpl_vars['res']['email'] as &$m)
								$m = '<a href="mailto:'.trim($m).'"/>'.trim($m).'</a>';
							$this->_tpl_vars['res']['email'] = implode(', ',$this->_tpl_vars['res']['email']);
						}
						{/php}
						<td class="bg_color4">{*if $res.email != ""}{$res.email|mailto_crypt}{/if*}{$res.email}</td>
					</tr>
					{/if}
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
					{*if !empty($res.replyjs)}
					<tr>
						<td colspan="2" align="center" class="text11"><a href="#" onclick="{$res.replyjs};return false;">Отправить личное сообщение</a></td>
					</tr>
					{/if*}
					<tr>
						<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/resume.php">Редактировать резюме</a></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="text11"><a href="/{$ENV.section}/my/resume.php">Удалить резюме</a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
{/if}<br/>
{include file="`$TEMPLATE.midbanner`"}<br/><br/>