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
<form name="mod_mail_addressbook_form" id="mod_mail_addressbook_form" method="post">
<input type="hidden" name="action" value="">
<tr align="left">
	<th width="20px" style="padding:0px; padding-left:3px;"><input type="checkbox" id="mainch" ></th>
	<th width="15%"><a href="?sf=nick&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">Ник{if $smarty.get.sf=='nick'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="30%"><a href="?sf=name&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">ФИО{if $smarty.get.sf=='name'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="25%"><a href="?sf=email&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">Email{if $smarty.get.sf=='email'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="15%"><a href="?sf=phone&so={if $smarty.get.so=='d'}a{else}d{/if}&{$res.link_sort}">Телефон{if $smarty.get.sf=='phone'}<font style="text-decoration:none;"> <img src="/_img/design/200608_title/{if $smarty.get.so=='a'}so_a.gif{else}so_d.gif{/if}" width="7" height="6" border="0" /></font>{/if}</a></th>
	<th width="15%">Комментарий</th>
</tr>
{if count($res.list)>0}
{foreach from=$res.list item=l key=k}
<tr align="left" valign="top" id="tr{$k}">
	<td align="center"><input type="checkbox" id="ch{$k}" name="ch[{$l.id}]"{if $l.checked} checked{/if} ></td>
	<td><a id="a1_{$k}" href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}?id={$l.id}">{$l.nick|escape:"html"}</a></td>
	<td><a id="a2_{$k}" href="/{$ENV.section}/{$CONFIG.files.get.editaddress.string}?id={$l.id}">{$l.lastname|escape:"html"}{if $l.firstname} {$l.firstname|escape:"html"}{/if}{if $l.midname} {$l.midname|escape:"html"}{/if}</a></td>
	<td><a id="a3_{$k}" href="#" onclick="getElem('ch{$k}').checked = true; mod_mail_addressbook_form_action('address_send');" title="Написать письмо">{$l.email|escape:"html"}</a></td>
	<td>{$l.phone|escape:"html"}</td>
	<td>{$l.comments|truncate:"20":"..."|escape:"html"}</td>
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
	<button onclick="mod_mail_addressbook_form_action('address_delete');" style="width:70px;">Удалить</button>
	</td>
	<td width="190px">
	<button onclick="mod_mail_addressbook_form_action('address_send');" style="width:180px;">Отправить сообщение</button>
	</td>
{/if}
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
lines_params.nobubble = ['a1_', 'a2_', 'a3_'];
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
	var mod_mail_addressbook_form = document.getElementById('mod_mail_addressbook_form');
	var mod_mail_address_col = {/literal}{$res.i|default:0}{literal};
	var mod_mail_address_start = 0;

	var mod_mail_addressbook_form_send = false;
	function mod_mail_addressbook_form_action(act)
	{
		if(mod_mail_addressbook_form_send)
			return false;
		
		if(act == 'address_delete')
		{
			if(!mod_mail_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_ADDRESS_NO_ADDRESS_SELECTED)}{literal}');
				return false;
			}
		}
		else if(act == 'address_send')
		{
			if(!mod_mail_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_ADDRESS_NO_ADDRESS_SELECTED)}{literal}');
				return false;
			}
		}
		else
		{
			return false;
		}
		
		mod_mail_addressbook_form.action.value = act;
			
		mod_mail_addressbook_form_send = true;
		mod_mail_addressbook_form.submit();
		return true;
	}
	
	function mod_mail_IsSelected(elem)
	{
		if (mod_mail_address_start>=mod_mail_address_col)
			return;
		for(var i=mod_mail_address_start; i < mod_mail_address_col; i++)
			if( document.getElementById(elem + ''+ i).checked )
				return true;
		return false;
	}
	
//    -->{/literal}
</script>
