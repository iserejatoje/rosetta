<div class="title2_news">{$page.Name}</div>
<br/>

<table class="table2" cellspacing="2" cellpadding="0" width="100%">
{if !empty($page.Price) && $page.Price!='0,00'}
	<tr>
		<td class="bg_color2" align="right" width="80" nowrap="nowrap">Цена:</td>
		<td align="left" width="100%">{$page.Price|replace:".":","} руб.</td>
	</tr>	
{/if}
<tr>
	<td class="bg_color2" align="right" width="80" nowrap="nowrap">Рубрика:</td></td>
	<td align="left" width="100%"><a href="/{$ENV.section}/{$page.RubricID}/1.php" title="Все предложения рубрики">{$page.Rubric}</a></td>
</tr>
<tr>
	<td class="bg_color2" align="right" width="80" nowrap="nowrap">Компания-продавец:</td></td>
	<td align="left" width="100%"><a href="/{$ENV.section}/firm/{$page.FirmID}/1.php" title="Все предложения компании">{$page.Company}</a></td>
</tr>
<tr>
	<td class="bg_color2" align="right" width="80">Контакты:</td></td>
	<td align="left" width="100%">{$page.Contacts|nl2br}</td>
</tr>
{*
{if $page.FirmUrl}
<tr>
	<td width="80"></td>
	<td align="left" width="100%"><a href="{$page.FirmUrl}">Подробнее о компании-продавце</a></td>
</tr>
{/if}
*}
{if $page.StatusID>0 && !empty($page.StatusName)}
	<tr>
		<td class="bg_color2" align="right" width="80" nowrap="nowrap">Статус имущества:</td>
		<td align="left" width="100%">
			{$page.StatusName}<br/>	
			<a href="/{$ENV.section}/status/{$page.StatusID}.php?url={$page.my_url}">Как купить</a>			
		</td>
	</tr>	
{/if}
</table>
<br/>

{$page.Description|nl2br}
<br/>
