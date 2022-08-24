{if is_array($res.weather) && count($res.weather) > 0}
{foreach from=$res.weather item=w}{capture name=today}{$w.Date|simply_date|replace:" 00:00":""}{/capture}
{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$w.Date|date_format:"%e"} {$w.Date|date_format:"%m"|month_to_string:2}{/if}: день  {if $w.TDay>0}+{/if}{$w.TDay}°C, ночь  {if $w.TNight>0}+{/if}{$w.TNight}°C, {$w.PrecipText|escape:'quotes'}<br />
{/foreach}
{/if}
