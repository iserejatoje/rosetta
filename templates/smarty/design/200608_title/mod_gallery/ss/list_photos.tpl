{if $page.errors.global}
<br/><br/><div align="center"><font color="red"><b>{$page.errors.global}</b></font><br/><br/>
<a href="/{$ENV.section}/">На главную</a> | <a href="javascript:void(0)" onclick="window.history.go(-1)">Назад</a></div><br/><br/>
{else}

{$page.list}
{/if}