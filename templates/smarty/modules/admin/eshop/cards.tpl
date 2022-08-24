
{literal}
<script language="javascript" type="text/javascript">

function fcancel()
{
	document.getElementById('cancel').submit();
}

</script>
{/literal}


<form id="cancel">
<input type="hidden" name="action" value="catalog" />
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="node" value="{$parent}" />
{$SECTION_ID_FORM}
</form>


<script language="javascript" type="text/javascript">{literal}
function search_user()
{
	$('#userinfo').slideUp('slow');
	$.ajax({
		url: ".",
			dataType: "json",
			type: "get",
			data: {
				action: 'search_user',
				section_id: {/literal}{$SECTION_ID}{literal},
				userid: $('#query').val()
			},
			success: function(data){
				if (data.status == 'error')
				{
					alert("Никого не найдено");
					return;
				}
				
				$('#card_value option:selected').each(function(){
					this.selected=false;
				});
				$('#hidden_userid').val(data.user.id);
				$("#card_value [value='"+data.user.card+"']").attr("selected", "selected");
				$('#userinfo').slideDown('slow');
			}
	});
}
{/literal}</script>
<form name="firmform" method="post" enctype="multipart/form-data">
{$SECTION_ID_FORM}
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="action" value="cards" />
<input type="hidden" name="userid" id="hidden_userid" value="" />

<table width="100%" cellspacing="1" cellpadding="2">
	<tr>
		<td >Введите идентификатор пользователя или email</td>
		<td width="85%">
			<input type="text" id="query" value=""/>
			<br/>
			<a href="javascript:void(0)" onclick="search_user()">найти</a> 
		</td>
	</tr>
</table>
<div id="userinfo" style="display:none;">
	Выберите скидку:
	<select name="card_value" id="card_value">	
		{foreach from=$card_values item=v key=k}
		<option value="{$k}">{$v}</option>
		{/foreach}
	</select>
</div>
<center><br><input type="submit" value="Продолжить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>
