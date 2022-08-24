<html>
	<head>
		<title>Ошибка 403: Доступ к запрошенной странице запрещен</title>
	</head>
	<style>{literal}
		BODY {font-family:Arial;padding:40px;}
	{/literal}</style>
	<body>
		<div align="center">
			<img src="{$res.logo}" />
		</div>
		<h1>Приносим свои извинения...</h1>

		<p>... но ваш запрос похож на запросы, автоматически рассылаемые компьютерным вирусом или вредоносным программным обеспечением. В целях защиты наших пользователей мы не можем обработать ваш запрос немедленно.</p>
		<p>Мы восстановим ваш доступ в кратчайшие сроки, поэтому повторите попытку через некоторое время. Пока же, если вы считаете, что ваш компьютер или локальная сеть могут быть заражены, то можете запустить приложение для проверки на наличие вирусов или удаления шпионских программ, чтобы убедиться, ваши компьютеры не заражены вирусами или вредоносным ПО.</p>
		<p>Мы приносим извинения за неудобства и надеемся, что вскоре вы снова будете пользоваться нашим сайтом. </p>
		<div align="center">
{if $res.status == 'captcha' || $res.status == 'wait'}
			<form action="{$res.action}">
{if $smarty.server.REQUEST_METHOD=='POST'}
{foreach from=$smarty.post item=l key=k}
				<input type="hidden" name="{$k}" value="{$l}" />
{/foreach}
{elseif $smarty.server.REQUEST_METHOD=='GET'}
{foreach from=$smarty.get item=l key=k}
{if $k != 'params' && $k != 'section'}
				<input type="hidden" name="{$k}" value="{$l}" />
{/if}
{/foreach}
{/if}
{/if}
{if $res.status === "captcha"}
				<div>
					<input type="text" name="captcha_code" value="" style="width:150px" /><br />
					<img src="{$res.captcha}" width="150" height="50" border="0" /><br />
					<div class="tip">введите, пожалуйста, число, которое вы видите на картинке</div>
					<div><input type="submit" value="продолжить" /></div>
				</div>
{elseif $res.status === "wait"}
				<script type="text/javascript" language="javascript">{literal}
					var now = new Date();
					var af_time_end = now.getTime() + {/literal}{$res.wait}{literal}*1000;
					function af_timer()
					{
						var now = new Date();
						var timeleft = af_time_end - now.getTime();
						var tl = Math.round(timeleft / 100) / 10;
						if(tl - Math.round(tl) == 0)
							tl += '.0';
						document.getElementById('af_time').innerHTML = tl;
						if(timeleft <= 0)
						{
							clearInterval(af_timer_interval);
							document.getElementById('af_captcha_img').src = "{/literal}{$res.captcha}{literal}";
							document.getElementById('af_timer_block').style.display = 'none';
							document.getElementById('af_captcha_block').style.display = '';
						}
					}
					var af_timer_interval = setInterval(af_timer, 100);
				{/literal}</script>
				<div style="display:none" id="af_captcha_block">
					<input type="text" name="captcha_code" value="" style="width:150px" /><br />
					<img src="/_img/x.gif" id="af_captcha_img" width="150" height="50" border="0" /><br />
					<div class="tip">введите, пожалуйста, число, которое вы видите на картинке</div>
					<div><input type="submit" value="продолжить" /></div>
				</div>
				<div id="af_timer_block">для получения кода, вам необходимо подождать <span id="af_time"></span>&nbsp;секунд</div>
{elseif $res.status === "block"}
				<div>Ваш запрос не может быть обработан в настоящее время, попробуйте позже.</div>
{/if}

{if $res.status == 'captcha' || $res.status == 'wait'}
			</form>
{/if}
		</div>
	</body>
</html>