{if !empty($BLOCK.data)}

{*if count($res.pathdesc) && $res.pathdesc[0].path=="search"}
	{if !empty($smarty.get.type)}{assign var="type" value="?type=`$smarty.get.type`"}{else}{assign var="type" value="?type=0"}{/if}
	{if !empty($smarty.get.parent)}
		{assign var="parent" value="&parent=`$smarty.get.parent`"}
		{if !empty($smarty.get.model)}{assign var="model" value="&model=`$smarty.get.model`"}{else}{assign var="model" value=""}{/if}
	{else}
		{assign var="parent" value=""}
	{/if}
{else}
	{if $res.type=="demand"}{assign var="type" value="?type=1"}{else}{assign var="type" value="?type=0"}{/if}
	{if (count($res.pathdesc) > 1) && (!empty($res.pathdesc[1].id))}
		{assign var="parent" value="&parent=`$res.pathdesc[1].id`"}
		{if (count($res.pathdesc) > 2) && (!empty($res.pathdesc[2].id))}{assign var="model" value="&model=`$res.pathdesc[2].id`"}{else}{assign var="model" value=""}{/if}
	{else}
		{assign var="parent" value=""}
	{/if}
{/if*}
{if count($res.pathdesc) && $res.pathdesc[0].path=="search"}
	{if !empty($smarty.get.type)}{assign var="type" value="?type=`$smarty.get.type`"}{else}{assign var="type" value="?type=0"}{/if}
	{if !empty($smarty.get.parent)}
		{assign var="parent" value="&parent=`$smarty.get.parent`"}
		{if !empty($smarty.get.model)}{assign var="model" value="&model=`$smarty.get.model`"}{else}{assign var="model" value=""}{/if}
	{else}
		{assign var="parent" value=""}
	{/if}
	{if !empty($smarty.get.wheeltype)}{assign var="r_wheeltype" value="&wheeltype=`$smarty.get.wheeltype`"}{else}{assign var="r_wheeltype" value=""}{/if}
	{if !empty($smarty.get.year_from)}{assign var="r_year_from" value="&year_from=`$smarty.get.year_from`"}{else}{assign var="r_year_from" value=""}{/if}
	{if !empty($smarty.get.year_to)}{assign var="r_year_to" value="&year_to=`$smarty.get.year_to`"}{else}{assign var="r_year_to" value=""}{/if}
	{if !empty($smarty.get.probeg_from)}{assign var="r_probeg_from" value="&probeg_from=`$smarty.get.probeg_from`"}{else}{assign var="r_probeg_from" value=""}{/if}
	{if !empty($smarty.get.probeg_to)}{assign var="r_probeg_to" value="&probeg_to=`$smarty.get.probeg_to`"}{else}{assign var="r_probeg_to" value=""}{/if}
	{if !empty($smarty.get.gearbox)}{assign var="r_gearbox" value="&gearbox=`$smarty.get.gearbox`"}{else}{assign var="r_gearbox" value=""}{/if}
	{if !empty($smarty.get.valueeng)}{assign var="r_valueeng" value="&valueeng=`$smarty.get.valueeng`"}{else}{assign var="r_valueeng" value=""}{/if}
	{if !empty($smarty.get.typebody)}{assign var="r_typebody" value="&typebody=`$smarty.get.typebody`"}{else}{assign var="r_typebody" value=""}{/if}
	{if !empty($smarty.get.color)}{assign var="r_color" value="&color=`$smarty.get.color`"}{else}{assign var="r_color" value=""}{/if}
	{if !empty($smarty.get.period)}{assign var="r_period" value="&period=`$smarty.get.period`"}{else}{assign var="r_period" value=""}{/if}

	{if !empty($smarty.get.fuel)}
		{foreach from=$smarty.get.fuel item=fuel key=k_fuel}
			{assign var="r_fuel" value="`$r_fuel`&fuel[`$k_fuel`]=`$fuel`"}
		{/foreach}
	{/if}
{else}
	{if $res.type=="demand"}{assign var="type" value="?type=1"}{else}{assign var="type" value="?type=0"}{/if}
	{if (count($res.pathdesc) > 1) && (!empty($res.pathdesc[1].id))}
		{assign var="parent" value="&parent=`$res.pathdesc[1].id`"}
		{if (count($res.pathdesc) > 2) && (!empty($res.pathdesc[2].id))}{assign var="model" value="&model=`$res.pathdesc[2].id`"}{else}{assign var="model" value=""}{/if}
	{else}
		{assign var="parent" value=""}
	{/if}
{/if}


<table border="0" cellpadding="0" cellspacing="3" width="100%">
<tr>
	<td class="block_title_obl" style="padding-left: 15px;" align="left"><span>Цена</span></td>
</tr> 
</table>
<table border="0" cellpadding="2" cellspacing="3" width="100%">
<tr>
	<td><img src="/_img/x.gif" alt="" border="0" height="4" width="1"></td>
</tr>
<tr>
	<td valign="top" width="100%">
		<table width="100%" cellspacing="3" cellpadding="5">
{foreach from=$BLOCK.data item=l}
		<tr>
			<td align="right">
				{*<strong><a href="/{$SITE_SECTION}/search/{$type}{$parent}{$model}&cost_from={$l.min}&cost_to={$l.max}">{$l.min|number_format:0:'':"'"} &mdash; {$l.max|number_format:0:'':"'"}</a></strong> руб.*}
       				<strong><a href="/{$SITE_SECTION}/search/{$type}{$parent}{$model}&cost_from={$l.min}&cost_to={$l.max}{$r_wheeltype}{$r_year_from}{$r_year_to}{$r_probeg_from}{$r_probeg_to}{$r_gearbox}{$r_valueeng}{$r_typebody}{$r_color}{$r_fuel}{$r_period}&range=1" class="zag3">{$l.min|number_format:0:'':"'"} &mdash; {$l.max|number_format:0:'':"'"}</a></strong> руб.
			</td>
			<td align="right">
				({$l.cnt})
			</td>
		</tr>
{/foreach}
		</table>
	</td>
</tr>
</table>
{/if}