<table align="center" width="100%" CELLPADDING="0" CELLSPACING="0" BORDER="0">
<tr><td height="10"></td></tr>
<tr><td>
	<table border="0" cellspacing="0" cellpadding="0" width="95%">
	<tr valign="top">
		<td align="left" class="title">{$res.text.details.arrays.brand[$res.text.details.brand].name} {$res.text.details.name}</td>
		<td width="140" align="center"><div title="{php}echo UserError::GetError(ERR_M_CATALOG_AVERAGE_PRICE);{/php}" style="font-weight: bold;">{if $res.text.details.price>0}{$res.text.details.price|number_format:0:".":" "} руб.<font color="red"><b>*</b></font>{/if}</div></td>
		<td width="120" align="left" class="smalltext">
			<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:2px">
			<tr><td>Рейтинг: <b>{$res.text.details.rating|number_format:1:".":" "}</b></td></tr>
			<tr><td>{$res.text.details.rating_bar}</td></tr>
			</table>
		{*<a href="#addcomment" onclick="OnCounterClick(14);">Проголосовать!</a>*}
		</td>
		<td width="130">
			<table cellspacing="0" cellpadding="1">
			<tr>
				<td class="tip"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" />&nbsp;<a href="{$CONFIG.sale_link.1}">Купить</a>&nbsp;/&nbsp;<a href="{$CONFIG.sale_link.2}">продать</a> б/у</td>
			</tr>
			<tr>
				<td class="tip"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" />&nbsp;<a href="/firms/s_208/">Где купить новый</a></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</td></tr>
<tr><td height="10"></td></tr>


{*
========================

GALLERY

========================
*}


<tr><td align="center">
{if count($res.gallery.list)}

<script language="JavaScript">
<!--{literal}
	// current huge photo
	var mod_catalog_photo_current="{/literal}{$smarty.get.photo}{literal}";
	var mod_catalog_photo_loaded;
	var mod_catalog_photo_huge=false;
	var mod_catalog_photo_huge_waiting=false;

	// init variables
	function mod_catalog_gallery_init()
	{
		// huge photo
		mod_catalog_photo_huge = document.getElementById("mod_catalog_iphoto_huge");
		// text for waiting
		mod_catalog_photo_huge_waiting = document.getElementById("mod_catalog_iphoto_huge_waiting");
	}
{/literal}//-->
</script>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
		<td width="400">
	<!-- Image View: start -->
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr><td class="tip" align="center"><span id="mod_catalog_iphoto_huge_waiting"></span></td></tr>
	{assign var=l value="`$res.gallery.list[$smarty.get.photo]`"}
	{if !empty($l.img2.url)}
	<tr><td align="center"><img id="mod_catalog_iphoto_huge" src="{$l.img2.url}" width="{$l.img2.w}" height="{$l.img2.h}" border="0" alt="{$l.img2.name|escape:"quotes"}"></td></tr>
	{/if}
	</table>
	<!-- Image View: end -->
		</td>
		<td>
	<!-- Image thumb: start -->
	<table border="0" cellspacing="0" cellpadding="2">
{assign var="cols_item" value="3"}
{math equation="floor(100/x)" x=$cols_item assign="cols_item_width"}
{assign var="cur_col" value=1}
{foreach from=$res.gallery.list item=l key=k}
	{if $cur_col==1}
		<tr valign="middle" align="center">
	{/if}

	<td>
	{if !empty($l.img1.url)}
		<table border="0" cellspacing="0" cellpadding="3">
		<tr><td id="mod_catalog_gal_{$k}"{if $smarty.get.photo==$k} class="bg_color2"{/if}>
		{if $l.img2.url}
		<a href="/{$ENV.section}/{$res.text.details.item_id}.html?photo={$k}{if $res.gallery.url_params_photo}&{$res.gallery.url_params_photo}{/if}"
		 onclick="return mod_catalog_showphoto({$k},{$l.img2.w},{$l.img2.h},'{$l.img2.url}');"
		 >{/if}
		 
		 <img
		  src="{$l.img1.url}" id="mod_catalog_photo_small_{$k}" width="{$l.img1.w}" height="{$l.img1.h}" border="0"
		  alt="{$l.img1.name|escape:"quotes"}">
		  
		  {if $l.img2.url}</a>{/if}</td></tr>
		</table>
	{/if}
	</td>

	{assign var="cur_col" value="`$cur_col+1`"}
	{if $cur_col > $cols_item}
		</tr>
		<tr><td height="10px"></td></tr>
		{assign var="cur_col" value=1}
	{/if}
{/foreach}

	</table>
<script type="text/javascript" language="javascript">
<!--
mod_catalog_gallery_init();
//-->
</script> 
	<!-- Image thumb: end -->
		</td>
	</tr>
	</table>

{/if}

</td></tr>
<tr><td height="10"></td></tr>

{if $res.text.details.price}
<tr><td align="center"><font color="red"><b>*</b></font> {php}echo UserError::GetError(ERR_M_CATALOG_AVERAGE_PRICE);{/php}</td></tr>
{/if}
<tr><td height="10"></td></tr>


{*
========================

PROPERTY

========================
*}
<tr><td>

{if count($res.treedata)>0}
<table align="center" width="90%" cellpadding="3" cellspacing="2" border="0">
{foreach from=$res.treedata item=cur key=k}
{if $cur.data.visible==1}
{assign var="k" value="p`$cur.id`"}
{if $cur.data.type==1}
<tr class="bg_color2" align="center">
	<td colspan="2"><b>{$cur.data.name}</b></td>
</tr>
{else}

{assign var=cur_val value="`$res.text.details.$k`"}
{if $cur.data.ftype=="select"}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{assign var=cur_arr value="`$res.text.details.arrays[$k]`"}
	{$cur.data.params.prefix}{$cur_arr[$cur_val].name}{$cur.data.params.postfix}
	</td>
</tr>
{elseif $cur.data.ftype=="checkbox"}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{if $cur_val}+{else}-{/if}{$cur.data.params.postfix}
	</td>
</tr>
{elseif $cur.data.ftype=="image"}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{if $cur_val.file}
		{$cur.data.params.prefix}<img src="{$CONFIG.images_url}{$cur_val.file}" width="{$cur_val.w}" height="{$cur_val.h}" border="0" />{$cur.data.params.postfix}
	{/if}
	</td>
</tr>
{elseif $cur.data.ftype=="text"}
{if $cur_val!=""}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val|escape:"html"}{$cur.data.params.postfix}
	</td>
</tr>
{/if}
{elseif $cur.data.ftype=="string"}
{if $cur_val!=""}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val|escape:"html"}{$cur.data.params.postfix}
	</td>
</tr>
{/if}
{elseif $cur.data.ftype=="datetime"}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val}{$cur.data.params.postfix}
	</td>
</tr>
{elseif $cur.data.ftype=="date"}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val}{$cur.data.params.postfix}
	</td>
</tr>
{elseif $cur.data.ftype=="number"}
{if $cur_val>0}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val}{$cur.data.params.postfix}
	</td>
</tr>
{/if}
{elseif $cur.data.ftype=="float"}
{if $cur_val>0}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val|number_format:$cur.data.params.precision:".":" "}{$cur.data.params.postfix}
	</td>
</tr>
{/if}
{else}
{if $cur_val}
<tr class="{cycle values=",bg_color4"}">
	<td align="right" width=200px>{$cur.data.name}:</td>
	<td>
	{$cur.data.params.prefix}{$cur_val}{$cur.data.params.postfix}
	</td>
</tr>
{/if}
{/if}
{/if}
{/if}
{/foreach}
</table>
{/if}

</td></tr>


<tr><td height="10"></td></tr>

</table>