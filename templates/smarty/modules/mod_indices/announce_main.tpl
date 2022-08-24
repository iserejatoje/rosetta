<table width="100%" border="0" cellspacing="2" cellpadding="2" class="txt5">
            <tr>
              <td class="txt1" align="left" bgcolor="#CCDBEE"><strong>Индексы</strong></td>
              <td class="txt4" align="left" bgcolor="#CCDBEE">&nbsp;</td>
              <td class="txt4" align="center" bgcolor="#CCDBEE"><strong>Дата</strong></td>
              <td class="txt4" align="right" bgcolor="#CCDBEE"><strong>Знач.</strong></td>
              <td class="txt4" align="right" bgcolor="#CCDBEE"><strong>Изм.</strong></td>

            </tr>
{foreach from=$res.list item=l}
            <tr>
              	<td align="left" nowrap class="otzyv"><strong>
			{if $l.trend>0}<img src="/img/kriz/str-verh.gif" width="8" height="6">
			{elseif $l.trend<0}<img src="/img/kriz/str-niz.gif" width="8" height="6">
			{else}<img src="/_img/x.gif" width="8" height="6">
			{/if} {$l.name} </strong></td>
		<td align="left" class="otzyv">{$l.unit_name}</td>
              	<td align="center" class="otzyv">{$l.last_date|date_format:"%d/%m"}</td>
              	<td align="right" class="otzyv" nowrap>{if $l.id==7 || $l.id==8}от {/if}{$l.last_value|number_format:"2":".":" "}</td>
              	<td align="right" class="otzyv" title="{$l.alt}" nowrap><font color="{if $l.trend>=0}#006600{else}#cc0000{/if}" title="{$l.alt}">{if $l.trend>0}+{/if}{$l.trend|number_format:"2":".":" "}</font></td>

            </tr>
{/foreach}
</table>