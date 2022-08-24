{include file="`$TEMPLATE.sectiontitle`" rtitle="Размещенные вакансии и резюме"}
{capture name="lvac"}

	<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="100%">
		<tr>
			<td>
				<table cellpadding="4" cellspacing="1" border="0" width="100%">
					<tr bgcolor="#DEE7E7">
						<td class="t1" align="center" colspan="6">Список размещенных вакансий</td>
					</tr>
					<tr bgcolor="#e9efef">
						<td class="t1" align="center">ID</td>
						<td class="t1" align="center">Дата<br>разм.</td>
						<td class="t1" align="center">Дата<br>истеч.</td>
						<td class="t1" align="center">Фирма</td>
						<td class="t1" align="center">Раздел</td>
						<td class="t1" align="center">Должность</td>
					</tr>
				{excycle values="#F6FBFB,#FFFFFF"}
				{foreach from=$res.vac item=l}
					<tr bgcolor="{excycle}">
						<td class="t7" valign="top" align="center">
							<a href="?cmd=editvac&id={$l.vid}" class="s1">{$l.vid}</a>
						</td>
						<td class="t7" valign="top">{$l.pdate}</td>
						<td class="t7" valign="top">{$l.vdate}</td>
						<td class="t7" valign="top">{$l.firm}</td>
						<td class="t7" valign="top">{$l.name}</td>
						<td class="t7" valign="top">
							<a href="?cmd=editvac&id={$l.vid}" class="s1">{$l.dol}</a>
						</td>
					</tr>
				{/foreach}
				</table>
			</td>
		</tr>
	</table><br/>
{/capture}

{capture name="lres"}
	<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="100%">
		<tr>
			<td>
				<table cellpadding="4" cellspacing="1" border="0" width="100%" >
					<tr bgcolor="#DEE7E7">
						<td class="t1" align="center" colspan="6">Список размещенных резюме</td>
					</tr>
					<tr bgcolor="#e9efef">
						<td class="t1" align="center">ID </td>
						<td class="t1" align="center">Дата<br>разм.</td>
						<td class="t1" align="center">Дата<br>истеч.</td>
						<td class="t1" align="center">Ф.И.О.</td>
						<td class="t1" align="center">Раздел </td>
						<td class="t1" align="center">Должность</td>
					</tr>
				{excycle values="#F3F8F8,#FFFFFF"}
				{foreach from=$res.res item=l}
					<tr bgcolor="{excycle}">
						<td class="t7" valign="top" align="center">
							<a href="?cmd=editres&id={$l.resid}" class="s1">{$l.resid}</a>
						</td>
						<td class="t7" valign="top">{$l.pdate}</td>
						<td class="t7" valign="top">{$l.vdate}</td>
						<td class="t7" valign="top">{$l.fio}</td>
						<td class="t7" valign="top">{$l.name}</td>
						<td class="t7" valign="top">
							<a href="?cmd=editres&id={$l.resid}" class="s1">{$l.dol}</a>
						</td>
					</tr>
				{/foreach}
				</table>
			</td>
		</tr>
	</table><br/>
{/capture}

{if $res.status==1}
	{$smarty.capture.lvac}<br/>{$smarty.capture.lres}
{else}
	{$smarty.capture.lres}<br/>{$smarty.capture.lvac}
{/if}