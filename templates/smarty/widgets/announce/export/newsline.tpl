{foreach from=$res.list item=l key=i}{$l.time|date_format:"%H:%M %e/%m/%Y"}{$l.text|strip_tags|truncate:550:"..."}{/foreach} Подробнее на сайте wap.74.ru.