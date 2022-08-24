{if $BLOCKS.header[0]}
{$BLOCKS.header[0]}
{else}
{include file="design/200608_title/common/header.tpl"}
{/if}
<tr>
	<td valign="top" style="height:100%;">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
	{if !empty($TEMPLATE.left)}
		<td style="width:220px">{include file="`$TEMPLATE.left`"}</td>
	{/if}
                <td style="width:10px">{*<img src="/_img/x.gif" width="10" height="1" border="0" />*}</td>
	<td{*{if $__page_cols>1} colspan="{$__page_cols}"{/if}*} id="block_center" >&nbsp;


	{if in_array($CURRENT_ENV.section, array('newsline_dom','articles','hints','design','realty','expert'))}
		{banner_v2 id="3842"}
	{elseif in_array($CURRENT_ENV.section, array('newsline_auto','autostop','photoreport','instructor','pdd'))}
		{banner_v2 id="3896"}
	{elseif in_array($CURRENT_ENV.section, array('newsline_fin','tech','skills','news_fin','predict'))}
		{banner_v2 id="3973"}
	{elseif in_array($CURRENT_ENV.section, array('weekfilm','wedding','starspeak','travel','inspect'))}
		{banner_v2 id="3939"}
	{/if}

	{if is_array($BLOCKS.others)}<br />{foreach from=$BLOCKS.others item=block }{$block}{/foreach}{/if}

	{if !empty($BLOCKS.section_title)}{foreach from=$BLOCKS.section_title item=block }{$block}{/foreach}{/if}
	
    {if isset($TEMPLATE.section) && $TEMPLATE.section != ''}
		{include file="`$TEMPLATE.section`"}
	{/if}

	{foreach from=$BLOCKS.main item=block }{$block}{/foreach}<br/>

				{if $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.regdomain`/common/block_under_service_main.tpl")}
					{include file="design/199801_title_main/`$CURRENT_ENV.site.regdomain`/common/block_under_service_main.tpl"}
				{else}
					{* меню по умолчанию *}
					{include file="design/200608_title/common/block_under_service_main.tpl"}
				{/if}
				

	</td>
                <td style="width:10px">{*<img src="/_img/x.gif" width="10" height="1" border="0" />*}</td>
	{if !empty($TEMPLATE.right)}
		<td style="width:220px">{include file="`$TEMPLATE.right`"}</td>
	{/if}
	</tr>
	</table>
	</td>
</tr>
{if isset($BLOCKS.footer[0])}
{$BLOCKS.footer[0]}
{else}
{include file="design/200608_title/common/footer.tpl"}
{/if}