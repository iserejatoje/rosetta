{if !$hide_search}
	{include file="`$TEMPLATE.search_keyword`"}
{/if}

{if !isset($smarty.get.print)}
{*	{if in_array($CURRENT_ENV.regid,array(2,16,34,59,61,63,72,74))}
		<br /><center><font style="color:#005a52;"><b>Теперь смотреть работу в {$CURRENT_ENV.site.name_where} можно и на главной странице Яндекса - <noindex><a href="http://www.yandex.ru/?edit=1&add={if $CURRENT_ENV.regid==74}2045{elseif $CURRENT_ENV.regid==72}2269{elseif $CURRENT_ENV.regid==59}2266{elseif $CURRENT_ENV.regid==63}2268{elseif $CURRENT_ENV.regid==16}2272{elseif $CURRENT_ENV.regid==61}2271{elseif $CURRENT_ENV.regid==2}2270{elseif $CURRENT_ENV.regid==34}2273{/if}" rel="nofollow" style="color:red;" target="_blank">установи виджет {$CURRENT_ENV.site.domain}</a></noindex></b></font></center><br />
	{/if}*}

	{if $ENV.site.domain=="86.ru"}
		<br/><center><a href="http://72.ru/job/" style="color:red" target="_blank"><b>Работа в Тюмени</b></a>
		&nbsp;&nbsp;&nbsp;
		<noindex><a href="http://89.ru/job/" rel="nofollow"  style="color:red" target="_blank"><b>Работа в ЯНАО</b></a><noindex></center><br/>
	{elseif $ENV.site.domain=="89.ru"}
		<br/><center><a href="http://72.ru/job/" style="color:red" target="_blank"><b>Работа в Тюмени</b></a>
		&nbsp;&nbsp;&nbsp;
		<noindex><a href="http://86.ru/job/" rel="nofollow" style="color:red" target="_blank"><b>Работа в ХМАО</b></a><noindex></center><br/>
	{elseif $ENV.site.domain=="72.ru"}
		<br/><center>
		<a href="http://86.ru/job/" target="_blank" style="color:red"><b>Работа в ХМАО</b></a>
		&nbsp;&nbsp;&nbsp;
		<noindex><a href="http://89.ru/job/" target="_blank" rel="nofollow" style="color:red"><b>Работа в ЯНАО</b></a></noindex>
		</center><br/>
	{/if}
	
	<div align="center">{banner_v2 id="1220"}</div><br/>
{/if}

<div class="title" style="padding:5px;">{$rtitle}</div>