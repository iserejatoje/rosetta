<span class="title">Карта сайта</span><br/><br/>
<table class="sitemap">
{foreach from=$page.tree item=l}
{if $l.name!='pages' && $l.name!='page' && $l.name!='main'}
<tr>
	<td width="100%" style="padding-left:{$l.level*20}px;">		
		<a href="{$l.data.link}" class="grey-link">{$l.data.name|ucfirst}</a>
	</td>
</tr>
{/if}
{/foreach}
</table>