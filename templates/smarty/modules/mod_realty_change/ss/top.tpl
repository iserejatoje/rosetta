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
	{$ENV._arrays.rubrics[$ENV._params.rubric]}

	{if $page.advs_count.change[$ENV._params.rubric][0][0] !=""}

		&nbsp;<font class="t14b_red">{$page.advs_count.change[$ENV._params.rubric][0][0]}
		{if $page.hours_count.change[$ENV._params.rubric][0]}
			(+{$page.hours_count.change[$ENV._params.rubric][0]})
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
<a href="/{$ENV.cp_section}/">редактировать объявления</a>
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
		<div align="right" class="text11">&nbsp;{$_v} {$page.hours_count.change[$_k][0][0]}
        	{if $page.hours_count.change[$_k][0]}&nbsp;(<b>+{$page.hours_count.change[$_k][0]}</b>){/if}
        </div>
	{else}
		<div align="right">
			<a href="/{$ENV.section}/list.html?rubric={$_k}&view={$ENV._params.view}" class="text11">{$_v} {$page.advs_count.change[$_k][0][0]}
                {if $page.hours_count.change[$_k][0]}&nbsp;(<b>+{$page.hours_count.change[$_k][0]}</b>){/if}
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

		</td>
	</tr>
</table><br/>
{/if}
{* view panel end *}