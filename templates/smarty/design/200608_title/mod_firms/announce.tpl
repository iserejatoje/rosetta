
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
		<td>
		<table border=0 cellpadding="0" cellspacing="3" width=100%>
			<tr><td align="left" class="block_title_obl" style="padding-left: 5px;"><span>{if !empty($BLOCK.res.params.title)}{$BLOCK.res.params.title}{else}{$GLOBAL.title[$BLOCK.section]}{/if}</span></td></tr> 
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="8"></td>
	</tr>
	<tr> 
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
{foreach from=$BLOCK.res.tree item=l}
{if $l.data.cnt}
				{if $l.level<1}
				<tr> 
					<td {if $l.level}class="gl"{/if} style="padding-left:{$l.level*8+8}px;"><a href="/{$BLOCK.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if $BLOCK.res.path != ''}{$BLOCK.res.path}/{/if}{$l.path}/"><strong>{$l.data.shorttitle}</strong></a> ({$l.data.cnt})</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="4"></td>
				</tr>
				{/if}
				{foreach from=$BLOCK.res.list[$l.id] item=l2 key=k2}
				<tr>
					<td style="padding-left:{$l.level*8+8}px;">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="12"><img src="/_img/design/200608_title/bullspis.gif" width="12" height="11"></td>
								<td class="gl"><a href="/{$BLOCK.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if $BLOCK.res.path != ''}{$BLOCK.res.path}/{/if}{$l.path}/{$l2.id}.html">{$l2.name}</a></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="8"></td>
				</tr>
				{/foreach}
{/if}
{/foreach}
			</table> 
		</td>
	</tr>
	<tr>
		<td class="otzyv" align="right" style="padding-right: 5px;">
			<a href="/firms/addorg.html"><font color="red">Добавить компанию</font></a>
		</td>
	</tr>
</table>
{if $CURRENT_ENV.site.domain=="63.ru"}
	<center><a href="http://tolyatty.ru/firms/" target="_blank" style="color:red">Компании Тольятти</a></center>
{/if}