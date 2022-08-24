<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding-left:10px;padding-right:10px;">
{if $page.system_message}
				<br/><br/>{$page.system_message}<br/><br/>
{else}
	{if $page.image_big}

				{$page.showview}
				{$page.comments}
				<a name="addcomment"></a>
				{$page.form}
	{else}
		<br /><br />
		<center>
		Информация о данной катастрофе не найдена.<br /><br />
		<a href="/{$SITE_SECTION}/">Вернуться назад</a>
		</center>
	{/if}
{/if}
</td></tr>
</table>
