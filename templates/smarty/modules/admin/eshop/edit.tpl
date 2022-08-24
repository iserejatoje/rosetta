{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/autocomplete/jquery.autocomplete.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.asmselect.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/ui/jquery.ui.js"></script>

<link rel="stylesheet" type="text/css" href="/resources/styles/jquery/autocomplete/jquery.autocomplete.css" />
<script>{literal}
var ready = true;
	function search()
	{
		if ($('#query').val().length == 0)
		{
			alert("Введите запрос для поиска");
			return false;
		}
	
		if (!ready)
		{
			alert("В данный момент происходит обработка, попробуйте позднее");
			return false;
		}
		ready = false;
		
		var query = $('#query').val();
		
		$('#finded_items').html("Идёт поиск...");
		
		$.ajax({
			url: '.',
			type: 'GET',
			dataType: 'json',
			data: {
				action: 'search_similar_ref',
				section_id: {/literal}{$SECTION_ID}{literal},
				q: query
			},
			success: searchComplete,
			error: searchError
		});
	}
	
	function addRef(event)
	{
		var id = event.data.id;
		var name = event.data.name;
		var price = event.data.price;
		var logo = event.data.logo;
		
		var className = 'selected_similar_'+id;
		
		var html = '<img src="'+logo+'" style="padding-right:10px;">'+$('.finded_'+id).text();
		
		var item = $('<li></li>')
				.attr('class', className)
				.css('padding-top', '3px')
				.html(html);
		
		var delete_item = $('<a></a>')
				.attr('href', 'javascript:void(0)')
				.html('<img src="/resources/img/themes/frameworks/jquery/treeview/bullet_delete.gif" title="Удалить связь" border="0"/>')
				.bind('click', {'className': className}, deleteRef);
		
		item.append(delete_item);
		item.append('<input type="hidden" name="similar_refs['+id+']" value="1"/>');
		$('#similar_refs').append(item);
		
		$('.finded_'+id).remove();
	}
	
	function deleteRef(event, className)
	{
		if (event != null)
			className = event.data.className;
			
		if ($('.'+className).size())
		{
			$('.'+className).remove();
		}
	}
	
	function searchComplete(data, textStatus)
	{
		ready = true;
		if (data.count == 0)
		{
			$('#finded_items').html('Продуктов не найдено. Попробуйте уточнить параметры поиска');
			return;
		}
		
		$('#finded_items').html('');
		var ol = $('<ol></ol>').css({
			'margin': '0px'
		});
		
		for(i in data.items)
		{
			var html = '<img src="'+data.items[i].logo.f+'" style="padding-right:10px;">'+data.items[i].name+' ('+data.items[i].price+' руб.)';
			var item = $('<li></li>')
				.attr('class', 'finded_'+data.items[i].id)
				.css('padding-top', '3px')
				.html(html);
			
			var add_item = $('<a></a>')
				.attr('href', 'javascript:void(0)')
				.html('<img src="/resources/img/themes/frameworks/jquery/treeview/bullet_add.gif" title="Добавить связь" border="0"/>')
				.bind('click', {
					'id': data.items[i].id,
					'name': data.items[i].name,
					'price': data.items[i].price,
					'logo': data.items[i].logo.f
					}, addRef);
			item.append('&nbsp;&nbsp;');
			item.append(add_item);
			ol.append(item);
		}
	
		$('#finded_items').append(ol);
	}
	
	function searchError(XMLHttpRequest, textStatus, errorThrown)
	{
		alert("Ошибка");
		ready = true;
	}
	
	function add_price_line()
	{
		$(".prices .prices-table").append($('.etalon table').html());
	}
	{/literal}
</script>

<style>
	{literal}
	.asmSelect {	
		display: none; 
	}	
	
	.asmContainer {
		/* container that surrounds entire asmSelect widget */
	}
	
	.asmOptionDisabled {
		/* disabled options in new select */
		color: #999; 
	}

	.asmHighlight {
		/* the highlight span */
		padding: 0;
		margin: 0 0 0 1em;
	}

	.asmList {
		/* html list that contains selected items */
		margin: 0.25em 0 1em 0; 
		position: relative;
		display: block;
		padding-left: 0; 
		list-style: none; 
	}

	.asmListItem {
		/* li item from the html list above */
		position: relative; 
		margin-left: 0;
		padding-left: 0;
		list-style: none;
		background: #ddd;
		border: 1px solid #bbb; 
		width: 100%; 
		margin: 0 0 -1px 0; 
		line-height: 1em;
	}

	.asmListItem:hover {
		background-color: #e5e5e5;
	}

	.asmListItemLabel {
		/* this is a span that surrounds the text in the item, except for the remove link */
		padding: 5px; 
		display: block;
	}

	.asmListSortable .asmListItemLabel {
		cursor: move; 
	}

	.asmListItemRemove {
		/* the remove link in each list item */
		position: absolute;
		right: 0; 
		top: 0;
		padding: 5px; 
	}

	{/literal}
</style>
<form id="cancel">
<input type="hidden" name="action" value="firms" />
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="node" value="{$parent}" />

{$SECTION_ID_FORM}

</form>
<p><b>
	{foreach from=$path item=p name=path}
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
		{if !$smarty.foreach.path.last} &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp; {/if}
	{/foreach}{if $place} &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp; {$place->Name}{/if}</b>
</p>



<form name="firmform" method="post" enctype="multipart/form-data" onsubmit="$('.etalon').remove()">
{$SECTION_ID_FORM}
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="parent" value="{$parent}" />

<table width="100%" cellspacing="1" cellpadding="2">
	{if $form.Created}
	<tr>
		<td bgcolor="#F0F0F0">Дата создания / редактирования</td>
		<td width="85%">{$form.Created} / {$form.LastUpdated}</td>
	</tr>
	{/if}	
	<tr>
		<td bgcolor="#F0F0F0">Показывать</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="IsVisible" value="1"{if $form.IsVisible==1} checked{/if}></td>
	</tr>

	<tr>
		<td bgcolor="#F0F0F0">Разливное (только для пива)</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="IsBottling" value="1"{if $form.IsBottling==1} checked{/if}></td>
	</tr>

	<tr>
		<td bgcolor="#F0F0F0">Хит</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="IsHit" value="1"{if $form.IsHit==1} checked{/if}></td>
	</tr>

	<tr>
		<td bgcolor="#F0F0F0">Мы рекомендуем</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="IsRecommend" value="1"{if $form.IsRecommend==1} checked{/if}></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('Sections') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Sections')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0" width="150">Рубрикатор</td>
		<td width="85%">
			<script> 
				var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}&treeid={$treeid}',
				{literal}
				{
					max_elements: 0,
					action: 'treenode'
				}
				{/literal});
				p.render_sections({$nodes});
				p.get_sections(0); 
			</script>
		</td>
	</tr>
	{if $UERROR->GetErrorByIndex('Name') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Name')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0" width="150">Название</td>
		<td width="85%"><input type="text" name="Name" value="{$form.Name}" class="input_100"></td>
	</tr>

	{if $UERROR->GetErrorByIndex('Weight') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Weight')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Вес/Объем/Кол-во<br/><small>Необходимо указывать измерение: гр., л., %<br/>(н-р.: 0.5л, 250гр, 4.7%)</small></td>
		<td width="85%"><input type="text" name="Weight" value="{$form.Weight}" class="input_100"></td>
	</tr>

	{if $UERROR->GetErrorByIndex('Calories') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Calories')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Калории</td>
		<td width="85%"><input type="text" name="Calories" value="{$form.Calories}" class="input_100"></td>
	</tr>		
	
	{*
	{if $UERROR->GetErrorByIndex('Manufacturer') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Manufacturer')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Производитель</td>
		<td width="85%">
			{if sizeof($manufacturers)}
			<select name="manufacturerid">
				<option value="0">- Производитель не указан -</option>
			{foreach from=$manufacturers item=m}
				<option value="{$m->ID}"{if $form.ManufacturerID == $m->ID} selected="selected"{/if}>{$m->Name}</option>
			{/foreach}
			</select>
			{else}
			Производители не указаны для раздела(ов)
			<input type="hidden" name="manufacturerid" value="0">
			{/if}
		</td>
	</tr>
	*}
	{if $UERROR->GetErrorByIndex('Composition') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Composition')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Состав</td>
		<td width="85%"><input type="text" name="Composition" value="{$form.Composition}" class="input_100"></td>
	</tr>
	{if $UERROR->GetErrorByIndex('Price') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Price')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Цена, руб.</td>
		<td width="85%"><input type="text" name="Price" value="{$form.Price}" class="input_100"></td>
	</tr>
	{if $UERROR->GetErrorByIndex('NewPrice') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('NewPrice')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Новая цена, руб.<br/><small>В списке выделяется красным</small></td>
		<td width="85%"><input type="text" name="NewPrice" value="{$form.NewPrice}" class="input_100"></td>
	</tr>
	{if $UERROR->GetErrorByIndex('Price') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Price')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Доп. цены (для пиццы), руб.</td>
		<td width="85%">
			<div class="prices">
				<table class="prices-table">
					<tr>
						<th>Диаметр</th>
						<th>Вес, гр</th>
						<th>Цена, руб.</th>
						<th></th>
					</tr>
					{foreach from=$form.prices item=p key=k}
					<tr>
						<td>
							<select name="PriceDiameter[]">
							{foreach from=$diameters item=d key=kk}
								<option value="{$kk}"{if $kk == $p.Diameter} selected="selected"{/if}>{$d}</option>
							{/foreach}
							</select>
							<input type="hidden" name="priceids[]" value="{$p.PriceID}" />
						</td>
						<td><input type="text" name="PriceWeight[]" value="{$p.Weight}"/></td>
						<td><input type="text" name="PricePrice[]" value="{$p.Price}"/></td>
						<td><a href="javascript:;" onclick="$(this).closest('tr').remove()">удалить</a></td>
					</tr>		
					{/foreach}
				</table>
				<div style="display: none"  class="etalon">
				<table>
					<tr>
						<td>
							<select name="PriceDiameter[]">
							{foreach from=$diameters item=p key=k}
								<option value="{$k}">{$p}</option>
							{/foreach}
							</select>
							<input type="hidden" name="priceids[]" value="0" />
						</td>
						<td><input type="text" name="PriceWeight[]" value=""/></td>
						<td><input type="text" name="PricePrice[]" value=""/></td>
						<td><a href="javascript:;" onclick="$(this).closest('tr').remove()">удалить</a></td>
					</tr>					
				</table>
				</div>
			</div>
			<a href="javascript:;" onclick="add_price_line()">добавить</a>
		</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Скидки НЕ действует на этот товар</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="WithoutDiscount" value="1"{if $form.WithoutDiscount==1} checked{/if}></td>
	</tr>
	{if $UERROR->GetErrorByIndex('Discount') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Discount')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Скидка</td>
		<td width="85%"><input type="text" name="Discount" value="{$form.Discount}" class="input_100"></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('Code') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Code')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Артикул</td>
		<td width="85%"><input type="text" name="Code" value="{$form.Code}" class="input_100"></td>
	</tr>
	{if $UERROR->GetErrorByIndex('Quantity') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Quantity')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Количество товаров в наличии</td>
		<td width="85%"><input type="text" name="Quantity" value="{$form.Quantity}" class="input_100"></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('Status') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Status')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Статус товара</td>
		<td width="85%">
			<select name="Status">
			{foreach from=$statuses item=p key=status}
				<option value="{$status}"{if $form.Status == $status} selected="selected"{/if}>{$p}</option>
			{/foreach}
			</select>
		</td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('logo_small') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('logo_small')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Фото - каталог<br/><small>(225px × 225px)</small></td>
		<td width="85%">
			{if !empty($form.LogotypeSmall.f)}
			<br><img src="{$form.LogotypeSmall.f}">
			<input type="checkbox" name="del_logotypesmall" value="1"/> удалить
			{/if}
			<input type="file" name="logotypesmall" value="" class="input_100">
		</td>
	</tr>

	{if $UERROR->GetErrorByIndex('logo_big') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('logo_big')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Фото - товар<br/><small>(451px × 375px)</small></td>
		<td width="85%">
			{if !empty($form.LogotypeBig.f)}
			<br><img src="{$form.LogotypeBig.f}">
			<input type="checkbox" name="del_logotypebig" value="1"/> удалить
			{/if}
			<input type="file" name="logotypebig" value="" class="input_100">
		</td>
	</tr>
	{if $UERROR->GetErrorByIndex('photo') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('photo')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Фото каталог при наведении<br/><small>(225px × 225px)</small></td>
		<td width="85%">
			{if !empty($form.Photo.f)}
			<br><img src="{$form.Photo.f}">
			<input type="checkbox" name="del_photo" value="1"/> удалить
			{/if}
			<input type="file" name="photo" value="" class="input_100">
		</td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('AnnounceText') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('AnnounceText')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Краткий анонс</td>
		<td width="85%"><textarea name="AnnounceText" style="height:100px;width:100%">{$form.AnnounceText}</textarea></td>
	</tr>
	{if $UERROR->GetErrorByIndex('Info') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Info')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Описание</td>
		<td width="85%"><textarea name="Info" style="height:300px;" class="mceEditor input_100">{$form.Info}</textarea></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('similar') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('similar')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Похожие товары</td>
		<td width="85%">
			<br/>
				<fieldset>
					<legend>Выбранные похожие товары</legend>
					<div>
						<ul id="similar_refs">
						{if count($form.similarrefs) > 0}
							{foreach from=$form.similarrefs item=l key=id}
							<li class="selected_similar_{$l.id}" style="padding-top: 3px;">
								<img src="{$l.logo.f}" style="padding-right:10px;"/>{$l.name} ({$l.price}руб.)&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteRef(null, 'selected_similar_{$l.id}')"><img src="/resources/img/themes/frameworks/jquery/treeview/bullet_delete.gif" title="Удалить связь" border="0"/></a>
								<input type="hidden" name="similar_refs[{$l.id}]" value="1"/>
							</li>
							{/foreach}
						{/if}
						</ul>
					</div>
				</fieldset>
				<br/>
			
				<small>
					В строку поиска можно добавлять идентификаторы продуктов или ссылки на них, содержащие идентификаторы (из запроса вырезаются все символы, кроме цифр):<br/>
					Примеры правильных запросов:<br/>
					1) 145785, 1452335, 566697<br/>
					2) http://<ваш_домен>/eshop/child/toddlers/clothes/bodie/13.html
				</small><br/>
				<input type="text" id="query" value="" style="width:60%">&nbsp;<input id="search_button" type="button" onclick="search()" value="Найти" /><br/>
				<br/>
				<div id="finded_items"></div>
		</td>
	</tr>
</table>
<center><br><input type="submit" value="Сохранить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
<script type="text/javascript" language="javascript">
  {$UERROR->SetFocusToError()}
</script>
</form>
{/if}