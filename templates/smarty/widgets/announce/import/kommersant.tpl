<table cellpadding="3" cellspacing="0" width="100%" border="0">
<tr><td><noindex><a href="http://www.kommersant.ru/regions/region.aspx?regionID=16" target="_blank" rel="nofollow"><img src="http://7474.ru/kommersant/logo_kom.gif" border="0" /></a></noindex></td></tr>
{foreach from=$res.list item=l key=i}<tr><td><noindex><a class="a11" href="{$l.link}" target="_blank" rel="nofollow">{$l.title|strip_tags|truncate:100:"..."}</a></noindex></td></tr>{/foreach}
</table>