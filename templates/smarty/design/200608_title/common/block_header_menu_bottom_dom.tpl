<TABLE style="MARGIN-right: 8px" cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
                <TR vAlign=center align=middle>
		<td width="5" bcolor="#e0f3f3"></td>
                  <TD {if $CURRENT_ENV.section == 'newsline_dom'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/newsline_dom/">{$CURRENT_ENV.site.title.newsline_dom}</A></SPAN></TD>
{if in_array($CURRENT_ENV.regid, array(163,93))}
                  <TD {if $CURRENT_ENV.section == 'news_dom'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/news_dom/">{$CURRENT_ENV.site.title.news_dom}</A></SPAN></TD>
{/if}
                  <TD {if $CURRENT_ENV.section == 'articles'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/articles/">{$CURRENT_ENV.site.title.articles}</A></SPAN></TD>
{if in_array($CURRENT_ENV.regid, array(163))}
                  <TD {if $CURRENT_ENV.section == 'expert'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/expert/">{$CURRENT_ENV.site.title.expert}</A></SPAN></TD>
{/if}
{if in_array($CURRENT_ENV.regid, array(24,29,76,93))}
                  <TD {if $CURRENT_ENV.section == 'design'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/design/">{$CURRENT_ENV.site.title.design}</A></SPAN></TD>
{/if}
                  <TD {if $CURRENT_ENV.section == 'realty'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/realty/">Объявления</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'hints'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/hints/">{$CURRENT_ENV.site.title.hints}</A></SPAN></TD>
                </TR>
              </TBODY>
</TABLE>