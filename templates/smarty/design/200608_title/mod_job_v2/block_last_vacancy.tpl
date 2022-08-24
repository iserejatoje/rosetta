<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_right">
<tr>
	<th><span>Последние вакансии</span></th>
</tr> 
</table>
<table cellpadding="4" cellspacing="0" width="100%">
{excycle values=" ,bg_color4"}
{foreach from=$res.list item=l}	
<tr class="{excycle}" valign="top">
	<td><span class="text11">{$l.date}</span></td>
	<td><a href="/{$ENV.section}/vacancy/{$l.vid}.html" class="s1">
				
			{if $l.dolgnost != ""}
				{$l.dolgnost}
			{else}
				{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}
				{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid" only="true"}	
			{/if}
	</a><span class="text11"> - <b>{$l.paysum}</b> руб.</span></td>
</tr>
{/foreach}
	<tr>
		<td colspan=2>
			<div class="otzyv">Добавить: <a href="/{$ENV.section}/my/vacancy/add.php" target="_blank">вакансию</a>, <a href="http://{$ENV.site.domain}/{$ENV.section}/my/resume/add.php" target="_blank">резюме</a></div>
		</td>
	<tr>
</table>