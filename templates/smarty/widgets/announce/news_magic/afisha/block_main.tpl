<table class="block_main" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><th><span>{$res.title}</span></th></tr>
</table>
<table width="100%" class="block_main" cellspacing="3" cellpadding="0">
{foreach from=$res.list item=l key=y}
	<tr align="left">
		<td width="14"><img src="/_img/design/200710_afisha/bull1.gif" width="12" height="12"></td>
		<td><a href="{$l.Link}{$l.NewsID}.html">{$l.Title}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</td>
	</tr>
{/foreach}
</table>