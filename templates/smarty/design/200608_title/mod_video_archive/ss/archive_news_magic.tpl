{capture name=pageslink}
{if !empty($res.pageslink.btn)}
	<div class="video-a-pageslink">Страницы:
	{if $res.pageslink.first!="" }<a href="{$res.pageslink.first}">первая</a>{/if}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}">{$l.text}</a>
		{else}
			&nbsp;<span class="current"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
	{if $res.pageslink.last!="" }&nbsp;<a href="{$res.pageslink.last}">последняя</a>{/if}
	</div>
{/if}
{/capture}

<div class="video-a">
	<div class="video-a-logo">
		<a href="{$res.site.url}"><img src="{$res.site.logo}" /></a>
	</div>
	<div class="video-a-title"><span>{$res.section.name}</span> ({$res.count|number_format:0:'':' '})</div>

	{$smarty.capture.pageslink}

	<ul class="video-a-list">
	{foreach from=$res.list item=l}
		<li {if $l.thumb.File}style="background-image: url({$l.thumb.File});"{/if}>
			<div class="type">
				{php}
					if ($this->_tpl_vars['l']['shorttitle'])
						$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['shorttitle'];
					else
						$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['title'];
					
					$this->_tpl_vars['shorttitle'] = str_replace('"', '&#034;', $this->_tpl_vars['shorttitle']);
					$this->_tpl_vars['title'] = str_replace('"', '&#034;', $this->_tpl_vars['l']['title']);
				{/php}
				<a href="{$l.url.absolute}" title="{$title}" target="_blank">
					<img src="/_img/x.gif " width="90" height="90" alt="{$title}">
				</a>
			</div>
			<div class="date">
				{$l.time|simply_date}
			</div>
			<div class="title">
				<a href="{$l.url.absolute}" title="{$title}" target="_blank">{$shorttitle|scrap_text:0:0:4:20:20}</a>
			</div>
		</li>
	{/foreach}
	</ul><br clear="both"/>
	
	{$smarty.capture.pageslink}
</div>