
<script language="JavaScript">
<!--{literal}
function TestParam(frm)
{
  if( frm.contacts.value.length == 0) {
    alert("Поле ВАШИ КОНТАКТЫ не заполнено.");
    frm.contacts.focus();
    return false;
  }
  {/literal}
{foreach from=$res.form.fields item=f key=_k}
{if $f.validator.require}
  {literal}if( frm.{/literal}{$_k}{literal}.value.length == 0) {
    alert("{/literal}{$f.validator.require[1]}{literal}");
    frm.{/literal}{$_k}{literal}.focus();
    return false;
  }{/literal}	
{/if}
{/foreach}
  {literal}
  return true;
}
{/literal}
//-->
</script>

<center>
<br>
<div style="pading:5px;">
<font>Запрос на изменение информации о фирме в разделе<br>&laquo;Справочник&nbsp;фирм&raquo;</font><br><br>
<font><b>Если размещенная здесь информация устарела, сообщите модератору:</b></font>
</div>
<br><br>
<form name="attentform" method="post" onsubmit="return TestParam(this)">
<input type="hidden" name="action" value="attention">
<table cellpadding="5" cellspacing="2" border=0 align="center">
	{if $res.error}
	<tr>
		<td colspan="2"><font color="red"><strong>Ошибка:</strong></font><br>{$res.error}<br><br></td>
	</tr>
	{/if}
	<tr>
		{* <td width=150 align=right >регион:</TD>
		<td width=350>Уфимская область</td> *}
	    </tr>
	{foreach from=$res.form.fields item=f key=_k}
		<tr>
			<td width="150" align="right" >{if $f.validator.require}*{/if}{$f.title}: </td>
			<td>
				{if $f.type=='string'}
					<input type="text" name="{$_k}" style="width:350px; font-size:12px" value="{$res.form[$_k].value}">	
				{elseif $f.type=='textarea'}
					<textarea name="{$_k}" style="width:350px; font-size:12px; height:100px">{$res.form[$_k].value}</textarea>
				{elseif $f.type=='dropdown'}
					<div><select name="{$_k}">
					{assign var=sel value=false}
						{foreach from=$res.form[$_k].rows item=l}
						<option value="{$l.id}"{if $res.form[$_k].selected==$l.id}{assign var=sel value=true} selected="selected"{/if}>{$l.data}</option>
						{/foreach}
					</select></div>
					{if $res.form[$_k].freedata==true}<div><input type="text" name="{$_k}_str"{if $sel==false} value="{$res.form[$_k].value}"{/if} /></div>{/if}	
				{/if} 
			</td> 
		</tr>
	{/foreach} 
	<tr>
		<td width="150" align="right">*ваши контакты: </td>
		<td><input type="text"  name="contacts" style="width:350px; font-size:12px" value=""></td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td valign="top" align="center" colspan="2">
		<input type="hidden" name="id" value="{$res.id}">
		<input type="submit" value="Отправить изменения">
		</td>
	</tr>
	<tr>
		<td colspan=2 align="center">
			<a href='javascript:window.close()'>Закрыть</a>
		</td>
	</tr>
</table>
</form>