<center><br>
{if $res.question.name}
<table cellspacing=0 cellpadding=5 border=0 width=100%>
    <tr><td colspan=3 style="font-size:16px;"><b>{$res.question.name}</b></td></tr>
{foreach from=$res.answers item=l}
	<tr><td>{$l.name}</td>
	<td align=right nowrap="nowrap">{$l.width|number_format:"1":",":" "} %</td><td width="200"><div style="width:{$l.width|floor}%;background-color:#CCCCCC;border:1px solid #999999"></div></td></tr>
{/foreach}
<tr><td><b>Всего</b></td>
<td align=right><b>{$res.question.cnt}</b></td><td>&nbsp;</td></tr></table>
{else}
<br/>
<span class="txt_color1"><b>Запрошеный вами опрос не найден.</b></span>
<br/>
{/if}
<p><a href='javascript:window.close()'>Закрыть</a></p>
</center>