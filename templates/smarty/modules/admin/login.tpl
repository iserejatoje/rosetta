<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" type="text/css" href="/site.css">
<title></title>
</head>
<body>
<form method="post">
<table width="100%" height="100%">
<tr><td align="center" valign="center">
	<table>
{if sizeof($ERROR) > 0}
{foreach from=$ERROR item=l}
<tr><td colspan="2" style="color:red">{$l}</td></tr>
{/foreach}
{/if}
		<tr><td width="80">E-Mail</td><td width="100"><input type="text" name="email" value="{$res.email}" class="input" style="width:100px"></td></tr>
		<tr><td>Пароль</td><td><input type="password" name="password" value="" class="input" style="width:100px"></td></tr>
		<tr><td></td><td><input type="checkbox" id="remember" name="remember" value="1"{if $res.remember==1} checked="checked"{/if}><label for="remember"> запомнить</label></td></tr>
		<tr><td></td><td><input type="submit" value="войти"></td></tr>		
	</table>
</td></tr>
</table>
</form>
</body>
</html>