<div style="margin-top: 15px;">
{foreach from=$res.data item=l}
	<div align="center" style="padding-bottom: 10px;">
		{include file="`$config.templates.users_block`" user=$l}
	</div>
{/foreach}
<div style="padding:5px;" align="center"><a href="/passport/users_birthday.php">Все именинники</a></div>

</div>
