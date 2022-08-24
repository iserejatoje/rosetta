<link rel="stylesheet" type="text/css" href="/resources/scripts/themes/frameworks/extjs/2.0.2/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="/resources/scripts/themes/frameworks/extjs/2.0.2/resources/css/add-all.css" />
<script type="text/javascript" src="/resources/scripts/themes/frameworks/extjs/2.0.2/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/extjs/2.0.2/ext-all.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/extjs/2.0.2/addon/tree/statetree.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/extjs/2.0.2/ext-config.js"></script>
<script type="text/javascript" src="/resources/scripts/modules/users/users_main.js"></script>
<script type="text/javascript">{literal}
Ext.onReady(function(){
	users = new PUsers('{/literal}{$SECTION_ID_URL}{literal}');
});
{/literal}</script>
<div><input type="button" id="users_users_btn" value="Пользователи"> <input type="button" id="users_groups_btn" value="Группы"> <input type="button" id="users_roles_btn" value="Роли"></div><br>
<form method="post" onsubmit="return checkaction();">
{$SECTION_ID_FORM}

<center>{$smarty.capture.pages}</center><br />
<div align="right"><nobr>
<select name="action" id="action">
<option value="">- Выберите действие -</option>
</select>
<input type="submit" value="Ок" />
</nobr></div>
</form>

{include file="users/users.tpl"}
{include file="users/roles.tpl"} 
{include file="users/groups.tpl"} 

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
