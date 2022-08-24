<div class="video-a">
	<ul class="video-a-list">
	{foreach from=$res.List item=l}
		<li {if $l.thumb.File}style="background-image: url({$l.thumb.File});"{/if}>
			<div class="type">
{if $l.addmaterial == 3}
			<div class="userstype">
{/if}
				{php}
					if ($this->_tpl_vars['l']['shorttitle'])
						$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['shorttitle'];
					else
						$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['title'];
					
					$this->_tpl_vars['shorttitle'] = str_replace('"', '&#034;', $this->_tpl_vars['shorttitle']);
					$this->_tpl_vars['title'] = str_replace('"', '&#034;', $this->_tpl_vars['l']['title']);
				{/php}
				<a href="{$l.url.absolute}" title="{$title}{if $l.addmaterial == 3}, Любительское видео{/if}" target="_blank">
					<img src="/_img/x.gif" width="90" height="90" alt="{$title}{if $l.addmaterial == 3}, Любительское видео{/if}">
				</a>
{if $l.addmaterial == 3}
			</div>
{/if}
			</div>
			<div class="date">
				{$l.time|simply_date}
			</div>
			<div class="title">
				<a href="{$l.url.absolute}" title="{$title}{if $l.addmaterial == 3}, Любительское видео{/if}" target="_blank">{$shorttitle|scrap_text:0:0:4:20:20}</a>
			</div>
		</li>
	{/foreach}
	</ul>
</div>