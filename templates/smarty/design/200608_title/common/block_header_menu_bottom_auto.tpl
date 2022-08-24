<TABLE style="MARGIN-right: 8px" cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
                <TR vAlign=center align=middle>
		<td width="5" bcolor="#e0f3f3"></td>
                  <TD {if $CURRENT_ENV.section == 'newsline_auto'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/newsline_auto/">Лента новостей</A></SPAN></TD>
{if in_array($CURRENT_ENV.regid, array(163))}
                  <TD {if $CURRENT_ENV.section == 'news_auto'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/news_auto/">Новости</A></SPAN></TD>

		<td valign="bottom" align="left">
			<div id="block1_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('1');" onmouseover="this.style.visibility='visible';menu_top2_over_p('1');">
				<div><a href="/autostop/">Автостоп</a></div>
				<div><a href="/advice/">Сводка ГИБДД</a></div>
				<div><a href="/photoreport/">Фотосессия</a></div>
				<div><a href="/pdd/">Штрафы ГИБДД</a></div>
			</div>
		</td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');"><SPAN><a href="/autostop/">Статьи</A></SPAN></td>
{elseif in_array($CURRENT_ENV.regid, array(24,29,76,93))}
		<td valign="bottom" align="left">
			<div id="block1_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('1');" onmouseover="this.style.visibility='visible';menu_top2_over_p('1');">
				<div><a href="/autostop/">Автостоп</a></div>
			{if in_array($CURRENT_ENV.regid, array(93))}	
				<div><a href="/advice/">Сводка ГИБДД</a></div>
			{/if}
			{if in_array($CURRENT_ENV.regid, array(24,29,93))}
				<div><a href="/instructor/">Инструктор</a></div>
			{/if}
				<div><a href="/photoreport/">Фотосессия</a></div>
				<div><a href="/pdd/">Штрафы ГИБДД</a></div>
			</div>
		</td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');"><SPAN><a href="/autostop/">Статьи</A></SPAN></td>
{else}
                  <TD {if $CURRENT_ENV.section == 'autostop'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/autostop/">Автостоп</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'pdd'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/pdd/">Штрафы ГИБДД</A></SPAN></TD>
{/if}

                  <TD {if $CURRENT_ENV.section == 'accident'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/accident/">Автокатастрофы</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'car'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/car/">Объявления</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'opinion'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/opinion/">Отзывы</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'poputchik'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/poputchik/">Попутчик</A></SPAN></TD>
                </TR>
              </TBODY>
</TABLE>