
{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

<style>{literal}
	TR:hover {
		background-color: #cadbff;
	}
{/literal}</style>
	<p><b>
		{foreach from=$path item=p name=path}
			
			{if !$smarty.foreach.path.last}
			<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
			{else}
			<a href="?{$SECTION_ID_URL}&action=firms&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
			{/if}
			{if !$smarty.foreach.path.last}&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;{/if}
		{/foreach}</b>
	</p>
	
	{if isset($node) && $node->isLeaf()}<p><a href="?{$SECTION_ID_URL}&action=new_product&parent={$node->id}&treeid={$node->treeid}">Добавить товар</a></p>{/if}
	
	{capture name=pages}
		{if count($pages.btn) > 0}
		{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
		{foreach from=$pages.btn item=l}
		{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
		{/foreach}
		{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
		{/if}
	{/capture}

	<script>{literal}
	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	}
	{/literal}</script>
<form method="post" onsubmit="return checkaction();">
	{$SECTION_ID_FORM}
	<table width="100%">
		<tr>
			<th width="6%">Фото</th>	
			<th width="20%">Название</th>	
			<th width="13%">Производитель</th>	
			<th width="13%">Вес/Объем/%</th>	
			<th width="13%">Калории</th>	
			<th width="13%">Цена</th>	
			<th width="50">Позиция</th>
			<th width="50">Сорт.</th>
			<th width="30">Видимость</th>
			<th width="30"></th>			
			<th width="1"></th>
		</tr>
	
		{excycle values="#FFFFFF,#F0F0F0"}
		{if is_array($list) && sizeof($list) > 0}
			{foreach from=$list item=l}
			<tr bgcolor="{excycle}">
				<td align="center">
					{if $l.LogotypeSmall !== null}
					<a href="?{$SECTION_ID_URL}&action=edit_product&parent={$node->ID}&id={$l.ProductID}&treeid={$node->treeid}">
						<img src="{$l.LogotypeSmall.f}" style="border:none;"/>
					</a>
					{/if}
				</td>
				<td width="300">
					<a href="?{$SECTION_ID_URL}&action=edit_product&parent={$node->ID}&id={$l.ProductID}&treeid={$node->treeid}">{if $l.Name}{$l.Name}{else}н/з{/if}</a>
					<br/><small>{$l.Created} / {$l.LastUpdated}</small>
				</td>	
				<td align="center">{$l.Manufacturer}</td>
				<td align="center">{$l.Weight}</td>
				<td align="center">{$l.Calories}</td>
				<td align="center">{if $l.NewPrice > 0}{$l.NewPrice}&nbsp;<span style="text-decoration:line-through;color:#898989;">{/if}{$l.Price}{if $l.NewPrice > 0}</span>{/if}</td>
				<td align="center">
					<input type="text" name="ord[{$l.ProductID}]" value="{$l.Ord}" class="input_100" style="width:50px;text-align:center">
				</td>
				<td align="center">
					<a href="?{$SECTION_ID_URL}&action=product_ord_up&parent={$node->ID}&id={$l.ProductID}&treeid={$node->treeid}" title="поднять"><img src="/resources/img/up.gif" style="border-style:none;"></a>	
					<a href="?{$SECTION_ID_URL}&action=product_ord_down&parent={$node->ID}&id={$l.ProductID}&treeid={$node->treeid}" title="опустить"><img src="/resources/img/down.gif" style="border-style:none;"></a>
				</td>
				<td align="center" bgcolor="#{if $l.IsVisible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_content_visible&node={$node->ID}&treeid={$node->treeid}&id={$l.ProductID}">{if $l.IsVisible==1}Да{else}Нет{/if}</a></td>				
				<td align="center">
					<a href="?{$SECTION_ID_URL}&action=photos&parent={$node->ID}&id={$l.ProductID}&treeid={$node->treeid}">фотографии</a>
				</td>
				<td>
					<input type="checkbox" name="ids_action[]" value="{$l.ProductID}"/>
				</td>
			</tr>
			{/foreach}
		{/if}
	
	</table><br />
	
	<center>{$smarty.capture.pages}</center><br />
	
	<div align="right"><nobr>
		<select name="action" id="action">
			<option value="products_update">Обновить товары</option>
			<option value="products_delete">Удалить товары</option>
			<option value="products_hide">Скрыть товары</option>
			<option value="products_show">Показать товары</option>
		</select>
		<input type="submit" value="Ок" />
		</nobr>
	</div>
</form>
	
{/if}

