<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td class="block_title_obl" align="left" style="padding-left: 25px;"><span>Индексы</span></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt5">
            <tr bgcolor="#E0F3F3">
              <td class="t9" align="left"><strong>Индексы</strong></td>
              <td class="t9" align="left">&nbsp;</td>
              <td class="t9" align="center"><strong>Дата</strong></td>
              <td class="t9" align="right"><strong>Знач.</strong></td>
              <td class="t9" align="right"><strong>Изм.</strong></td>

            </tr>
{foreach from=$res.list item=l}
            <tr>
              	<td align="left" class="t9"><strong>
			{if $l.trend>0}<img src="/img/kriz/str-verh.gif" width="8" height="6">
			{elseif $l.trend<0}<img src="/img/kriz/str-niz.gif" width="8" height="6">
			{else}<img src="/_img/x.gif" width="8" height="6">
			{/if} {$l.name} </strong></td>
		<td align="left" class="t9">{$l.unit_name}</td>
              	<td align="center" class="t9">{$l.last_date|date_format:"%d/%m"}</td>
              	<td align="right" class="t9" nowrap>{$l.last_value|number_format:"2":".":" "}</td>
              	<td align="right" class="t9" title="{$l.alt}" nowrap><font color="{if $l.trend>=0}#006600{else}#cc0000{/if}" title="{$l.alt}">{if $l.trend>0}+{/if}{$l.trend|number_format:"2":".":" "}</font></td>

            </tr>
{/foreach}
</table>