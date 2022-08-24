{literal}
<style type="text/css">
.vacancy_main {color: red}
</style>
{/literal}
<table class="t12" cellpadding="3" cellspacing="0" border="0">
<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/job/vacancy/1.php" target="_blank">Вакансии</a></td></tr>
</table>
<table cellpadding="3" cellspacing="0" border="0" width="100%">
<tr valign="top">
	{assign var="td_cnt_const" value=3}
	{assign var="td_cnt" value=0}
        {foreach from=$res.razdel item=l name="vacs"}
		{math equation="x % y" x=$smarty.foreach.vacs.iteration y=$td_cnt_const assign=half}
		<td><a class="t11" href="/{$ENV.section}/vacancy/{$l.rid}/1.php" >{if $l.rid==22 || $l.rid==23 || $l.rid==36}<font color="red">{/if}{$l.rname}{if $l.rid==22 || $l.rid==23 || $l.rid==36}</font>{/if}</a> <span class="t11">(<b>{$l.vcount|number_format:"0":",":" "}</b>)</span></td>
			{math equation="x + y" x=$td_cnt y=1 assign=td_cnt}
		{if $half == 0}
			{assign var="td_cnt" value=0}
		</tr><tr valign="top">
		{/if}
	{/foreach}
</tr>
</table>