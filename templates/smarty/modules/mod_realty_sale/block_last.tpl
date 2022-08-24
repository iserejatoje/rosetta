{if $BLOCK.res.user_id == $USER->ID || $BLOCK.res.count>0}
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td colspan="5" class="bg_color2"><b>{$BLOCK.title}</b></td>
	</tr>
	<tr>
		<td align=left>Всего объявлений: {$BLOCK.res.count|number_format:0:".":" "}</td>
	</tr>
	<tr>
		<td align="100%">
		{if is_array($BLOCK.res.list) && sizeof($BLOCK.res.list)}
			<table width="100%" cellspacing="1" border="0" class="table2">
				<tr valign=middle>
					<th width="40">#</th>
					<th width="60">Дата</th>
					{*<th width=100>Рубрика</th>*}
					<th>Адрес</th>
					<th width="180">Тип</th>
					<th width="60">Цена<br />(тыс.руб.)</th>
					<th width="55">Площадь<br />(кв.м.)</th>
					<th width="120">Район</th>
					<th width="40">Этаж</th>
					<th width="40">Ипотека</th>
				</tr>
				{foreach from=$BLOCK.res.list item=row key=key}
				<tr class="{if $key % 2}bg_color4{/if}" align=left>
					<td align="center">
						{if $BLOCK.res.user_id == $USER->ID}
						<a href="/{$BLOCK.section}/edit.html?id={$row.id}">
						{else}
						<a href="/{$ENV.section}/details.html?id={$row.id}">
						{/if}
						{$row.id}
						</a>
					</td>
					<td align="center">
						<span class="s3">{$row.date_start|simply_date:"%f":"%d-%m"}</span><br />{$row.date_start|date_format:"%H:%M"}{* "H:i"|date:$row.date_start *}
					</td>
					{*<td align="center">{if $row.rub}{$row.rub}{else}-{/if}</td>*}
					<td align="left">
					{if $BLOCK.res.user_id == $USER->ID}
					<a href="/{$BLOCK.section}/edit.html?id={$row.id}">
					{else}
					<a href="/{$ENV.section}/details.html?id={$row.id}">
					{/if}
					{if $row.address}{$row.address}{else}-{/if}</a>
					</td>
					<td align="center"><b>{if $row.object}{$row.object}{else}-{/if}</b></td>
					{if $row.price > 0}
					<td align="center">
						{if intval($row.price) < floatval($row.price)}
							{$row.price|number_format:2:'.':' '} 
						{else}
							{$row.price|number_format:0:'':' '} 
						{/if}
						{if $row.price_unit!=1}
							<br /><font class="small">({$ENV._arrays.price_unit[$row.price_unit].s})</font>
						{/if}
					</td>
					{else}
						<td align="center">-</td>
					{/if}
					<td align="center">
					{if $row.area_build}
						{if intval($row.area_build) < floatval($row.area_build)}
							{$row.area_build|number_format:2:'.':' '} 
						{else}
							{$row.area_build|number_format:0:'':' '} 
						{/if}
					{/if}
					</td>					
					<td align="center">{if $row.region}{$row.region}{else}-{/if}</td>
					<td align="center">{if $row.floor}{$row.floor}{else}-{/if}/{if $row.floors}{$row.floors}{else}-{/if}</td>
					<td align="center">{$ENV._arrays.ipoteka[$row.ipoteka]}</td>
				</tr>
				{/foreach}
			</table>
		{/if}
		</td>		
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		{if $BLOCK.res.user_id == $USER->ID}
		<td nowrap="nowrap"><a href="/{$BLOCK.section}/add.html">Добавить объявлениие</a>&nbsp;&nbsp;</td>
		{/if}
		{if is_array($BLOCK.res.list) && sizeof($BLOCK.res.list)}
		<td nowrap="nowrap"><a href="/{$BLOCK.res.section}/{$ENV.section}.html{if $BLOCK.res.user_id != $USER->ID}?id={$BLOCK.res.user_id}{/if}">Полный список</a>&nbsp;&nbsp;</td>
		{/if}
		{if $BLOCK.res.user_id == $USER->ID}
		<td nowrap="nowrap"><a href="/{$BLOCK.res.section}/{$ENV.section}/favorites.php">Избранное {$BLOCK.res.count_favorites|number_format:0:".":" "}</a>&nbsp;&nbsp;</td>
		{/if}
		<td width="100%"></td>
	</tr>
</table>
<br /><br />
{/if}