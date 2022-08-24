{if !$BLOCK.no_title}
<table class="t12" cellpadding="0" cellspacing="0" border="0">
{capture name="module_url"}{if $BLOCK.module_url}{$BLOCK.module_url}{else}/{$BLOCK.section}/{/if}{if !empty($BLOCK.url)}{$BLOCK.url}{else}{$BLOCK.res.path}{/if}{/capture}
	<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"`$smarty.capture.module_url`/"|escape:"url"}" target="_blank">{if $BLOCK.module_title}{$BLOCK.module_title}{else}Каталог фирм{/if}</a></td></tr>
</table>
{*
<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">Каталог фирм</td></tr>
	<tr><td align="left" height=1 bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td></tr>
</table>
*}
{/if}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
				{foreach from=$BLOCK.res.data item=firm}
            <tr>
              <td width="100%" valign="top">
              <TABLE width="100%">
                    <TR>
                      <TD><IMG height=4 alt="" 
      src="/_img/design/200608_title/b3.gif" 
      width=4 align=middle border=0> <A 
                        href="/service/go/?url={"`$smarty.capture.module_url`/`$firm.path`/"|escape:"url"}" 
                        target=_blank class="a11">{if $firm.shorttitle}{$firm.shorttitle}{else}{$firm.title}{/if} (<b>{$firm.count}</b>)</A></TD>
                    </TR>
                   <TR>
                      <TD class=otzyv>
                      <EM>{if !empty($firm.shortname)}{$firm.shortname}{else}{$firm.bigname|truncate:40:"...":false}{/if}</EM>: {$firm.otziv|strip_tags|substr:0:55} <A 
                  href="/service/go/?url={"`$smarty.capture.module_url`/`$firm.path`/`$firm.fid`.html#`$firm.cid`"|escape:"url"}" 
                  target=_blank>далее</A></TD>
                    </TR>
              </TABLE></td>
            </tr>
            {/foreach}
          </table>