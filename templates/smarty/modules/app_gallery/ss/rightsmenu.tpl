<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td>Показывать:&nbsp;</td>
<td>
	{assign var="offset" value="-4"}
	{assign var="calc_offset" value="1"}
	{capture name="list"}
		{foreach from=$rights key=k item=l name=list}
			<div style="padding:2px"><a href="javascript:void(0);" onclick="app_gallery.setType('{$url}', '{$k}', 'rightname', 'rightsmenu',{$smarty.foreach.list.iteration});">{$l|replace:" ":"&nbsp;"}</a></div>
			{if $calc_offset==1 && $k!=$right}
				{php}
					$this->_tpl_vars['offset'] -= 18;
				{/php}
			{else}
				{assign var="calc_offset" value="0"}
			{/if}
		{/foreach}
	{/capture}
	<div id="rightsmenu" class="bg_color2" style="display:none; position:absolute; width:auto; height:auto; padding:2px; margin-left:-1px; margin-top:{$offset}; border: solid 1px #00468C;z-index:1;">
	{$smarty.capture.list}
	</div>
	<a href="javascript:void(0);" onclick="app_gallery.showMenu(true, 'rightsmenu');" id="rightname">{$rights[$right]}</a>
</td>
</tr>
</table>