<div class="title">
    <span>Отправка SMS</span>
</div>

<div class="content">
	<input type="hidden" name="do" value="send" />
	<div class="line">
		<select id="Oper" name="Oper">
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
		№ аб.:&nbsp;<input id="To" name="To" value="735190xxxxx" size="12" />
	</div>
	<div class="line">Сообщение (не более 160 символов):</div>
	<div class="line"><textarea id="Msg" name="Msg" rows="4" wrap="virtual" style="width: 90%;"></textarea></div>
	<div class="line">Вы набрали сообщение длиной <input type="text" id="Count" name="count" value="0" size="4" OnFocus="window.document.FSend.Msg.focus();" />&nbsp;символов.</div>
	<div class="line">
		<input type="submit" value="Отправить" OnClick="{$widget.instance}.beforeReload = widget_sms.prepareToSend;{$widget.instance}.reload();{$widget.instance}.beforeReload = null;" />
		&nbsp;<input type="reset" value="Очистить" />
	</div>
	<div class="line">
		Отправка SMS-сообщений на:
		&nbsp;<noindex><a target="_blank" href="{if $CURRENT_ENV.site.domain=="74.ru"}http://www.beeline.ru/sms/index.wbp?region=chelyabinsk{else}http://www.beeline.ru/sms/index.wbp{/if}">Билайн</a>,
		&nbsp;<a target="_blank" href="{if $CURRENT_ENV.site.domain=="74.ru"}http://sms.chel.mts.ru/{else}http://sms.mts.ru/{/if}">МТС</a>,
		&nbsp;<a align="left" class="a11" target="_blank" href="http://ural.megafon.ru/sms/">Мегафон</a>, 
		&nbsp;<a target="_blank" href="http://sms.tele2.ru/">Теле2</a></noindex>
	</div>
</div>
<script language="JavaScript" type="text/javascript">widget_sms.setHandlers('FSend', 'Msg', 'Count', 'Oper', 'To');</script>