<table width="100%" class="block_right" cellspacing="0" cellpadding="0">
<tr><td class="zag3" style="padding-left:5px; padding-top: 10px;">{$res.title}</td></tr>
</table>
<table width=100% border=0 cellspacing=1 cellpadding=3>
{foreach from=$res.list item=l key=y}
	<tr><td style="margin-top:5px;"><img src="/_img/design/200805_afisha/bull1.gif" width="12" height="14"> <a href="{$l.Link}{$l.NewsID}.html" {if $l.isMarked>0}style="color:red;"{/if}>{$l.Title}</a>
	{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</td></tr>
{/foreach}
</table>