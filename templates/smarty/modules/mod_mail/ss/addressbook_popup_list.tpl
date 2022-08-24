{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы: 
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}



<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<form name="mod_mail_addressbook_form" id="mod_mail_addressbook_popup_form" method="post">
<input type="hidden" name="action" value="">
<tr align="left">
	<th width="20px" style="padding:0px; padding-left:3px;"><input type="checkbox" id="mainch" ></th>
	<th width="33%"><a href="?sf=nick&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">Ник{if $smarty.get.sf=='nick'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="33%"><a href="?sf=name&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">ФИО{if $smarty.get.sf=='name'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="33%"><a href="?sf=email&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">Email{if $smarty.get.sf=='email'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
</tr>
{if count($res.list)>0}
{foreach from=$res.list item=l key=k}
{capture assign="value"}{strip}
	{if $l.nick!=""}
		{$l.nick|escape:"html"} <{$l.email}>
	{elseif $l.firstname!="" || $l.midname!="" || $l.midname!=""}
		{$l.lastname|escape:"html"}{if $l.firstname} {$l.firstname|escape:"html"}{/if}{if $l.midname} {$l.midname|escape:"html"}{/if} <{$l.email}>
	{else}
		{$l.email|escape:"html"}
	{/if}
{/strip}{/capture}
<tr align="left" valign="top" id="tr{$k}">
	<td align="center"><input type="checkbox" id="ch{$k}" value="{$value|escape:"quotes"}" name="ch[{$l.id}]"{if $l.checked} checked{/if} ></td>
	<td>{$l.nick|escape:"html"}</td>
	<td>{$l.lastname|escape:"html"}{if $l.firstname} {$l.firstname|escape:"html"}{/if}{if $l.midname} {$l.midname|escape:"html"}{/if}</td>
	<td>{$l.email|escape:"html"}</td>
</tr>
{/foreach}
{else}
<tr align="center">
	<td colspan="6">Пусто</td>
</tr>
{/if}
</table>


{if $smarty.capture.pageslink!="" }
<br />
{$smarty.capture.pageslink}
<br />
{/if}


<table cellpadding="0" cellspacing="0" border="0">
<tr>
{if count($res.list)>0}
	<td width="80px">
	<button onclick="mod_mail_addressbook_popup_form_action(); return false;" style="width:70px;">Вставить</button>
	</td>
{/if}
	<td width="80px">
	<button onclick="window.close();" style="width:70px;">Закрыть</button>
	</td>
</tr>
</form>
</table>

<br/>

{if $smarty.capture.pageslink!="" }
{$smarty.capture.pageslink}
{/if}

<script type="text/javascript" language="javascript" src="/_scripts/themes/lines.js"></script>
<script type="text/javascript" language="javascript">
<!--
{literal}
lines_params.start = 0;
lines_params.end = {/literal}{$res.i-1|default:0}{literal},
lines_params.tr = 'tr';
lines_params.ch = 'ch';
lines_params.mainch = 'mainch';
lines_params.nobubble = [];
lines_class.over = 'lines_over';
lines_class.normal = '';
lines_class.selected = 'lines_selected';
lines_init();
{/literal}
//-->
</script>
<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_addressbook_popup_form = document.getElementById('mod_mail_addressbook_popup_form');
	var mod_mail_address_popup_col = {/literal}{$res.i|default:0}{literal};
	var mod_mail_address_popup_start = 0;

	function mod_mail_addressbook_popup_form_action()
	{
		var str = '';
		
		var mod_mail_address_popup_field = 'to';
		var arr = document.URL.split('?');
		if(arr.length>0)
		{
			var arr1 = arr[1].split('&');
			for(var i = 0; i<arr1.length; i++)
				if(arr1[i].substr(0, 6)=='field=')
					mod_mail_address_popup_field = arr1[i].substr(6)
		}

		if (mod_mail_address_popup_start>=mod_mail_address_popup_col)
			return true;
		for(var i=mod_mail_address_popup_start; i < mod_mail_address_popup_col; i++)
		{
			elem = getElem('ch'+i);
			if( elem.checked )
			{
				if( str != '' )
					str += ', ';
				str += elem.value;
			}
		}

		if( str == '' )
		{
			alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_ADDRESS_NO_ADDRESS_SELECTED)}{literal}');
			return true;
		}

		opener.mod_mail_message_new_insert_into_field(mod_mail_address_popup_field, str);
		window.close();

		return true;
	}
	
//    -->{/literal}
</script>
