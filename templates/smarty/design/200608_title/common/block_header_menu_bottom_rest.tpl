<TABLE style="MARGIN-right: 8px" cellspacing=0 cellpadding=0 border=0>
                <TR vAlign=center align=middle>
		<td width="5" bcolor="#e0f3f3"></td>
		{if in_array($CURRENT_ENV.regid,array(93,45,86,29,193,56,76,24,64))}
                  <TD {if $CURRENT_ENV.section == 'afisha'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/afisha/">Афиша</A></SPAN></TD>
		{/if}
                  <TD {if $CURRENT_ENV.section == 'weekfilm'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/weekfilm/">Фильм недели</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'starspeak'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/starspeak/">Звезды говорят</A></SPAN></TD>

{if in_array($CURRENT_ENV.regid, array(24,29,76,93,163))}
                  <TD {if $CURRENT_ENV.section == 'travel'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/travel/">Путешествия</A></SPAN></TD>
{/if}
{if in_array($CURRENT_ENV.regid, array(29))}
                  <TD {if $CURRENT_ENV.section == 'inspect'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/inspect/">Проверено на себе</A></SPAN></TD>
{/if}
{if in_array($CURRENT_ENV.regid, array(163))}
                  <TD {if $CURRENT_ENV.section == 'wedding'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/wedding/">Свадебный переполох</A></SPAN></TD>
{*{elseif in_array($CURRENT_ENV.regid, array(93))}
                  <TD {if $CURRENT_ENV.section == 'tours'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/tours/">Туры</A></SPAN></TD>*}
{/if}

                  <TD {if $CURRENT_ENV.section == 'love'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/love/">Знакомства</A></SPAN></TD>
                  {*<TD {if $CURRENT_ENV.section == 'gallery'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/gallery/">Фотогалерея</A></SPAN></TD>*}
                  <TD {if $CURRENT_ENV.section == 'horoscope'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/horoscope/">Гороскопы</A></SPAN></TD>
                  <TD {if $CURRENT_ENV.section == 'dream'}bgcolor="#ffffff" class="menu_top2_selected"{else}class="menu_top2"{/if} onmouseover=menu_top2_over(this); onmouseout=menu_top2_out(this);><SPAN><A href="/dream/">Сонник</A></SPAN></TD>
                </TR>
</TABLE>