{foreach from=$res.list item=l key=i}
{$l.Date|date_format:"%H:%M"} {$l.Date|date_format:"%e/%m/%Y"} {$l.Title}<br />
{$l.Anon}<br /><br />
{/foreach}