<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
{if $page.title}
{* Top title *}
	<tr style="padding-left: 15px;">
		<td colspan="2" class="t5gb">
	{$ENV._arrays.sale_rub[$ENV._params.rubric]}&nbsp;{$ENV._arrays.status_view[$ENV._params.status].z}
	
	{if $page.advs_count.sale[$ENV._params.rubric][$ENV._params.status][0] !=""}
		
		&nbsp;<font class="t14b_red">{$page.advs_count.sale[$ENV._params.rubric][$ENV._params.status][0]} 
		{if $page.hours_count.sale[$ENV._params.rubric][$ENV._params.status]}
			(+{$page.hours_count.sale[$ENV._params.rubric][$ENV._params.status]})
		{/if}
		</font>
	{/if}
		</td>
	</tr>
{* Top title end *}	
{/if}
	<tr valign="top">
		<td>
		<br/>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="left"  style="padding-left: 15px;">
<a href="/{$ENV.section}/add.html">добавить объявление</a>
&nbsp;|&nbsp;
<a href="/{$ENV.cp_section}/">редактировать объявления</a>
&nbsp;|&nbsp;
<a href="http://www.info74.ru/?view=ruleadv" target="_blank">правила</a>
&nbsp;|&nbsp;
<a href="/{$ENV.section}/search.html{$page.url_search}"><b>поиск</b></a>
					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="3" border="0" alt="" /></td>
				</tr>
				<tr>
					<td align="right">
						<table cellspacing="0" cellpadding="0" >
							<tr>
								<td>&nbsp;</td>
								<td style="padding-right: 30px">								
								{*	{banner_v2 id="652"}  *}
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="170">
			<table width="170" cellpadding="0" cellspacing="0" border="0">

{foreach from=$ENV._arrays.sale_rub item=_v key=_k}
	{if $_k == $ENV._params.rubric}
	<tr>
		<td align="right" class="t11_grey">&nbsp;{$_v} {$page.advs_count.sale[$_k][0][0]}
        	{if $page.hours_count.sale[$_k][0]}&nbsp;(<b>+{$page.hours_count.sale[$_k][0]}</b>){/if}
        </td>
    </tr>
	{else}
	<tr>
		<td align="right">
			<a href="/{$ENV.section}/list.html?rubric={$_k}&status={$ENV._params.status}&view={$ENV._params.view}" class="t11_grey">{$_v} {$page.advs_count.sale[$_k][0][0]}
                {if $page.hours_count.sale[$_k][0]}&nbsp;(<b>+{$page.hours_count.sale[$_k][0]}</b>){/if}
            </a>
        </td>
    </tr>
	{/if}
	<tr>
		<td align="left"><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /></td>
	</tr>
{/foreach}

			</table>
		</td>
	</tr>
</table>

{if $page.view_panel}
{* view panel *}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="ssy2">
Представить в виде: 
{foreach from=$ENV._arrays.view item=_v key=_k}
	{if $_k == $ENV._params.view}
		<b>&nbsp;{$_v}&nbsp;</b>
	{else}
		<a href="/{$ENV.section}/list.html{$page.url_view}&view={$_k}">{$_v}</a>
	{/if}
{/foreach}

					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
				</tr>
				<tr>
					<td class="t11_grey">
Сортировать: 

{foreach from=$ENV._arrays.order item=_v key=_k}
	{if $_k == $ENV._params.order}
		<b>&nbsp;{$_v[1]}&nbsp;</b>
	{else}
		<a href="/{$ENV.section}/list.html{$page.url_order}&order={$_k}">{$_v[1]}</a>&nbsp;
	{/if}
{/foreach}
					</td>
				</tr>
			</table>
		</td>
		<td width="170">
			<table width="170" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><img src="/_img/x.gif" width="1" height="17" border="0" alt="" /></td>
				</tr>
{if !$ENV._params.object || $ENV._arrays.objects[$ENV._params.object].n > 0}
	{foreach from=$ENV._arrays.status_view item=_v key=_k}
	  {if $_k == $ENV._params.status}
			<tr>
				<td align="right"><span class="t11_grey">&nbsp;{$_v.m}
	                {if $page.advs_count.sale[$ENV._params.rubric][$_k][0] && $_k}
	                             &nbsp;{$page.advs_count.sale[$ENV._params.rubric][$_k][0]}
	                {/if}
	                             </span>
	            </td>
	        </tr>
	{else}
	        <tr>
	        	<td align="right">
	        		<a href="/{$ENV.section}/list.html?rubric={$ENV._params.rubric}&status={$_k}&view={$ENV._params.view}" class="t11_grey">{$_v.m}
	               	{if $page.advs_count.sale[$ENV._params.rubric][$_k][0] && $_k}
	                             &nbsp;{$page.advs_count.sale[$ENV._params.rubric][$_k][0]}    
	                {/if}
	                </a>
	            </td>
	        </tr>
	  {/if}
		<tr><td align="left"><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /></td></tr>
	{/foreach}
{/if}
			</table>
		</td>
	</tr>
</table><br/>
{/if}
{* view panel end *}