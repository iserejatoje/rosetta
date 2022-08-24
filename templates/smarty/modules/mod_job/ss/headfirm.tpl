{include file="`$TEMPLATE.sectiontitle`" rtitle="Вакансии компаний"}
<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="100%">
	<tr>
{foreach from=$fhead item=l key=_k name=fhead}
		<td width="33%">
			<table cellpadding="2" cellspacing="0" border="0" bgcolor="#ffffff" width="100%" align="center">
				<tr>
					<td width="150" align="left" valign="top">
						<table>
							<tr>
								<td width="150" height="80" align="center" valign="middle" STYLE="background: url({$l.file_name}); background-repeat: no-repeat; background-position: center;"><a href="{if $l.link}http://{$l.link}{else}/{$CURRENT_ENV.section}/?cmd=firmvac&id={$l.fid}{/if}"><img src="/_img/x.gif" width="150" height="80" alt="{$l.fname|escape} ({$l.cnt})" style="border: #005A52 solid 1px;"/></a></td>
							</tr>
						</table>
					</td>
					<td align="left" valign="middle" ><strong><a href="{if $l.link}http://{$l.link}{else}/{$CURRENT_ENV.section}/?cmd=firmvac&id={$l.fid}{/if}">{$l.fname} ({$l.cnt})</a></strong>
					{if $l.cnt>0}
						<br/><br/>
						<a href="/$CURRENT_ENV.section/?cmd=firmvac&id={$l.fid}" class="s3">{$l.dol}</a><br/><br/>
					{/if}                                                 
					</td>
				</tr>
			</table>
		</td>
{if ($_k+1) % 3 == 0 && !$smarty.foreach.fhead.last}
	</tr><tr>
{/if}
{/foreach}
	</tr>
</table>