{php}$this->_tpl_vars['_dates'] = array();{/php}

{if $res.Title}
	<div class="title">
		<span>{$res.Title}</span>{if $res.TitleLink}&nbsp;&nbsp;(<a href="/service/go/?url={$res.TitleLink|escape:'url'}" target="_blank">все новости</a>){/if}
	</div>
{/if}
	
{foreach from=$res.mainNews item=l key=k}
	<div class="item">
		<span>Главное:</span>
		<a href="/service/go/?url={$l->url.absolute|escape:'url'}" target="_blank"{if $l->isMarked} class="redtext"{/if}>{$l->title|truncate:100:"..."}</a> 
		{if $l->AddMaterial == 1}
			<img src="/_img/design/201002_title_main/common/photo_blue.gif" align="absmiddle" title="Содержит фотоматериалы" alt="Содержит фотоматериал" />
		{elseif $l->AddMaterial == 2}
			<img src="/_img/design/201002_title_main/common/video_blue.gif" align="absmiddle" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" />
		{/if}
	</div>
{/foreach}

{foreach from=$res.newsList item=l key=k}
	<div class="item">
		{if mktime(0,0,0) > $l->tsDate && !in_array(date("d M", $l->tsDate),$_dates)}
			{php}$this->_tpl_vars['_dates'][] = date("d M", $this->_tpl_vars['l']->tsDate);{/php}
			<div class="title">{$l->tsDate|date_format:"%d"} {$l->tsDate|month_to_string:2}</div>
		{/if}
			
		<span class="time">{$l->Date|date_format:"%H:%M"}</span>
		{if ($CURRENT_ENV.regid==74 && strpos($l->url.relative, '225837'))} {* по заказу Серёги Боваренко, 07.08.2009 *}
			<a href="http://chelyabinsk.ru/newsline/225837.html" target="_blank"{if $l->isMarked} class="redtext"{/if}>{$l->Title}</a>
		{else}
			<a href="/service/go/?url={$l->url.relative|escape:'url'}" target="_blank"{if $l->isMarked} class="redtext"{/if}>{$l->Title}</a>
		{/if}
		{if $l->AddMaterial == 1}
			<img src="/_img/design/201002_title_main/common/photo_blue.gif" align="absmiddle" title="Содержит фотоматериалы" alt="Содержит фотоматериал" />
		{elseif $l->AddMaterial == 2}
			<img src="/_img/design/201002_title_main/common/video_blue.gif" align="absmiddle" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" />
		{/if}
	</div>
{/foreach}
	
{foreach from=$res.importantNews item=l key=k}
	<div class="item">
		<img src="/_img/design/201002_title_main/common/b3.gif" width="4" height="4" border="0" alt="" valign="absmiddle" />&nbsp;
		<a href="/service/go/?url={$l->url.absolute|escape:'url'}" target="_blank"{if $l->isMarked} class="redtext"{/if}>{$l->Title}</a>
		{if $l->AddMaterial == 1}
			<img src="/_img/design/201002_title_main/common/photo_blue.gif" align="absmiddle" title="Содержит фотоматериалы" alt="Содержит фотоматериал" />
		{elseif $l->AddMaterial == 2}
			<img src="/_img/design/201002_title_main/common/video_blue.gif" align="absmiddle" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" />
		{/if}
	</div>
{/foreach}