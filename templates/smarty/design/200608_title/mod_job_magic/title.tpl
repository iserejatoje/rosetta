{if !$hide_search}
	{include file="`$TEMPLATE.search_keyword`"}
{/if}

{if !isset($smarty.get.print)}
	{if $CURRENT_ENV.regid==56}
		{banner_v2 id="3003"}
	{/if}
{/if}


{if $ENV.site.domain=="86.ru"}
	<br/><center><a href="http://72.ru/job/" style="color:red" target="_blank"><b>Работа в Тюмени</b></a>
	&nbsp;&nbsp;&nbsp;
	<noindex><a href="http://89.ru/job/" rel="nofollow"  style="color:red" target="_blank"><b>Работа в ЯНАО</b></a><noindex></center><br/>
{elseif $ENV.site.domain=="89.ru"}
	<br/><center><a href="http://72.ru/job/" style="color:red" target="_blank"><b>Работа в Тюмени</b></a>
	&nbsp;&nbsp;&nbsp;
	<noindex><a href="http://86.ru/job/" rel="nofollow" style="color:red" target="_blank"><b>Работа в ХМАО</b></a><noindex></center><br/>
{/if}

<div align="center">{banner_v2 id="1220"}</div><br/>

{if in_array($CURRENT_ENV.regid,array(29,45,76,78))}
	<br /><center><font style="color:#005a52;"><b>Теперь смотреть работу в {$CURRENT_ENV.site.name_where} можно и на главной странице Яндекса - <noindex><a href="http://www.yandex.ru/?edit=1&add={if $CURRENT_ENV.regid==76}2589{elseif $CURRENT_ENV.regid==29}2583{elseif $CURRENT_ENV.regid==78}2598{elseif $CURRENT_ENV.regid==45}2594{/if}" rel="nofollow" style="color:red;" target="_blank">установи виджет {$CURRENT_ENV.site.domain}</a></noindex></b></font></center><br />
{/if}

<div class="title" style="padding:5px;">{$rtitle}</div>