<pre>
Идентификатор рубрики
----------------------------------------
{foreach from=$CONFIG.arrays.rubrics item=l key=k}
{$k} - {$l}
{/foreach}

Идентификатор типа жилья
----------------------------------------
{foreach from=$CONFIG.arrays.objects item=l key=k}
{$k} - {$l.b}
{/foreach}

{if $res.cities}
Идентификатор города
----------------------------------------
{foreach from=$res.cities item=l key=k}
{$k} - {$l.name}
{/foreach}
{/if}

Идентификатор района
----------------------------------------
{if $res.regions}
{foreach from=$res.regions.regions item=l key=k}
{$k} - {$l.name}
{/foreach}
{else}
{foreach from=$CONFIG.arrays.regions item=l key=k}
{$k} - {$l.b}
{/foreach}
{/if}

Идентификатор серии
----------------------------------------
{foreach from=$CONFIG.arrays.series item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор типа дома
----------------------------------------
{foreach from=$CONFIG.arrays.build_type item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор состояния
----------------------------------------
{foreach from=$CONFIG.arrays.status item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор стадии строительства
----------------------------------------
{foreach from=$CONFIG.arrays.stage item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор единиц измерения площади участка
----------------------------------------
{foreach from=$CONFIG.arrays.site_unit item=l key=k}
{$k} - {$l}
{/foreach}

Идентификатор единиц измерения цены
----------------------------------------
{foreach from=$CONFIG.arrays.price_unit item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор возраста здания
----------------------------------------
{foreach from=$CONFIG.arrays.age_build item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор отделки
----------------------------------------
{foreach from=$CONFIG.arrays.decoration item=l key=k}
{$k} - {$l.b}
{/foreach}

Идентификатор типа санузла
----------------------------------------
{foreach from=$CONFIG.arrays.lavatory item=l key=k}
{$k} - {$l.b}
{/foreach}
</pre>
