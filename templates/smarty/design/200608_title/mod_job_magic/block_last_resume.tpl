<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_right">
<tr>
	<th><span>Последние резюме</span></th>
</tr> 
</table>
<table cellpadding="4" cellspacing="0" width="100%">
{excycle values=" ,bg_color4"}
{foreach from=$res item=l}
<tr class="{excycle}" valign="top">
	<td><span class="text11">{$l.date}</span></td>
	<td><a href="/{$ENV.section}/resume/{$l.resid}.html" class="s1">{$l.dolgnost}</a><span class="text11"> - <b>{$l.paysum}</b> руб.</span></td>
</tr>
{/foreach}
</table>