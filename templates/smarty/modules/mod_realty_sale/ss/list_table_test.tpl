{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a class="s5b" href="{$l.link}">[{$l.text}]</a>&nbsp;
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
<table width="100%" cellspacing="2" border="0" class="table2">
	<tr>
		<th width="40px">Дата</th>
		<th>Текст объявления</th>
		<th width="60px">Цена<br />(тыс.руб.)</th>
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
		
		<td align="left"{if $l.imp>0} style="color:red"{/if}>
		{if $ENV._params.order != 2}
			Тип недвижимости:&nbsp;
			{if empty($ENV._params.object)}
				<b>{$ENV._arrays.objects[$l.object].b}</b>
			{else}
				{$ENV._arrays.objects[$l.object].b}
			{/if}
		{/if}
		{if $l.series}
			<br />Серия/Тип:&nbsp;
			{if $ENV._arrays.series[$l.series].s}
			    {$ENV._arrays.series[$l.series].s}
			{else}-{/if} / 
			{if $ENV._arrays.build_type[$l.build_type].s}
			    {$ENV._arrays.build_type[$l.build_type].s}
			{else}-{/if}
		{/if}
		{if $l.address}
			<br />Адрес:&nbsp;
			{if empty($ENV._params.object)}
				{$l.address|truncate:40}
			{else}
			    <b>{$l.address|truncate:40}</b>
			{/if}
		{/if}&nbsp;{if $l.agent}&nbsp;<img src="/_img/modules/realty/icon_{if $l.agent==1}s{else}a{/if}.png" alt="От {$ENV._arrays.agent[$l.agent].b}" title="От {$ENV._arrays.agent[$l.agent].b}">{/if}{if !empty($l.img1) || !empty($l.img2) || !empty($l.img3)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo1"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}
		{if $l.area_build}
			<br />Площадь помещения:&nbsp;{if intval($l.area_build) < floatval($l.area_build)}
				{$l.area_build|number_format:2:'.':' '} 
			{else}
				{$l.area_build|number_format:0:'':' '} 
			{/if} кв.м.
		{/if}
		{if $l.area_site > 0}
			<br />Площадь участка:&nbsp;
			{if intval($l.area_site) < floatval($l.area_site)}
				{$l.area_site|number_format:2:'.':' '} 
			{else}
				{$l.area_site|number_format:0:'':' '} 
			{/if}
			{$ENV._arrays.site_unit[$l.area_site_unit]}
		{/if}
			{if $l.contacts}<br />Контакты:&nbsp;
			{$l.contacts|strip_tags|truncate:60}{/if}
			<br />
			<div align="right">
        		<a href="/{$ENV.section}/details.html?id={$l.id}">подробнее</a>
        	</div>
		</td>

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
				{if $l.price_unit!=1}
					<br /><font class="small">({$ENV._arrays.price_unit[$l.price_unit].s})
				{/if}
			{else}
				{if intval($l.price) < floatval($l.price)}
					{$l.price|number_format:2:'.':' '} 
				{else}
					{$l.price|number_format:0:'':' '} 
				{/if}
				{if $l.price_unit!=1}
					<br />({$ENV._arrays.price_unit[$l.price_unit].s})
				{/if}
			{/if}
		</td>
		{else}
			<td{if $l.imp>0} style="color:red"{/if}>-</td>
		{/if}
					
		<td{if $l.imp>0} style="color:red"{/if}>{if $l.region.short_name}{$l.region.short_name}{else}-{/if}</td>
		<td{if $l.imp>0} style="color:red"{/if}>{if $l.floor}{$l.floor}{else}-{/if}/{if $l.floors}{$l.floors}{else}-{/if}</td>
		<td{if $l.imp>0} style="color:red"{/if}>{$ENV._arrays.ipoteka[$l.ipoteka]}</td>
	</tr>

{/foreach}
</table>
{* Table list end*}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/><br/>
{/if}
<br/><br/>