{if $res.is_exists}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="left">
	<td class="block_title" style="text-align: left;padding-left: 6px"><span>Моя почта</span></td>
</tr>
</table>
<div class="txt_color4" style="margin-left: 4px;">
<b>{$USER->OurEmail}</b>
</div>
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{*	<tr>
		<td class="tip">
			Новых писем: <b>{$res.count_unseen}</b>
		</td>
	</tr>
*}
	<tr>
		<td class="tip" align="center">
			<a href="{$res.url_check}">Проверить почту</a>
			&nbsp;&nbsp;&nbsp;
			<a href="{$res.url_new}">Написать письмо</a>
		</td>
	</tr>
</table>
{/if}
