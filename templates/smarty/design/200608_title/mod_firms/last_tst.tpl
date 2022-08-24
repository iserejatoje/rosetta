{if isset($smarty.get.tst)}{debug}{/if}
<table class="t12" cellpadding="0" cellspacing="0" border="0">
					<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">{$GLOBAL.title[$BLOCK.section]}</td></tr>
					<tr><td align="left" height=1 bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td></tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				{foreach from=$BLOCK.res.data item=firm}
            <tr>
              <td width="100%" valign="top">
              <TABLE width="100%">
                    <TR>
                      <TD><IMG height=4 alt="" 
      src="/_img/design/200608_title/b3.gif" 
      width=4 align=middle border=0> <A 
                        href="/{$BLOCK.section}/{if is_array($BLOCK.res.path)}{$BLOCK.res.path[$firm.parent]}{else}{$BLOCK.res.path}{/if}/{$firm.name}/" 
                        target=_blank class="a11">{$firm.shorttitle} (<b>{$firm.count}</b>)</A></TD>
                    </TR>
                   <TR>
                      <TD class=otzyv>
                      <EM>{$firm.shortname}</EM>: {$firm.otziv|strip_tags|substr:0:55} <A 
                  href="/{$BLOCK.section}/{if is_array($BLOCK.res.path)}{$BLOCK.res.path[$firm.parent]}{else}{$BLOCK.res.path}{/if}/{$firm.name}/{$firm.fid}.html#{$firm.cid}" 
                  target=_blank>далее</A></TD>
                    </TR>
              </TABLE></td>
            </tr>
            {/foreach}
          </table>