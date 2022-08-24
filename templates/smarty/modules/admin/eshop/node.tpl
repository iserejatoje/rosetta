<tr id="nc{$node->id}">
	<td {if $node->Level}style="padding-left: {$node->Level*20-20}px"{/if}>
		<a name="node{$node->id}" style="margin-top: -30px;position:absolute;"></a>
		
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$node->id}&treeid={$node->treeid}">{if $node->Title}{$node->Title}{else}н/з{/if}</a>
		{*if !$node->isLeaf()}
		
		{else}
		{if $node->Title}{$node->Title}{else}н/з{/if}
		{/if*} [{$node->ID}]
	</td>
	<td align="center">{$node->NameID}</td>
	<td align="center"><input type="text" name="order[{$node->id}]" value="{$node->Order}" style="width: 55px;text-align:center" /></td>
	<td align="center" bgcolor="#{if $node->isVisible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_visible_node&id={$node->id}&node={$node->parent->id}&treeid={$node->treeid}">{if $node->isVisible==1}Да{else}Нет{/if}</a></td>
	<td align="center" bgcolor="#{if $node->isAnnounce==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_announce_node&id={$node->id}&node={$node->parent->id}&treeid={$node->treeid}">{if $node->isAnnounce==1}Да{else}Нет{/if}</a></td>
	<td align="center" bgcolor="#{if $node->isJapan==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_japan_node&id={$node->id}&node={$node->parent->id}&treeid={$node->treeid}">{if $node->isJapan==1}Да{else}Нет{/if}</a></td>
	<td align="center" nowrap="nowrap">
		{assign var=_nodeid value=$node->id}
		[ <a href="?{$SECTION_ID_URL}&action=edit_node&node={$node->id}&treeid={$node->treeid}&parent={$nodeid}" title="Редактировать раздел">Редактировать</a> | <a href="javascript:;" onclick="createNode({$node->id})" title="Добавить подраздел">Добавить</a>
		 {*| <a href="?{$SECTION_ID_URL}&action=move_node&node={$node->id}&treeid={$node->treeid}">Перенести</a>*}
		{if $node->isLeaf()} | <a href="?{$SECTION_ID_URL}&action=products&node={$node->id}&treeid={$node->treeid}">Товары</a>{/if} ]
	</td>
	
	<td><input type="checkbox" name="ids_action[]" value="{$node->id}"/></td>
</tr>
{if $node->hasChildren() && $show_childs !== false}
{foreach from=$node->getChildNodes() item=node}
	{include file="eshop/node.tpl" node=$node}
{/foreach}
{/if}