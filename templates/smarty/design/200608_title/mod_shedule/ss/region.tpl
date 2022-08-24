{include file="`$TEMPLATE.sectiontitle`"}

<div class="title">{$res.region.name}</div>

{foreach from=$res.list item=l key=code name=list}
	{if ($smarty.foreach.list.iteration-1)%ceil($smarty.foreach.list.total/3)==0}
		<div style="float:left; padding:10px; width:30%;">
	{/if}
			<a href="/{$ENV.section}/city/{$code}.php">{$l.FullName}</a><br/>
	{if ($smarty.foreach.list.iteration)%ceil($smarty.foreach.list.total/3)==0}
		</div>
	{/if}
{/foreach}
<div style="clear:both"></div>
<br/>
<br/>
<br/>