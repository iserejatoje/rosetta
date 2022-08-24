<div class="jcmcarousel-skin-title-video">
	<div class="jcmcarousel-container jcmcarousel-container-horizontal">
		<div class="jcmcarousel-prev-container">
			<div class="jcmcarousel-logo"><a href="{$res.Link}" title="Все видео" target="_blank"><img src="/_img/x.gif" width="12" height="70" alt="Все видео" /></a></div>
			<div class="jcmcarousel-prev"> </div>
		</div>
		<div class="jcmcarousel-next-container">
			<div class="jcmcarousel-link"><a href="{$res.Link}" title="Все видео" target="_blank"><img src="/_img/x.gif" width="11" height="58" alt="Все видео" /></a></div>
			<div class="jcmcarousel-next"> </div>
		</div>
		<div class="jcmcarousel-clip jcmcarousel-clip-horizontal">
			<ul class="jcmcarousel-list">
			{foreach from=$res.List item=l}
				<li class="jcmcarousel-item"{if $l.thumb} style="background: transparent url({$l.thumb}) no-repeat 0px 0px;"{/if}>
					<div class="jcmcarousel-item-type">
		{if $l.addmaterial == 3}
					<div class="jcmcarousel-useritem-type" title="{if strpos($l.url, 'newyear')}Новогоднее видео{else}Любительское видео{/if}">
		{/if}
						{php}
							if ($this->_tpl_vars['l']['shorttitle'])
								$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['shorttitle'];
							else
								$this->_tpl_vars['shorttitle'] = $this->_tpl_vars['l']['title'];
							
							$this->_tpl_vars['shorttitle'] = trim(str_replace('"', '&#034;', $this->_tpl_vars['shorttitle']),'  ');
							$this->_tpl_vars['title'] = trim(str_replace('"', '&#034;', $this->_tpl_vars['l']['title']),'  ');
						{/php}
						<a href="{$l.url}#video" title="{$title}" target="_blank">
							<img src="/_img/x.gif" width="120" height="80" alt="{$title}" />
						</a>
		{if $l.addmaterial == 3}
					</div>
		{/if}
					</div>
					
					<div class="jcmcarousel-item-title">
						{*if $l.addmaterial == 3}
							<a href="{$l.url}#video" title="{$title}" target="_blank" class="redtext">{if strpos($l.url.absolute, 'newyear')}Новогоднее видео{else}Любительское видео{/if}</a>
						{else*}
							<a href="{$l.url}#video" title="{$title}" target="_blank"{if $l.IsHotLink} class="redtext"{/if}>{$shorttitle|scrap_text:0:0:2:18:17}</a>
						{*/if*}
					</div>
				</li>
			{/foreach}
			</ul>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		$('.jcmcarousel-list').jcm_carousel({
			animation: false
		});
	});
</script>

{/literal}