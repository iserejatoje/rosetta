<TABLE cellSpacing="0" cellPadding="0" border="0">
<TR vAlign="center" align="middle">
<TD>&nbsp;</TD>

{assign var="competition_link" value=''}

{if $CURRENT_ENV.section == 'competition'}
	{if in_array($CURRENT_ENV.params, array('13.php','15.php','17.php','19.php','21.php','23.php','25.php'))} {* было {if $CURRENT_ENV.params == '1.php'} *}
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/autostory/"><span>Все автобайки</span></a></td>
	{elseif in_array($CURRENT_ENV.params, array('14.php', '16.php', '18.php', '20.php', '22.php', '24.php', '26.php'))} {* было {elseif $CURRENT_ENV.params == '2.php'} *}
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/narodstory/"><span>Все пожелания</span></a></td>
	{/if}
{elseif $CURRENT_ENV.section == 'autostory'}
	{if $CURRENT_ENV.regid == 26}
		{assign var="competition_link" value='21.php'}
	{elseif $CURRENT_ENV.regid == 29}
		{assign var="competition_link" value='15.php'}
	{elseif $CURRENT_ENV.regid == 45}
		{assign var="competition_link" value='19.php'}
	{elseif $CURRENT_ENV.regid == 56}
		{assign var="competition_link" value='13.php'}
	{elseif $CURRENT_ENV.regid == 76}
		{assign var="competition_link" value='17.php'}
	{elseif $CURRENT_ENV.regid == 102}
		{assign var="competition_link" value='25.php'}
	{elseif $CURRENT_ENV.regid == 174}
		{assign var="competition_link" value='23.php'}
	{/if}

	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/competition/{$competition_link}"><span>Разместить автобайку</span></a></td>
{elseif $CURRENT_ENV.section == 'narodstory'}
	{if $CURRENT_ENV.regid == 26}
		{assign var="competition_link" value='22.php'}
	{elseif $CURRENT_ENV.regid == 29}
		{assign var="competition_link" value='16.php'}
	{elseif $CURRENT_ENV.regid == 45}
		{assign var="competition_link" value='20.php'}
	{elseif $CURRENT_ENV.regid == 56}
		{assign var="competition_link" value='14.php'}
	{elseif $CURRENT_ENV.regid == 76}
		{assign var="competition_link" value='18.php'}
	{elseif $CURRENT_ENV.regid == 102}
		{assign var="competition_link" value='26.php'}
	{elseif $CURRENT_ENV.regid == 174}
		{assign var="competition_link" value='24.php'}
	{/if}	

	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/competition/{$competition_link}"><span>Разместить пожелание</span></a></td>
{/if}
<TD>&nbsp;&nbsp;</TD>
</TR>
</TABLE>