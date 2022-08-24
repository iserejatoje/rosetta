{capture name=pageslink}
{if $BLOCK.res.pageslink.btn}
  <table align="left" cellspacing="0" class="table2">
  <tr valign="middle">
    <td><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $BLOCK.res.pageslink.back!="" }<td style="font-size:11px"><a href="{$BLOCK.res.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td>
		{foreach from=$BLOCK.res.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a href="{$l.link}">[{$l.text}]</a>&nbsp;
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
	<td colspan="5" class="bg_color2"><b>{$BLOCK.title}</b></td>
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
		<th width="40">#</th>
		<th width=80 class="menu">Дата</th>
		<th class="menu">Рубрика</th>
		<th class="menu">Схема обмена</th>
		<th class="menu">Имеется</th>
		<th class="menu">Требуется</th>
		{if $BLOCK.res.user_id == $USER->ID}
		{if !$BLOCK.favorites}
		<th width=70 class="menu">Продлить<br/><input type=checkbox value="{$row.id}" title="Продлить все объявления на неделю" onclick="mod_realty.selAll('prolong',this)"></th>
		{/if}
		<th width=70 class="menu">Удалить<br/><input type=checkbox value="{$row.id}" title="Удалить все объявления" onclick="mod_realty.selAll('del',this)"></th>
		{/if}
	</tr>
	{foreach from=$BLOCK.res.list item=row key=key}
				<tr class="{if $key % 2}bg_color4{/if}">
					<td align="center">
						{if $BLOCK.res.user_id == $USER->ID}
						<a href="/{$BLOCK.section}/edit.html?id={$row.id}">
						{else}
						<a href="/{$ENV.section}/details.html?id={$row.id}">
						{/if}
						{$row.id}
						</a>
					</td>
					<td class="ssyl" align="center">
						<font class="data">{$row.date_start|date_format:"%d-%m"}</font><br />{$row.date_start|date_format:"%H:%M"}
					</td>
					<td class="ssyl" align="center">{if $row.rub}{$row.rub}{else}-{/if}</td>
					<td class="ssyl" align="center">
					{if !$BLOCK.favorites}
						{if $BLOCK.res.user_id == $USER->ID}
						<a href="/{$BLOCK.section}/edit.html?id={$row.id}">
						{else}
						<a href="/{$ENV.section}/details.html?id={$row.id}">
						{/if}
					{else}
						<a href="/{$BLOCK.section}/details.html?id={$row.id}" target="_blank">
					{/if}
					{if $row.scheme}{$row.scheme}{else}-{/if}</a>
					</td>
					<td class="ssyl" align="center">{if $row.have}{$row.have}{else}-{/if}</td>
					<td class="ssyl" align="center">{if $row.need}{$row.need}{else}-{/if}</td>
					{if $BLOCK.res.user_id == $USER->ID}
					{if !$BLOCK.favorites}
					<td class="ssyl" align=center><input type=checkbox name="prolong[]" value="{$row.id}" title="Продлить объявление на неделю"></td>
					{/if}
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