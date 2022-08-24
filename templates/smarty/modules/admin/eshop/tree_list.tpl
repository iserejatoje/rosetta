<form name="treeList" action="" method="post">

<p><a href="?{$SECTION_ID_URL}&action=new_tree">Добавить каталог</a></p>

<table border="1" class="dTable" width="100%">
	<tr>
		<th>#</th>
		<th title="Название каталога" width="100%">Название</th>
		<th title="Редактировать">Ред.</th>
		<th title="Количество рубрик в каталоге"> </th>
		<th> </th>
	</tr>
	{foreach from=$treeList item=node}
	{assign var=treeid value=$node->treeid}
	<tr {if $sectionList[$treeid] === null} title="Каталог не закреплен за разделом"{/if}>
		<td align="center">{$node->ID}</td>
		<td>
			{if $sectionList[$treeid] === null}
				<a href="?{$SECTION_ID_URL}&action=catalog&treeid={$node->treeid}" title="Перейти к каталогу" {if $sectionList[$treeid] === null}style="color:red;"{/if}><b>{$node->Title}</b></a>
			{else}
				<a href="?{$SECTION_ID_URL}&action=catalog&treeid={$node->treeid}" title="Перейти к каталогу">{if $node->Title}{$node->Title}{else}н/з{/if}</a>
			{/if}
		</td>
		<td align="center">
			[ <a href="?{$SECTION_ID_URL}&action=edit_tree&treeid={$node->treeid}" title="Редактировать">Редактировать</a> ]
		</td>
		<td align="center">
			{$node->childscount|number_format:'':'':' '}
		</td>
		<td><input type="checkbox" name="ids_action[]" value="{$node->treeid}"/></td>
	</tr>
	{/foreach}
</table>
<br/>
<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="tree_delete">Удалить каталог</option>
	</select>
	<input type="submit" value="Ок" />
</nobr></div>

</form>