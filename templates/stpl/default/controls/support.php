<center style="padding: 15px 0 15px 0;">
	Если у вас возникли трудности при размещении или удалении объявлений,<br>
	позвоните по телефону техподдержки (351) 7-0000-74 или 
	воспользуйтесь <font style="cursor: pointer; text-decoration: underline;" title="Открыть" target="ublock" onclick="window.open('http://<?=App::$CurrentEnv['site']['regdomain']?>/feedback/?from=<?=App::$CurrentEnv['sectionid']?>&amp;target=4', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">формой обратной связи</font>.<br>
	Техподдержка по телефону осуществляется в будние дни с <?=Datetime_my::DateOffset(null,strtotime('08:30'),'H:i');?> до <?=Datetime_my::DateOffset(null,strtotime('18:00'),'H:i');?><? if ( App::$CurrentEnv['regid'] != 74 ): ?> (звонок платный, <br />согласно тарифу международной телефонной связи до г.Челябинск)<? endif; ?>.
</center>