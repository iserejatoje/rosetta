
{*
<script type="text/javascript" src="/resources/scripts/themes/editors/tiny_mce/tiny_mce_lpk_admin.adv.js"></script>

{literal}
<script type="text/javascript">

tinyMCE_GZ.init({{/literal}
	{if $tiny_mce_plugins}
	plugins: tinyMCE_GZ.settings.plugins+',{$tiny_mce_plugins}',
	{/if}
	{if $smarty.get.tiny_mce==12}from_cache: false,{/if}
	imagemanager_rootpath : "{$tiny_mce_imagemanager_rootpath}",
	filemanager_rootpath : "{$tiny_mce_filemanager_rootpath}"
{literal}});

</script>
{/literal}
*}


<h3>{$SITE_NAME}: {$SECTION_NAME} ({$MODULE_NAME})</h3>
<!-- НАЧАЛО МЕНЮ -->
{foreach from=$TABS.tabs item=l}
	&nbsp;
	{if $l.value == $TABS.selected || $l.value == $smarty.get.parent_tab }
		{if $l.value == 'vehicles' }
			{if $l.vehicle_type == $smarty.get.vehicle_type }
				<span class="selected">{$l.text}</span>
			{else}
				<a href="?{$SECTION_ID_URL}&{$l.name}={$l.value}{if !empty($l.params)}&{$l.params}{/if}">{$l.text}</a>
			{/if}
		{else}
			<span class="selected">{$l.text}</span>
		{/if}
	{else}
		<a href="?{$SECTION_ID_URL}&{$l.name}={$l.value}{if !empty($l.params)}&{$l.params}{/if}">{$l.text}</a>
	{/if}
	&nbsp;
{/foreach}
<br />
<br />
<!-- КОНЕЦ МЕНЮ -->
<!-- НАЧАЛО ПОДМЕНЮ  -->
<div style="padding: 4px 14px;">
{foreach from=$TABS.tabs item=l}
	{if ($l.value==$TABS.selected || $l.value == $smarty.get.parent_tab) && isset($l.subtabs) }
		{if $l.value == 'vehicles' }
			{if $l.vehicle_type == $smarty.get.vehicle_type }
				{foreach from=$l.subtabs item=i}&nbsp;{if $i.value==$l.selected }<span class="selected">{else}<a href="?{$SECTION_ID_URL}&{$i.name}={$i.value}{if !empty($i.params)}&{$i.params}{/if}">{/if}{$i.text}{if $i.value==$l.selected}</span>{else}</a>{/if}&nbsp;{/foreach}
			{/if}
		{else}
			{foreach from=$l.subtabs item=i}&nbsp;{if $i.value==$l.selected }<span class="selected">{else}<a href="?{$SECTION_ID_URL}&{$i.name}={$i.value}{if !empty($i.params)}&{$i.params}{/if}">{/if}{$i.text}{if $i.value==$l.selected}</span>{else}</a>{/if}&nbsp;{/foreach}
		{/if}
	{/if}
{/foreach}
</div>
<!-- КОНЕЦ ПОДМЕНЮ  -->
<h4>{$TITLE}</h4>
{$PAGE}
</body>
</html>
