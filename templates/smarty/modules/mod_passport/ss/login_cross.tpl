<html>
<head>
	<title>{$TITLE->Title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

	<link rel="stylesheet" type="text/css" href="/_styles/design/200608_title/common/styles.css" />

{*if count($TITLE->Scripts)>0}
	{foreach from=$TITLE->Scripts item=l}
	<script type="{if $l.type}{$l.type}{else}{/if}" language="javascript" src="{$l.src}"></script>
	{/foreach}
{/if}
{if count($TITLE->Styles)>0}
	{foreach from=$TITLE->Styles item=l}
	<link rel="stylesheet" type="text/css" href="{$l.src}" />
	{/foreach}
{/if*}
</head>
<body onload="setTimeout('window.location.href = \'{$res.redirect_url}\'',70)">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
	<td>
{if isset($res.redirect_url) }
<div align="center">
<div align="center" style="width:600px">
<br /><br /><br />
{if $res.state != 'login'}
Идет процесс выхода из системы. Пожалуйста, подождите.<br /><br />
{else}


Идет процесс входа на сайт {$res.cdomain}.
Выполнено {$res.progress} %<br/>
	{if is_array($res.rest_domains) && sizeof($res.rest_domains)}
	
		<br/>Оставшиеся сайты: 
		{foreach from=$res.rest_domains item=l name=ddd}
			{"@https?://@"|preg_replace:'':$l}{if !$smarty.foreach.ddd.last}, {/if}
		{/foreach}<br/>
	{/if}


<br />Пожалуйста, подождите...<br /><br />


{/if}
	<a href="{$res.redirect_url}">Нажмите на ссылку если страница не обновляется продолжительное время</a>
	{if isset($res.sdomain)}
	<br/><br/>
	<a href="{$res.sdomain}{$res.url|urldecode}">Прервать</a>
	{/if}
	<br><br><br><br clear="both">
	<table width="530" cellpadding="5" border="0" bgcolor="#e0f3f3">
		<tr>
			<td>
			Вы сможете пользоваться всеми сервисами на сайтах:
			{foreach from=$res.domains item=l name=ddd}
			{$l}{if !$smarty.foreach.ddd.last}, {/if}
			{/foreach}
			без дополнительного введения е-мейла и пароля, это удобно.
			<br/>
			<br/>
			Если Вы хотите авторизовываться только на текущем сайте (что позволит экономить время при частых «входах» и «выходах»), снимите галочку в соответствующем поле на странице «Настройки» ->
			<a target="_blank" href="{$res.sdomain}/passport/profile/privacy.php">Конфиденциальность</a>.
			</td>
		</tr>
</table>
	
</div></div>{/if}
	</td>
</tr>
</table>
</body>
</html>
