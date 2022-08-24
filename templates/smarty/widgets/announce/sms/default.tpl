<table class="t12" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left">
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">Отправка SMS</td></tr>
				<tr><td align="left" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td></tr>
			</table>
		</td>
	</tr>
	<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
	<tr>
		<td>
			<input type="hidden" name="do" value="send" />
			<table class="t12" width="100%" align="center" cellpadding="1" cellspacing="0" border="0">
				<tr><td colspan="2" align="center">
					<select id="Oper" name="Oper" style="font-size:12px;font-family:helvetica, tahoma,  Arial Cyr; width:124;">
						{foreach from=$res.operators key=k item=l}
						<option value="{$k}">{$l.title}</option>
						{/foreach}
					</select>
					<script language="JavaScript" type="text/javascript">
					{foreach from=$res.operators key=k item=l}
					widget_sms.addNum('{$k}', '{$l.title}', '{$l.pattern}');
					{/foreach}
					</script>
					&nbsp;&nbsp;
					№ аб.:&nbsp;<input id="To" name="To" value='735190xxxxx' style="font-size:12px;font-family:helvetica, tahoma,  Arial Cyr;" size="12" />
				</td></tr>
				<tr><td colspan="2" align="center" class="t11">Сообщение (не более 160 символов):</td></tr>
				<tr><td colspan="2" align="center"><textarea id="Msg" name="Msg" rows="4" wrap="virtual" style="width:90%;font-size:12px;font-family:helvetica, tahoma,  Arial Cyr;"></textarea></td></tr>
				<tr><td align="left" colspan="2" class="t11">Вы набрали сообщение длиной <input size="4" value="0" id="Count" name="count" type="text" style="font-size:10px;font-family:helvetica, tahoma,  Arial Cyr;" onfocus="window.document.FSend.Msg.focus();">&nbsp;символов.</td></tr>
				<tr><td colspan="2" align="center">
					<input type="submit" value="Отправить" style="font-size:12px;font-family:helvetica, tahoma,  Arial Cyr;" onclick="{$widget.instance}.beforeReload = widget_sms.prepareToSend;{$widget.instance}.reload();{$widget.instance}.beforeReload = null;">
					<img src="/_img/x.gif" width="3" height="1" alt="" />
					<input type="reset" VALUE="Очистить" style="font-size:12px;font-family:helvetica, tahoma,  Arial Cyr;" /></td></tr>
				<tr><td><img src="/_img/x.gif" width="1" height="3" border="0" alt="" /></td></tr>
				<tr><td colspan="2" align="center" class="t11" nowrap>
					Отправка SMS-сообщений на:
					&nbsp;<noindex><a align="left" class="a11" target="_blank" href="{if $CURRENT_ENV.site.domain=="74.ru"}http://www.beeline.ru/sms/index.wbp?region=chelyabinsk{else}http://www.beeline.ru/sms/index.wbp{/if}">Билайн</a>,
					&nbsp;<a align="left" class="a11" target="_blank" href="{if $CURRENT_ENV.site.domain=="74.ru"}http://sms.chel.mts.ru/{else}http://sms.mts.ru/{/if}">МТС</a>,
					&nbsp;<a align="left" class="a11" target="_blank" href="http://ural.megafon.ru/sms/">Мегафон</a>,  
					&nbsp;<a align="left" class="a11" target="_blank" href="http://sms.tele2.ru/">Теле2</a></noindex>

				</td></tr>
			</table>
 		</td>
	</tr>
</table>
<script language="JavaScript" type="text/javascript">widget_sms.setHandlers('FSend', 'Msg', 'Count', 'Oper', 'To');</script>