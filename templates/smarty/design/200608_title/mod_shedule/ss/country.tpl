<div class="title">Регионы</div>

{foreach from=$res.list item=l key=id name=list}
	{if ($smarty.foreach.list.iteration-1)%ceil($smarty.foreach.list.total/3)==0}
		<div style="float:left; padding:10px; width:30%;">
	{/if}
		<a href="/{$ENV.section}/{if $l.Code=='001001025000000000' || $l.Code=='001001026000000000'}city{else}region{/if}/{$l.Code}.php">{$l.FullName}</a><br/>
	{if ($smarty.foreach.list.iteration)%ceil($smarty.foreach.list.total/3)==0}
		</div>
	{/if}
{/foreach}
<div style="clear:both"></div>
<br/>
<br/>
<br/>