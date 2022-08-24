
{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

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
	
	<p><a href="?{$SECTION_ID_URL}&action=new_photo&parent={$parent}&treeid={$treeid}&productid={$product->ID}">Добавить фотографию</a></p>
	
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
			<th width="10%">Фото</th>	
			<th width="90%">Название</th>				
			<th width="30">Видимость</th>
			<th width="1"></th>
		</tr>
	
		{excycle values="#FFFFFF,#F0F0F0"}
		{if is_array($list) && sizeof($list) > 0}
			{foreach from=$list item=l}
			<tr bgcolor="{excycle}">
				<td align="center">
					{if $l->PhotoSmall !== null}
					<a href="?{$SECTION_ID_URL}&action=edit_photo&parent={$parent}&treeid={$treeid}&productid={$product->ID}photoid={$l->ID}">
						<img src="{$l->PhotoSmall.f}" width="{$l->PhotoSmall.h}" height="{$l->PhotoSmall.h}" style="border:none;"/>
					</a>
					{/if}
				</td>
				<td width="300">
					<a href="?{$SECTION_ID_URL}&action=edit_photo&parent={$parent}&treeid={$treeid}&productid={$product->ID}&photoid={$l->ID}">{if $l->Name}{$l->Name}{else}н/з{/if}</a>
				</td>								
				<td align="center" bgcolor="#{if $l->IsVisible==1}66FF66{else}FF6666{/if}">
					<a href="?{$SECTION_ID_URL}&action=toggle_photo_visible&node={$node->ID}&treeid={$node->treeid}&id={$l->ProductID}">{if $l->IsVisible==1}Да{else}Нет{/if}</a>
				</td>
				<td>
					<input type="checkbox" name="ids_action[]" value="{$l->ProductID}"/>
				</td>
			</tr>
			{/foreach}
		{/if}
	
	</table><br />
	
	<center>{$smarty.capture.pages}</center><br />
	
	<div align="right"><nobr>
		<select name="action" id="action">
			<option value="photos_delete">Удалить фотографии</option>
		</select>
		<input type="submit" value="Ок" />
		</nobr>
	</div>
</form>
	
{/if}

