{if $page.errors.success}
<br/><br/>
<div align="center" class="t7">{$page.errors.success}<br/><br/>
<a href="/{$ENV.section}/">На главную</a> | <a href="/{$ENV.section}/user/login.html">Авторизация</a></div>
{elseif $page.errors.global}
<div><font color="red"><b>{$page.errors.global}</b></font></div>
{/if}