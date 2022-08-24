{if is_array($page.photos) && sizeof($page.photos)}
<br/><br/>
<script type="text/javascript">
{literal}

jQuery(document).ready(function() {
	
	jQuery("#gallery a").fancybox(
		{
			overlayShow: true,
			hideOnContentClick: true,
			zoomSpeedOut: 550,
			zoomSpeedIn: 550
		}
	); 
});
{/literal}
</script>

<a name="gallery"></a>
<div id="gallery" style="width: 100%;">
	{foreach from=$page.photos item=p}
		<div style="float:left;padding: 2px;">
			<div style="background: transparent url({$p.thumb.url}) 
			no-repeat scroll center center; width: 100px; height: 100px; 
			-moz-background-clip: -moz-initial; -moz-background-origin: 
			-moz-initial; -moz-background-inline-policy: -moz-initial;"><a rel="news_{$p.uniqueid}" href="{$p.photo.url}"{if $p.title} title="{$p.title}"{/if} target="_blank">{if $p.descr}<span style="display: none">{$p.descr}</span>{/if}<img src="/_img/x.gif" width="100" height="100" border="0" alt="{$p.title}"/></a></div>
		</div>
	{/foreach}
	<br clear="both"/>
</div>
<br clear="both"/>
{/if}