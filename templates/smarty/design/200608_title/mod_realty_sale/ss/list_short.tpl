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

{if $smarty.capture.pageslink}
	{$smarty.capture.pageslink}<br/><br/>
{/if}

{* Table list *} 
<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF">
	<tr bgcolor="#E9EFEF" align="center">
		<th width="40px" class="t1"><b>Дата</b></th>
		<th class="t1"><b>Адрес</b></th>
		{if empty($ENV._params.object)}<th class="t1"><b>Тип</b></th>{/if}
		<th width="60px" class="t1"><b>Цена<br />(тыс.руб.)</b></th>
		<th class="t1"><b>Площадь<br />(кв.м.)</b></th>
		<th width="40px" class="t1"><b>Район</b></th>
		<th width="40px" class="t1"><b>Этаж</b></th>
		<th width="40px" class="t1"><b>Ипотека</b></th>
	</tr>				
	{assign var=sort_key value=''}

{foreach from=$page.list item=l key=_k}
	{if $ENV._params.order==2 && $l.object != $sort_key}
		<tr bgcolor="#FFFFFF" align="center">
			<td colspan="7">
				<b>{$ENV._arrays.rubrics[$l.rub]} :: {$ENV._arrays.objects[$l.object].b}</b>
			</td>
		</tr>
		{assign var=sort_key value=$l.object}
	{/if}

	<tr bgcolor="{if $_k%2}#F3F8F8{else}#FFFFFF{/if}" align="center">
		<td class="t7">
			{*<font class="s3" color="red">{"d-m"|date:$l.date_start}</font><br />{"H:i"|date:$l.date_start}*}
			<font class="s3" color="red">{$l.date_start|simply_date:"%f":"%d-%m"}</font><br />{"H:i"|date:$l.date_start}
		</td>
		<td align="left">
		{if $l.address}
			{if empty($ENV._params.object)}
				<a href="/{$ENV.section}/details.html?id={$l.id}">{$l.address|truncate:40}</a>
			{else}
			    <a href="/{$ENV.section}/details.html?id={$l.id}"><b>{$l.address|truncate:40}</b></a>
			{/if}
		{else}
			<a href="/{$ENV.section}/details.html?id={$l.id}">не указан</a>
		{/if}{if !empty($l.img1)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}
		</td>
		{if empty($ENV._params.object)}
		<td>
		{if $ENV._params.order != 2}
			{if empty($ENV._params.object)}
				<b>{$ENV._arrays.objects[$l.object].b}</b>
			{else}
				{$ENV._arrays.objects[$l.object].b}
			{/if}
		{/if}
		</td>
		{/if}
		{if $l.price > 0}
		<td>

			{if $ENV._params.order == 3}
				<b>
					{if intval($l.price) < floatval($l.price)}
						{$l.price|number_format:2:'.':' '} 
					{else}
						{$l.price|number_format:0:'':' '} 
					{/if}
				</b>
				{if $l.price_unit!=1}
					<br /><font class="t12b">({$ENV._arrays.price_unit[$l.price_unit].s})</font>
				{/if}
			{else}
				{if intval($l.price) < floatval($l.price)}
					{$l.price|number_format:2:'.':' '} 
				{else}
					{$l.price|number_format:0:'':' '} 
				{/if}
				{if $l.price_unit!=1}
					<br /><font class="t12b">({$ENV._arrays.price_unit[$l.price_unit].s})</font>
				{/if}
			{/if}
		</td>
		{else}
			<td>-</td>
		{/if}
		<td>
		{if $l.area_build}
			{if intval($l.area_build) < floatval($l.area_build)}
				{$l.area_build|number_format:2:'.':' '} 
			{else}
				{$l.area_build|number_format:0:'':' '} 
			{/if}
		{/if}
		</td>
		<td>{if $ENV._arrays.regions[$l.region].s}{$ENV._arrays.regions[$l.region].s}{else}-{/if}</td>
		<td>{if $l.floor}{$l.floor}{else}-{/if}/{if $l.floors}{$l.floors}{else}-{/if}</td>
		<td>{$ENV._arrays.ipoteka[$l.ipoteka]}</td>		
	</tr>    
{/foreach}
</table>
{* Table list end*}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/>
{/if}