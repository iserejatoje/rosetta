{capture name=pageslink}
{if $BLOCK.res.pageslink.btn}
  <table align="left" cellspacing="0" class="table2">
  <tr valign="middle">
    <td><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $BLOCK.res.pageslink.back!="" }<td style="font-size:11px"><a href="{$BLOCK.res.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td>
		{foreach from=$BLOCK.res.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a class="s5b" href="{$l.link}">[{$l.text}]</a>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $BLOCK.res.pageslink.next!="" }<td style="font-size:11px"><a href="{$BLOCK.res.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

<table width="100%" cellspacing="0" border="0" class="table2">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr>
 	<td colspan="5" class="bg_color2"><b>{$BLOCK.title}</td>
</tr>
{if $smarty.capture.pageslink}<tr><td>
	{$smarty.capture.pageslink}</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
{/if}
<tr><td align="left">
<form name="frm" method="post">
{if !$BLOCK.favorites}
<INPUT type="hidden" name="action" value="update">
{else}
<INPUT type="hidden" name="action" value="update_favorites">
{/if}
	<table width="100%" align="center" cellspacing="1" class="table2">
	<tr>
		<th width=60>Дата</th>
		{*<th width=80>Рубрика</th>*}
		<th>Адрес</th>
		<th width="180">Тип</th>
		<th width="40">Цена<br />(тыс.руб.)</th>
		<th width="120">Район</th>
		<th width="40">Этаж</th>
		<th width="40">Телефон</th>
		<th width="60">Мебель</th>
		{if $BLOCK.res.user_id == $USER->ID}
		<th width="70" class="menu">Продлить<br/><input type=checkbox value="{$row.id}" title="Продлить все объявления на неделю" onchange="mod_realty.selAll('prolong',this)"></th>
		<th width="70" class="menu">Удалить<br/><input type=checkbox value="{$row.id}" title="Удалить все объявления" onchange="mod_realty.selAll('del',this)"></th>
		{/if}
	</tr>
	{foreach from=$BLOCK.res.list item=row key=key}
	<tr class="{if $key % 2}bg_color4{/if}">
		<td class="text11" align="center">
			<span class="s3">{$row.date_start|simply_date:"%f":"%d-%m"}</span><br />{$row.date_start|date_format:"%H:%M"}{* "H:i"|date:$row.date_start *}
		</td>
		{*<td align="center">{if $row.rub}{$row.rub}{else}-{/if}</td>*}
		<td align="left">
		{if $BLOCK.res.user_id == $USER->ID}
		<a href="/{$BLOCK.section}/edit.html?id={$row.id}">
		{else}
		<a href="/{$ENV.section}/details.html?id={$row.id}">
		{/if}
		{if $row.address}{$row.address}{else}-{/if}</a>
		</td>
		<td align="center"><b>{if $row.object}{$row.object}{else}-{/if}</b></td>
		{if $row.price > 0}
		<td align="center">
		{if intval($row.price) < floatval($row.price)}
			{$row.price|number_format:2:'.':' '} 
		{else}
			{$row.price|number_format:0:'':' '} 
		{/if}
		{if $row.price_unit!=1}
			<br /><font class="small">({$ENV._arrays.price_unit[$row.price_unit].s})</font>
		{/if}
		</td>
		{else}
			<td align="center">-</td>
		{/if}
		<td align="center">{if $row.region}{$row.region}{else}-{/if}</td>
		<td{if $row.imp>0} style="color:#CC0000"{/if} align="center">{if $row.floor}{$row.floor}{else}-{/if}/{if $row.floors}{$row.floors}{else}-{/if}</td>
		<td{if $row.imp>0} style="color:#CC0000"{/if} align="center">{$ENV._arrays.phone[$row.phone]}</td>
		<td{if $row.imp>0} style="color:#CC0000"{/if} align="center">{$ENV._arrays.furnit[$row.furnit].s}</td>
		{if $BLOCK.res.user_id == $USER->ID}					
		<td class="ssyl" align=center><input type=checkbox name="prolong[]" value="{$row.id}" title="Продлить объявление на неделю"></td>
		<td class="ssyl" align=center><input type=checkbox name="del[]" value="{$row.id}" title="Удалить объявление"></td>
		{/if}
	</tr>
	{/foreach}
</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td></tr>
{if $BLOCK.res.user_id == $USER->ID}
<tr><td align="right">
<input class="button" onclick="document.forms.frm.submit();" type="button" value="Применить" style="width:100px;">
<input class="button" type="reset" value="Сброс" style="width:70px;">
</td></tr>
{/if}
{if $smarty.capture.pageslink}<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td>
	{$smarty.capture.pageslink}</td></tr>
{/if}

<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
</table>
</form>
<br /><br />