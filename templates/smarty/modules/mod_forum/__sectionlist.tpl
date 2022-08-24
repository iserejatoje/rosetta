 <div class="fsmall">
{foreach from=$sections item=l}
	{if $l.level==0}<nobr><a href="view.html?id={$l.id}">{$l.data.title}</a>&nbsp;</nobr>{/if}
{/foreach}
</div>