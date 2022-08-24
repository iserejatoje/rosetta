<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="block_title"><span>Вакансии&nbsp;по&nbsp;рубрикам</span></td>
</tr> 
</table>
{*
старый вид блока
<table width="100%" cellpadding="0" cellspacing="3" border="0">
<tr>
	<td>
		<table cellpadding="0" cellspacing="5" border="0" width="100%">
        {foreach from=$res.razdel item=l}
			<tr>
				<td class="t7"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" hspace="2" />&#160;<a class="s1" href="/{$ENV.section}/vacancy/{$l.rid}/1.php" >{if in_array($l.rid,array(22,23,36,37))}<font color="red">{/if}{$l.rname} [{$l.vcount|number_format:"0":",":" "}]{if in_array($l.rid,array(22,23,36,37))}</font>{/if}</a>
				</td>
            </tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>

*}

<table cellpadding="0" cellspacing="3" border="0" width="100%" class="table">
		{excycle values=" ,bg_color4"}
        {foreach from=$res.razdel item=l}
		<tr valign="bottom" class="{excycle}">
			<td><a href="/{$ENV.section}/vacancy/{$l.rid}/1.php" >{if in_array($l.rid,array(22,23,36,37))}<font color="red">{/if}{$l.rname}{if in_array($l.rid,array(22,23,36,37))}</font>{/if}</a> <span class="text11">({$l.vcount|number_format:"0":",":" "})</span></td>
		</tr>
	{/foreach}
	<tr>
		<td>
			<div class="otzyv">Добавить: <a href="/{$ENV.section}/my/vacancy/add.php" target="_blank">вакансию</a>, <a href="http://{$ENV.site.domain}/{$ENV.section}/my/resume/add.php" target="_blank">резюме</a></div>
		</td>
	<tr>
</table>

