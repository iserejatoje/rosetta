<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" bgcolor="#D5D5D5">
					<table width="100%"  border="0" cellspacing="1" cellpadding="2">
				        	<tr>
							{if $CURRENT_ENV.regid==74}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="887"}<br/>{banner_v2 id="2368"}<br />{banner_v2 id="2752"}<br />{banner_v2 id="1450"}</td>
							{elseif $CURRENT_ENV.regid==2}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1653"}<br/>{banner_v2 id="2612"}<br/>{banner_v2 id="959"}</td>
							{elseif $CURRENT_ENV.regid==16}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1083"}<br/>{banner_v2 id="3155"}</td>
							{elseif $CURRENT_ENV.regid==34}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="2430"}<br/>{banner_v2 id="2370"}</td>
							{elseif $CURRENT_ENV.regid==59}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1462"}<br/>{banner_v2 id="1822"}</td>
							{elseif $CURRENT_ENV.regid==61}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1377"}<br/>{banner_v2 id="1486"}</td>
							{elseif $CURRENT_ENV.regid==63}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1691"}</td>
							{elseif $CURRENT_ENV.regid==72}
						        <td width="180" valign="top" bgcolor="#FFFFFF">{banner_v2 id="1170"}<br/>{banner_v2 id="2202"}</td>
							{/if}
					        	<td valign="top" bgcolor="#FFFFFF">


					        	{foreach from=$res item=l}
								{assign var="ki" value="0"}
							{if $l.parent==0 && ($l.id==1 || $l.id==2)}
							<table border="0" cellspacing="0" cellpadding="0" bgcolor="#1F79C2">
							<tr>
							<td>&nbsp;&nbsp;<font class=menu>{$l.name}</font>&nbsp;&nbsp;</td>
							<td align="right" valign="bottom"><img src="/_img/design/200710_auto/bul-zag.gif" width="18" height="13"></td>
							</tr>
							</table>
							{foreach from=$res item=lp}
								{if $lp.parent==$l.id}
								{assign var="ki" value="`$ki+1`"}
								{/if}
							{/foreach}
<table width="100%"  border="0" cellspacing="0" cellpadding="3">
<tr>
{math equation="ceil(x/5)" x=$ki assign="krows"}
{assign var="i" value="0"}
{foreach from=$res item=lp}
{if $lp.parent==$l.id}
	{if $i==0}<td valign="top" width="20%"><table cellpadding="3" cellspacing="0" border="0" width="100%">{/if}
	<tr><td><img src="/_img/design/200608_title/bullspis.gif" width="9" height="7"> <a href="/{$ENV.section}/offer/{$lp.path}/{$lp.modname}/" class="zag3">{*<a href="/{$ENV.section}/search/?type=0&parent={$lp.id}" class="zag3">*}{$lp.name}</a></td></tr>
	{assign var="i" value="`$i+1`"}
	{if $i==$krows}</table></td>{assign var="i" value="0"}{/if}
{/if}
{/foreach}
{if $i<$krows && $i}</table></td>{/if}
</tr>
</table>
							<br/><img src="/_img/x.gif" width="1" height="3"><br/>
							{/if}
							{/foreach}
                          <div align="right" bgcolor="#FFFFFF"><b><a href="/{$ENV.section}/add.html" style="color: red;">Добавить объявление</a></b></div>
                          </td>
						</tr>
					</table>
</td>
</tr>
</table>