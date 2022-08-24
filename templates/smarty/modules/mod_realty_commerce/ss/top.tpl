{if $CURRENT_ENV.regid == 86 && ($CURRENT_ENV.section == 'sale' || $CURRENT_ENV.section == 'rent' || $CURRENT_ENV.section == 'change' || $CURRENT_ENV.section == 'commerce')}
	<center><noindex><a href="http://72doma.ru/{$CURRENT_ENV.section}/" rel="nofollow" target="_blank" style="color:red;">Недвижимость в Тюмени</a>
        &nbsp;&nbsp;&nbsp; <a href="http://89.ru/{$CURRENT_ENV.section}/" rel="nofollow" target="_blank" style="color:red;">Недвижимость в ЯНАО</a>
	</noindex></center>
{/if}

{if $CURRENT_ENV.regid == 89 && ($CURRENT_ENV.section == 'sale' || $CURRENT_ENV.section == 'rent' || $CURRENT_ENV.section == 'change' || $CURRENT_ENV.section == 'commerce')}
	<center><noindex><a href="http://72doma.ru/{$CURRENT_ENV.section}/" rel="nofollow" target="_blank" style="color:red;">Недвижимость в Тюмени</a>
        &nbsp;&nbsp;&nbsp; <a href="http://86.ru/{$CURRENT_ENV.section}/" rel="nofollow" target="_blank" style="color:red;">Недвижимость в ХМАО</a>
	</noindex></center>
{/if}

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
{if $page.title}
{* Top title *}
	<tr>
		<td colspan="2" class="title_normal"><b>
	{if $ENV._params.rubric == 1 || $ENV._params.rubric == 2}
		{$ENV._arrays.rubrics[$ENV._params.rubric]}&nbsp;{$ENV._arrays.status_view[$ENV._params.status].z.sale}
	{else}
		{$ENV._arrays.rubrics[$ENV._params.rubric]}&nbsp;{$ENV._arrays.status_view[$ENV._params.status].z.rent}
	{/if}

	{if $page.advs_count.commerce[$ENV._params.rubric][$ENV._params.status][0] !=""}

		&nbsp;<font color="red">{$page.advs_count.commerce[$ENV._params.rubric][$ENV._params.status][0]}
		{if $page.hours_count.commerce[$ENV._params.rubric][$ENV._params.status]}
			(+{$page.hours_count.commerce[$ENV._params.rubric][$ENV._params.status]})
		{/if}
		</font>
	{/if}</b>
		</td>
	</tr>
{* Top title end *}
{/if}
	<tr valign="top">
		<td width="100%">
			<a href="/{$ENV.section}/add.html">добавить объявление</a>
{if $USER->IsAuth()}&nbsp;|&nbsp;
<a href="/{$ENV.cp_section}/" class="data">редактировать объявления</a>
{/if}
&nbsp;|&nbsp;
{*<a href="http://www.info74.ru/?view=ruleadv" target="_blank">правила</a>*}
<a href="/{$ENV.section}/rules.html" target="_blank" class="data">правила</a>
&nbsp;|&nbsp;
<a href="/{$ENV.section}/search.html{$page.url_search}"><b>поиск</b></a>
		</td>

{if is_array($ENV._arrays.rubrics)}
		<td nowrap="nowrap">

{foreach from=$ENV._arrays.rubrics item=_v key=_k}
	{if $_k == $ENV._params.rubric}
		<div align="right" class="text11">&nbsp;{$_v} {$page.advs_count.commerce[$_k][0][0]}
        	{if $page.hours_count.commerce[$_k][0]}&nbsp;(<b>+{$page.hours_count.commerce[$_k][0]}</b>){/if}
        </div>
	{else}
		<div align="right">
			<a href="/{$ENV.section}/list.html?rubric={$_k}&status={$ENV._params.status}&view={$ENV._params.view}" class="t11_grey">{$_v} {$page.advs_count.commerce[$_k][0][0]}
                {if $page.hours_count.commerce[$_k][0]}&nbsp;(<b>+{$page.hours_count.commerce[$_k][0]}</b>){/if}
            </a>
        </div>
	{/if}
{/foreach}
		</td>
{/if}
	</tr>
</table>

{if $page.view_panel}

{* view panel *}
<br/>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<div class="text11">
{if is_array($ENV._arrays.view)}
Представить в виде:
{foreach from=$ENV._arrays.view item=_v key=_k}
	{if $_k == $ENV._params.view}
		<b>&nbsp;{$_v}&nbsp;</b>
	{else}
		<a href="/{$ENV.section}/list.html{$page.url_view}&view={$_k}">{$_v}</a>
	{/if}
{/foreach}
{/if}

{if is_array($ENV._arrays.order)}
<br/>
Сортировать:

{foreach from=$ENV._arrays.order item=_v key=_k}
	{if $_k == $ENV._params.order}
		<b>&nbsp;{$_v[1]}&nbsp;</b>
	{else}
		<a href="/{$ENV.section}/list.html{$page.url_order}&order={$_k}">{$_v[1]}</a>&nbsp;
	{/if}
{/foreach}
{/if}
			</div>
		</td>
		<td width="170">
			<div class="text11" align="right">
{if !$ENV._params.object || $ENV._arrays.objects[$ENV._params.object].n > 0}
	{foreach from=$ENV._arrays.status_view item=_v key=_k}
	  {if $_k == $ENV._params.status}
			&nbsp;{$_v.m}
	                {if $page.advs_count.commerce[$ENV._params.rubric][$_k][0] && $_k}
	                             &nbsp;{$page.advs_count.commerce[$ENV._params.rubric][$_k][0]}
	                {/if}
	{else}
	        		<a href="/{$ENV.section}/list.html?rubric={$ENV._params.rubric}&status={$_k}&view={$ENV._params.view}" class="t11_grey">{$_v.m}
	               	{if $page.advs_count.commerce[$ENV._params.rubric][$_k][0] && $_k}
	                             &nbsp;{$page.advs_count.commerce[$ENV._params.rubric][$_k][0]}
	                {/if}
	                </a>
	  {/if}
		<br/>
	{/foreach}
{/if}

		</td>
	</tr>
</table><br/>
{/if}
<!-- <table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center"><a href="/specialoffer/29.html" target="_blank"><font color="#ff0000"><b>Продается отдельно стоящее здание</b></font></a></td>
</tr>
</table><br/> -->
{* view panel end *}