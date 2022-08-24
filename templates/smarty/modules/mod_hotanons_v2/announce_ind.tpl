{foreach from=$res.list item=l}
<img src="/img/kriz/bullet1.gif" width="7" height="7"> <a href="/service/go/?url={"`$l.name_part`"|escape:"url"}" class="white1" target="_blank">{$l.name|truncate:100:"...":false}</a>
{/foreach}