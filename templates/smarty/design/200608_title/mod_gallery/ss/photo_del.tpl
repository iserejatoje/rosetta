<br/><br/><div align="center">
{if $page.errors.success}
<font color="green"><b>{$page.errors.success}</b></font>
<br/><br/><a href="/{$ENV.section}/">На главную</a> | <a href="/{$ENV.section}/list/photos/{$page.aid}.html">Вернуться в альбом</a>
{else}
<font color="red"><b>{$page.errors.global}</b></font>
<br/><br/><a href="/{$ENV.section}/">На главную</a> | <a href="javascript:void(0)" onclick="window.history.go(-1)">Назад</a>
{/if}
</div>
