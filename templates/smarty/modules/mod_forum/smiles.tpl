<html>
<head>
<title>Выберите смайл</title>
<link href="/forum.css" rel="stylesheet" type="text/css" />
<script>{literal}
function _insertsmile(val)
{
	opener.insertsmile(val);
}
{/literal}</script>
</head>
<body>
<table width="100%">
{foreach from=$smiles item=sr}
<tr>
{foreach from=$sr key=k item=v}
	<td><img class="ftoolbutton" onClick="_insertsmile('{$k}')" src="/_img/modules/forum/smiles/{$v}" border="0"></td>
{/foreach}
</tr>
{/foreach}
</table>
</body>
</html>