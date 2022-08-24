{if count($res.list)}
<div class="title">
	<span>{if $res.title_url}<a href="/service/go/?url={"`$res.title_url`"}" target="_blank">{$res.title}</a>{else}{$res.title}{/if}</span>
</div>

<div class="content">
{foreach from=$res.list item=l}
	<div class="line under">
		<span class="author"><a href="/service/go/?url={"`$l.item.url`"}" target="_blank">{$l.item.title}:</a> {$l.item.name}</span>
		<span class="comment">{$l.comment.text|truncate:45}</span><a href="/service/go/?url={"`$l.item.url``$l.comment.item_id`.html?act=last#comment`$l.comment.id`"}" target="_blank" title="Читать далее">далее</a>
	</div>
{/foreach}
</div>
{*
<div class="content">
	<div class="line">Все каталоги:</div>
	<div class="line">
	{foreach from=$res.list item=l name=tech}
		<a href="/service/go/?url={"`$l.item.url`"}" target="_blank">{$l.item.title}</a>{if !$smarty.foreach.tech.last}, {/if}
	{/foreach}
	</div>
</div>
*}
{/if}