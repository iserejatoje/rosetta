<table width="100%" cellpadding="0" cellspacing="0" border="0" class="block_title">
        <tr>
		<td><span>{$BLOCK.title}</span></td>
        </tr>
</tr>
</table>

{if $CURRENT_ENV.section == 'commerce'}
	{assign var=sec_id value=1}
{elseif $CURRENT_ENV.section == 'sale'}
	{assign var=sec_id value=2}
{elseif $CURRENT_ENV.section == 'rent'}
	{assign var=sec_id value=3}
{elseif $CURRENT_ENV.section == 'change'}
	{assign var=sec_id value=4}
{else}
	{assign var=sec_id value=0}
{/if}

<table width="100%" cellspacing="3" class="table" bgcolor="#EDF6F8" border="0">
	<tr{if $sec_id == 1} class="bg_color_white"{/if}>
		<td class="block_menu">
			{if $sec_id != 1}<a href="http://{$ENV.site.domain}/commerce/">{else}<b>{/if}Коммерческая{if $sec_id != 1}</a>{else}</b>{/if} ({$BLOCK.res.commerce.count[0][0][0]|number_format:"0":",":" "})
		</td>
	</tr>
	<tr{if $sec_id == 2} class="bg_color_white"{/if}>
		<td class="block_menu">
			{if $sec_id != 2}<a href="http://{$ENV.site.domain}/sale/">{else}<b>{/if}Продажа-покупка жилья{if $sec_id != 2}</a>{else}</b>{/if} ({$BLOCK.res.sale.count[0][0][0]|number_format:"0":",":" "})
		</td>
	</tr>
	<tr{if $sec_id == 3} class="bg_color_white"{/if}>
		<td class="block_menu">
			{if $sec_id != 3}<a href="http://{$ENV.site.domain}/rent/">{else}<b>{/if}Аренда жилья{if $sec_id != 3}</a>{else}</b>{/if} ({$BLOCK.res.rent.count[0][0][0]|number_format:"0":",":" "})
		</td>
	</tr>
	<tr{if $sec_id == 4} class="bg_color_white"{/if}>
		<td class="block_menu">
			{if $sec_id != 4}<a href="http://{$ENV.site.domain}/change/">{else}<b>{/if}Обмен жилья{if $sec_id != 4}</a>{else}</b>{/if} ({$BLOCK.res.change.count[0][0][0]|number_format:"0":",":" "})
		</td>
	</tr>
	{if in_array($CURRENT_ENV.regid,array(45,56,76))}
	<tr>
		<td class="block_menu">
			<a href="http://{$ENV.site.domain}/users/agency.html">Предложения компаний</a>
		</td>
	</tr>
	{/if}
	<tr>
		<td class="otzyv" align="right" colspan="2">
			<a href="http://{$ENV.site.domain}/sale/add.html" style="color:red">Добавить объявление</a>
		</td>
	</tr>
</table>