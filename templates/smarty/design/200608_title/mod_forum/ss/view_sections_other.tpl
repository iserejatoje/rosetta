<!--theme other begin-->
<br><br><table width="100%" cellpadding="4">
{excycle values="frow_first,frow_second"}

{foreach from=$res.sections item=l key=section}
<tr class="{excycle}">
	<td>
		<a href="{$res.urls[$section]}"><b>{$section}</b></a>
		<div class="fdescription">

{foreach from=$l item=l2}
{if $l2.data.visible==1}
	{if $l2.level==0}<nobr><a href="{$res.urls[$section]}{$CONFIG.files.get.view.string}?id={$l2.id}">{$l2.data.title}</a>&nbsp;</nobr>{/if}
{/if}
{/foreach} <nobr><a href="{$res.urls[$section]}{$CONFIG.files.get.active.string}"><font color="red">Активные&nbsp;дискуссии</font></a></nobr>
		</div>
	</td>
</tr>
{/foreach}
</table><br>
<!--theme other end-->