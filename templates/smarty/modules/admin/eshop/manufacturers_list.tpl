
{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

	
	<p><a href="?{$SECTION_ID_URL}&action=new_manufacturer&treeid={$treeid}">Добавить производителя</a></p>
	
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
	<table width="100%" border=1>
		<tr>
			<th width="10%">Логотип</th>
			<th width="90%">Название</th>
			<th width="1"></th>
		</tr>
	
		{excycle values="#FFFFFF,#F0F0F0"}
		{if is_array($list) && sizeof($list) > 0}
			{foreach from=$list item=l}
			<tr bgcolor="{excycle}">
				<td align="center">
					{if $l->Icon !== null}
					<a href="?{$SECTION_ID_URL}&action=edit_manufacturer&treeid={$treeid}&manufacturerid={$l->ID}">
						<img src="{$l->Icon.f}" width="{$l->Icon.h}" height="{$l->Icon.h}" style="border:none;"/>
					</a>
					{else}
					нет логотипа
					{/if}
				</td>
				<td width="300">
					<a href="?{$SECTION_ID_URL}&action=edit_manufacturer&treeid={$treeid}&manufacturerid={$l->ID}">{if $l->Name}{$l->Name}{else}н/з{/if}</a>
				</td>
				<td>
					<input type="checkbox" name="ids_action[]" value="{$l->ID}"/>
				</td>
			</tr>
			{/foreach}
		{/if}
	
	</table><br />
	
	<center>{$smarty.capture.pages}</center><br />
	
	<div align="right"><nobr>
		<select name="action" id="action">
			<option value="manufacturer_delete">Удалить производителей</option>
		</select>
		<input type="submit" value="Ок" />
		</nobr>
	</div>
</form>
	
{/if}

