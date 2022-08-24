{*изменено по требованию Россвязьнадзор*}
{include file="`$TEMPLATE.sectiontitle`" rtitle="Редактирование резюме"}
<br/>
<form name="rmresume" method="post" >
<input type="hidden" name="cmd" value="rmres">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
    <tr>
		<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" >
				<tr bgcolor="#DEE7E7">
					<td class="t1" align="center" colspan="{if sizeof($data) > 1}9{else}8{/if}">Выберите резюме для редактирования</td>
				</tr>
				<tr bgcolor="#e9efef">
					<td class="t1" align="center">ID </td>
					<td class="t1" align="center">Дата<br>разм.</td>
					<td class="t1" align="center">Дата<br>истеч.</td>
					<td class="t1" align="center">Имя{*Ф.И.О.*}</td>
					<td class="t1" align="center">Раздел </td>
					<td class="t1" align="center">Должность</td>
					{*if sizeof($data) > 1 }<td class="t1" align="center">Порядок</td>{/if*}
					<td class="t1" align="center">Продлить&#160;на<br>неделю</td>
					<td class="t1" align="center">Удалить</td>
				</tr>
				{excycle values="#F3F8F8,#FFFFFF"}
				{foreach from=$data item=l name=lst}
				<tr bgcolor="{excycle}">
					<td class="t7" valign="top" align="center"><a href="/{$CURRENT_ENV.section}/?cmd=editres&id={$l.resid}" class="s1">{$l.resid}</a></td>
					<td class="t7" valign="top">{$l.pdate}</td>
					<td class="t7" valign="top">{$l.vdate}</td>
					<td class="t7" valign="top">{$l.fio}</td>
					<td class="t7" valign="top">{$l.name}</td>
					<td class="t7" valign="top"><a href="/{$CURRENT_ENV.section}/?cmd=editres&id={$l.resid}" class="s1">{$l.dol}</a></td>
					{*if sizeof($data) > 1 }
					<td class="t7" nowrap="nowrap">
						{if !$smarty.foreach.lst.first}<a href="/{$CURRENT_ENV.section}/?cmd=move_up&id={$l.resid}&type=2" class="s1" title="Переместить вверх" alt="Переместить вверх"><img {if $smarty.foreach.lst.last}hspace="8"{/if} src="/img/20061008_2pages/bullet_arrow_up.gif" border="0"></a>{/if}
						{if !$smarty.foreach.lst.last}<a href="/{$CURRENT_ENV.section}/?cmd=move_down&id={$l.resid}&type=2" class="s1" title="Переместить вниз" alt="Переместить вниз"><img {if $smarty.foreach.lst.first}hspace="8"{/if} src="/img/20061008_2pages/bullet_arrow_down.gif" border="0"></a>{/if}
							<input name="ord[{$l.vid}]" type="text" value="{$l.order}" size="2"/>
					</td>
					{/if*}
					<td class="t7" valign="top" align="center"><input type="checkbox" name="arr_plg_res[]" value="{$l.resid}" class="t7"></td>
					<td class="t7" valign="top" align="center"><input type="checkbox" name="arr_del_res[]" value="{$l.resid}" class="t7"></td>
				</tr>
				{/foreach}
			</table>
		</td>
	</tr>
</table>
<br/>
<center>
	<input type="submit" value="Применить" class="in">&nbsp;&nbsp;&nbsp;
	<input type="reset" value="Сброс" class="in">
</center>
</form>
