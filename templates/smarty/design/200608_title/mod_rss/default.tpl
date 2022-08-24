Здесь Вы можете получить ссылки на RSS-каналы информационных материалов,
опубликованных на сайтах. RSS  – это международный формат,
с помощью которого новости и обновления с сайтов могут автоматически экспортироваться на другие
ресурсы или на компьютер пользователя.<br/><br/>


{foreach from=$res.list item=site}
		<div class="title3"><b><a href="{$site.path}/" class="title3" target="_blank">{$site.name}</a></b>{if $site.slogan} - {$site.slogan}{/if}</div>
	{foreach from=$site.types item=i key=type}
		{if $i.visible}
		<img src="/_img/modules/rss/feed_icon_12x12.gif" border="0" vspace="3" style="vertical-align:middle;"/> {$i.title} - <a href="http://{$CURRENT_ENV.site.domain}/rss/type/{$site.name}/{$type}.xml" class="rss_link" target="_blank">http://{$CURRENT_ENV.site.domain}/rss/type/{$site.name}/{$type}.xml</a><br/>
		{/if}
	{/foreach}<br/>
{/foreach}

