<TABLE style="MARGIN-right: 8px" cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
                <TR vAlign=center align=middle>
		<td width="5" bcolor="#e0f3f3"></td>
                  <TD {if $CURRENT_ENV.section == 'exchange'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/exchange/">Курсы валют</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'newsline_fin'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/newsline_fin/">Лента новостей</A></SPAN></TD>
{if in_array($CURRENT_ENV.regid, array(163))}
		<td valign="bottom" align="left">
			<div id="block1_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('1');" onmouseover="this.style.visibility='visible';menu_top2_over_p('1');">
				<div><a href="/news_fin/">Тема недели</a></div>
				<div><a href="/tech/">Финансовые технологии</a></div>
				<div><a href="/predict/">Сценарии и прогнозы</a></div>
				<div><a href="/skills/">Финграмота</a></div>
			</div>
		</td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');"><SPAN><a href="/tech/">Статьи</a></td>
{else}
                  <TD {if $CURRENT_ENV.section == 'tech'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/tech/">Финансовые технологии</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'skills'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/skills/">Финграмота</A></SPAN></TD>
{/if}

                  <TD {if $CURRENT_ENV.section == 'credit'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/credit/">Калькуляторы</A></SPAN></TD>

{if in_array($CURRENT_ENV.regid, array(29))}
                  <TD {if $CURRENT_ENV.section == 'newscomp_fin'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/newscomp_fin/">Новости партнеров</A></SPAN></TD>
{/if}

                </TR>
              </TBODY>
</TABLE>