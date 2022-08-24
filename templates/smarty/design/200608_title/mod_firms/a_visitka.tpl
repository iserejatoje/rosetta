<table width="100%" border="0" cellspacing="0" cellpadding="0">
{if !$BLOCK.no_title}
	<tr>
		<td>
		<table border=0 cellpadding="0" cellspacing="3" width=100%>
			<tr><td align="left" class="block_title_obl" style="padding-left: 15px;"><span>СПРАВКА</span></td></tr>
		</table>
		</td>
	</tr>
{/if}
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
{if !$BLOCK.no_title}

				<tr>
					<td><img src="/_img/x.gif" width="1" height="8"></td>
				</tr>
{/if}
{foreach from=$BLOCK.res item=l}
{if $l.data.cnt}
{*if sizeof($BLOCK.res.list[$l.id])*}
				<tr>
					<td {if $l.level}class="gl"{/if} style="padding-left:{$l.level*8+8}px;"><a href="{if !empty($BLOCK.url)}{$BLOCK.url}{else}/{$BLOCK.section}{/if}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if $BLOCK.res.path != ''}{$BLOCK.res.path}/{/if}{$l.path}/" {if $CURRENT_ENV.site.domain != $ENV.site.domain }target="_blank" {/if}><strong>{if empty($l.data.shorttitle)}{$l.data.name}{else}{$l.data.shorttitle}{/if}</strong></a> ({$l.data.cnt})</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="4"></td>
				</tr>
{*				{foreach from=$BLOCK.res.list[$l.id] item=l2 key=k2}
				<tr>
					<td style="padding-left:{$l.level*8+8}px;">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="12"><img src="/_img/design/200608_title/bullspis.gif" width="12" height="11"></td>
								<td class="gl"><a href="{if !empty($BLOCK.url)}{$BLOCK.url}{else}/{$BLOCK.section}{/if}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if $BLOCK.res.path != ''}{$BLOCK.res.path}/{/if}{$l.path}/{$l2.id}.html">{$l2.name}</a></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="8"></td>
				</tr>
				{/foreach} *}
{*/if*}
{/if}
{/foreach}
			</table>
		</td>
	</tr>
</table>
