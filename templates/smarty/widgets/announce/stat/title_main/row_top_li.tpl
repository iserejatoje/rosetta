<noindex>
{if array_key_exists($CURRENT_ENV.regid, $res.statistic_li) && $CURRENT_ENV.regid == 74}
Аудитория проекта <a target="_blank" href="http://www.liveinternet.ru/stat/{$CURRENT_ENV.regid}/visitors.html?avgraph=yes&amp;id=5">{$res.statistic_li[$CURRENT_ENV.regid].visitors|number_format:0:'':' '}</a> человек за прошедшие сутки!
{else}
За месяц проект <span class="boldtext">{$CURRENT_ENV.site.domain}</span> посетило <a target="_blank" href="/statistic/">{$res.statistic.total.month_clients|number_format:0:'':' '}</a> человек
{/if}
</noindex>