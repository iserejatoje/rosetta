<table width="100%" border="0" cellspacing="2" cellpadding="0" style="background: url(/img/design/green_search_bg.gif) repeat-x;">
<tr>
	<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
<tr>
	<td align="left" class="block_title_obl" style="padding-left: 10px;"><span>Твоя афиша</span></td>
</tr>
<tr>
	<td align="left" style="padding-left: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	{foreach from=$A_BILL.list item=l}
		<tr> 
		<td  class="text11"> 
			<a href="/afisha/afisha.php?cmd=list&type={$l.id}"><b>{$l.name}</b></a>
		</td>
		</tr>
	{/foreach}
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
<tr> 
	<td class="text11">
		 <a  href="/afisha/afisha.php?cmd=list&range=today"><b>на сегодня</b></a></td>
</tr>
<tr> 
	<td class="text11">
		 <a href="/afisha/afisha.php?cmd=list&range=tomorrow"><b>на завтра</b></a></td>
</tr>
<tr> 
	<td class="text11">
		<a  href="/afisha/afisha.php?cmd=list&range=weekend"><b>на уик-энд</b></a></td>
</tr>
<tr> 
	<td class="text11">
		<a href="/afisha/afisha.php?cmd=list&range=week"><b>на неделю</b></a></td>
</tr>
	</table>
	</td>
</tr>
<tr>
	<td class="otzyv">
		<a style="color:red" href="mailto:{$CURRENT_ENV.site.domain}%20<kapitova@info74.ru>?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}">Прислать информацию о событии</a>
	</td>
</tr>
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
</table>