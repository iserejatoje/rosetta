<script language="JavaScript">
		{literal}	<!--
function CheckForm(form) {
	if ( isEmpty(form.where.value) ) {
		alert("Вы не указали МЕСТО ДТП!");
		form.where.focus();
		return false;
	}

	return true;
}

function isEmpty (txt) {
	var ch;
	if (txt == "" || txt == "0" ) return true;
	for (var i=0; i<txt.length; i++) {
		ch = txt.charAt(i);
		if ( ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") 
			return false;
	}
	return true; 
}
-->
{/literal}
</script>
<script language='Javascript'>
{literal}
				    <!--
			    function check(form){
			      if (isEmpty(form.name.value)){
			        alert('Укажите ваше имя или nickname!');
			        form.name.focus();
			        return false;
			      }
			      if (isEmpty(form.comment.value)){
			        alert('Вы не оставили сообщение!');
			        form.comment.focus();
			        return false;
			      }
			      if (!isEmpty(form.email.value) && !isEmail(form.email.value)){
			                alert('вы неправильно указали E-mail!');
			                form.email.focus();
			                return false;
			      }       

			      if (form.comment.value.length>1000){
				        alert('Ваше сообщение слишком большое. Максимальная длина - 1000 знаков.');
				        form.comment.focus();
				        return false;
			      }
			      return true;
			    }


			    function isEmail(email){
				        var arr1 = email.split('@');
				        if (arr1.length < 2) 
			                return false;
				        if (arr1[0].length < 1) 
				                return false;
				        var arr2 = arr1[1].split('.');
				        if (arr2.length < 2) 
			                return false;
				        if (arr2[0].length < 1) 
			                return false;
				        if (arr2[1].length < 1) 
			                return false;
			        return true;
			    }
			//    -->
			{/literal}
			</script>
		<!-- начало - форма для отзыва -->
		<p align=center>
		{if $form.message}
				<br/><br/><font color="red">{$form.message}</font><br/><br/>		
			{/if}
		<table border='0' cellspacing='0' cellpadding='0' align="left">
		<tr>
			<td valign='top'>
				<form method='post' action="#addcomment" onSubmit='javascript: return check(this)'>
				<input type=hidden name="action" value='addcomment'>
				<table cellSpacing='0' cellPadding='4' width='100%' align='center' border='0'>
				<tr>
					<td align="left" colSpan="2" class="t5gb"><b>Выскажи свое мнение!</b></td>
				</tr>
				<tr>
					<td width='100' align='left'>
						<b>Автор:</b></td>
					<td align="left">
						<input class='t_in' maxLength='100' size='50' name='name' value="{$form.name}" style="width: 300px;"></td>
				</tr>
				<tr>
					<td width='100' align='left'>
						<b>E-mail:</b></td>
					<td align="left">
						<input class='t_in' maxLength='100' size='50' name='email' value="{$form.email}" style="width: 300px;"></td>
				</tr>
				<tr>
					<td vAlign='top' width='100' align='left'>
						<b>Tекст сообщения:</b></td>
					<td align="left">
						<textarea class='t_in' name='comment' rows='10' cols='40' style="width: 300px;">{$form.comment}</textarea></td>
				</tr>
				<tr>
					<td vAlign='top' width='100'></td>
					<td align='left'>
						<input type='submit' value='Отправить' class=button></td>
				</tr>
				</table></form>
			</td>
		</tr>
		</table></p>
		<!-- конец - форма для отзыва -->