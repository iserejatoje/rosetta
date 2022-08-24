{include file="`$TEMPLATE.sectiontitle`" rtitle="Вакансии компаний"}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
{foreach from=$page.list item=l key=_k name=fhead}
		<td width="33%">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" align="center" class="table2">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
							<td style="border: 1px solid rgb(187, 198, 193);" align="center">{if $l.link}<noindex>{/if}<a href="{if $l.link}http://{$l.link}{else}/{$ENV.section}/vacancy/firm/{$l.fid}.php{/if}"><img src="{$l.image.file}" width="{$l.image.w}" height="{$l.image.h}" alt="{$l.fname|escape} ({$l.cnt})" border="0"></a>{if $l.link}</noindex>{/if}</td>
							<td><img src="/_img/x.gif" width="1" height="80"/></td>
							</tr>
							<tr><td><img src="/_img/x.gif" width="150" height="1"/></td></tr>
						</table>
					</td>
					<td align="left" valign="middle" width="100%">{if $l.link}<noindex>{/if}<a href="{if $l.link}http://{$l.link}{else}/{$ENV.section}/vacancy/firm/{$l.fid}.php{/if}"><b>{$l.fname} ({$l.cnt})</b></a>{if $l.link}</noindex>{/if}
					{if $l.cnt>0}
						<br/><br/>
						<a href="/{$ENV.section}/vacancy/firm/{$l.fid}.php">{$l.dol}</a><br/><br/>
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
</table><br/><br/><br/>