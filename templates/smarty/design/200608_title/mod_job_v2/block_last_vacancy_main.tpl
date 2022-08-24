<table width="100%" cellspacing="2" cellpadding="0" border="0">
<tr>
	<td>
		<table cellspacing="0" cellpadding="0" border="0" class="t12">
			<tr><td align="left" style="padding: 1px 10px;" class="block_caption_main"><a href="/job/vacancy/1.php" target="_blank">Вакансии</a></td></tr>
{*
			<tr><td align="left" style="padding: 1px 10px;" class="t13_grey2">Вакансии</td></tr>
			<tr><td height="1" bgcolor="#666666" align="left"><img width="1" height="1" border="0" src="/_img/x.gif" /></td></tr>
*}
		</table>
	</td>
	</tr>
	<tr>
		<td valign="top">
		<table width="100%" cellspacing="6" cellpadding="0" border="0">
		{foreach from=$res.list item=l}
		<tr valign="top">
			<td width="1" class="t11">{$l.date}  </td>
			<td><a class="t11" href="/{$ENV.section}/vacancy/{$l.vid}.html" {if $l.imp}style="color:red"{/if}>{if $l.dolgnost != ""}
				{$l.dolgnost}
			{else}
				{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}
				{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid" only="true"}	
			{/if}</a> - <font class="t11"><b>{$l.paysum}</b> руб.</font></td>
		</tr>
		{/foreach}
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<div class="otzyv">Добавить: <a href="/{$ENV.section}/my/vacancy/add.php" target="_blank"><font color="#ff0000">вакансию</font></a>, <a href="http://{$ENV.site.domain}/{$ENV.section}/my/resume/add.php" target="_blank"><font color="#ff0000">резюме</font></a></div>
		</td>
	<tr>
</table>
