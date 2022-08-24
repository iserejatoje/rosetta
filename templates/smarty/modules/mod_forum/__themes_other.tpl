<!--theme other begin-->
<br><br><table width="100%" cellpadding="4">
{excycle values="frow_first,frow_second"}
{foreach from=$sections item=l key=section}
<tr class="{excycle}">
	<td>
		<a href="{$urls[$section]}"><b>{$section}</b></a>
		<div class="fdescription">
{foreach from=$l item=l2}
	{if $l2.level==0}<nobr><a href="{$urls[$section]}view.html?id={$l2.id}">{$l2.data.title}</a>&nbsp;</nobr>{/if}
{/foreach}&nbsp;<nobr><a href="{$urls[$section]}active.html"><font color="red">Активные&nbsp;дискуссии</font></a></nobr>
		</div>
	</td>
</tr>
{/foreach}
</table><br>
<!--theme other end-->