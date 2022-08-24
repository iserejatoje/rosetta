{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<span class="s5b"><a href="{$l.link}">[{$l.text}]</a></span>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $page.pageslink.next!="" }<td style="font-size:11px"><a href="{$page.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

{if $page.errors !== null}
	<div align="center" style="color:red"><b>{$page.errors}</b></div><br/>
{/if}

{if $smarty.capture.pageslink}
	{$smarty.capture.pageslink}<br/><br/>
{/if}

{* Table list *} 
<table width="100%" cellspacing="1" border="0" class="table2">
	<tr bgcolor="#E9EFEF" align="center">
		<th width="40px">Дата</th>
		<th>Адрес</th>
		{if $ENV._params.order!=2}<th>Тип</th>{/if}
		<th width="60px">Цена<br />(тыс.руб.)</th>
		<th>Площадь<br />(кв.м.)</th>
		<th width="40px">Район</th>
		<th width="40px">Этаж</th>
		<th width="40px">Ипотека</th>
	</tr>				
	{assign var=sort_key value=''}

{foreach from=$page.list item=l key=_k}
	{if $ENV._params.order==2 && $l.object != $sort_key}
		<tr>
			<td colspan="7" align="center">
				<b>{$ENV._arrays.rubrics[$l.rub]} :: {$ENV._arrays.objects[$l.object].b}</b>
			</td>
		</tr>
		{assign var=sort_key value=$l.object}
	{/if}

	<tr class="{if $_k%2}bg_color4{/if}" align="center">
		<td class="text11">
			<span class="s3">{$l.date_start|simply_date:"%f":"%d-%m"}</span><br />{$l.date_start|date_format:"%H:%M"}{* "H:i"|date:$l.date_start *}
		</td>
		<td align="left">
		{if $l.address}
			{if empty($ENV._params.object)}
				<a href="/{$ENV.section}/details.html?id={$l.id}"{if $l.imp>0} style="color:red"{/if}>{$l.address|truncate:40}</a>
			{else}
			    <a href="/{$ENV.section}/details.html?id={$l.id}"{if $l.imp>0} style="color:red"{/if}><b>{$l.address|truncate:40}</b></a>
			{/if}
		{else}
			<a href="/{$ENV.section}/details.html?id={$l.id}"{if $l.imp>0} style="color:red"{/if}>не указан</a>
		{/if}&nbsp;{if $l.agent}&nbsp;<img src="/_img/modules/realty/icon_{if $l.agent==1}s{else}a{/if}.png" alt="От {$ENV._arrays.agent[$l.agent].b}" title="От {$ENV._arrays.agent[$l.agent].b}">{/if}{if !empty($l.img1) || !empty($l.img2) || !empty($l.img3)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo1"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}
		</td>
		{if $ENV._params.order != 2}
		<td{if $l.imp>0} style="color:red"{/if}>
			<b>{$ENV._arrays.objects[$l.object].b}</b>
		</td>
		{/if}

		{if $l.price > 0}
		<td{if $l.imp>0} style="color:red"{/if}>

			{if $ENV._params.order == 3}
				<b>
					{if intval($l.price) < floatval($l.price)}
						{$l.price|number_format:2:'.':' '} 
					{else}
						{$l.price|number_format:0:'':' '} 
					{/if}
				</b>
				{*if $l.price_unit!=1}
					<br /><font class="t12b">({$ENV._arrays.price_unit[$l.price_unit].s})</font>
				{/if*}
			{else}
				{if intval($l.price) < floatval($l.price)}
					{$l.price|number_format:2:'.':' '} 
				{else}
					{$l.price|number_format:0:'':' '} 
				{/if}
				{*if $l.price_unit!=1}
					<br /><font class="t12b">({$ENV._arrays.price_unit[$l.price_unit].s})</font>
				{/if*}
			{/if}
		</td>
		{else}
			<td>-</td>
		{/if}
		<td{if $l.imp>0} style="color:red"{/if}>
		{if $l.area_build}
			{if intval($l.area_build) < floatval($l.area_build)}
				{$l.area_build|number_format:2:'.':' '} 
			{else}
				{$l.area_build|number_format:0:'':' '} 
			{/if}
		{/if}
		</td>
		<td{if $l.imp>0} style="color:red"{/if}>{if $l.region.short_name}{$l.region.short_name}{else}-{/if}</td>
		<td{if $l.imp>0} style="color:red"{/if}>{if $l.floor}{$l.floor}{else}-{/if}/{if $l.floors}{$l.floors}{else}-{/if}</td>
		<td{if $l.imp>0} style="color:red"{/if}>{$ENV._arrays.ipoteka[$l.ipoteka]}</td>		
	</tr>    
{/foreach}
</table>
{* Table list end*}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/>
{/if}
<br/><br/>