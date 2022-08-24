<script type="text/javascript" language="javascript">{literal}
<!--

	var email_empty = 1;

    function checkfrmaddouternews(form){

      if (isEmpty(form.text.value)){
        alert("Вы не заполнили поле \"Текст\"!");
        form.text.focus();
        return false;
      }

	  email_empty = isEmpty(form.conts.value);
   	  if (email_empty || !isEmail(form.conts.value)){
		if(email_empty)
			alert("Вы не заполнили поле \"E-mail\"!");
		else alert("Вы неправильно заполнили поле \"E-mail\"!");
   	    form.conts.focus();
       	return false;
      }

      if(isEmpty(form.captcha_code.value)) {
	    alert("Поле \"Число\" должно быть заполнено.");
	    form.captcha_code.focus();
	    return false;
      }
      //window.location=window.location.href;
      //window.open('', 'stat', 'width=300,height=200,resizable=0,menubar=0,scrollbars=0').focus();
      return true;
    }

	function ShowHideAll(form){
		if( form.target.value < 0 ) {		
			form.but.disabled = 'disabled';
			form.text.disabled = 'disabled';
			form.conts.disabled = 'disabled';
			form.captcha_code.disabled = 'disabled';
		} else {
			form.but.disabled = 0;
			form.text.disabled = 0;
			form.conts.disabled = 0;
			form.captcha_code.disabled = 0;
		}
	}


    function isEmpty (txt){
      var ch;
      if (txt == "") return true;
      for (var i=0; i<txt.length; i++){
        ch = txt.charAt(i);
          if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
      }
      return true;
    }

	function isEmail(email)
	{
		var arr1 = email.split("@");
		if (arr1.length != 2) return false;
		else if (arr1[0].length < 1) return false;
		var arr2 = arr1[1].split(".");
		if (arr2.length < 2) return false;
		else if (arr2[0].length < 1) return false;
		return true;
	}
//    -->{/literal}
</script>

<table border="0" cellpadding="20" cellspacing="0" width="100%" height="100%" align="center">
	<tr>
		<td valign="middle" class="t12">
				<h1 class="title">Обратная связь</h1>
			
{if $UERROR->IsError()}
<div class="error">{php}echo UserError::GetErrorsText(){/php}</div>
{/if}

{php}
	// получаю path к разделу, с которого пришла обратная связь
	$this->_tpl_vars['section_path'] = '';

	if(isset($this->_tpl_vars['page']['form']['from']) && !empty($this->_tpl_vars['page']['form']['from']))
		$this->_tpl_vars['section_path'] = ModuleFactory::GetLinkBySectionId($this->_tpl_vars['page']['form']['from']);
{/php}
			<form name="formaddNews" class="jnice" method="post" onSubmit="return checkfrmaddouternews(this)" style="margin:0px; line-height: 20px;">
			<input type="hidden" name="action" value="send" />
			<input type="hidden" name="referer" value="{$page.form.referer}" />
                        <input type="hidden" name="from" value="{$page.form.from}" />
				<table align="center" cellpadding="2" cellspacing="0" border="0" width="100%">			
					<tr valign="top">
						<td align="left" class="feedback_text">Тема:
							<select name="target" style="width:100%;" class="feedback_field" onclick="javascript:ShowHideAll(this.form);">
								<option value="-1"> - Выберите тему - </option>
								{foreach from=$page.form.target_arr item=l key=k}
									{if is_array($l)}
										{assign var=current value=false}
										{if strpos($section_path, 'forum') && empty($page.form.target)}
											{if $k == 7}
												{assign var=current value=true}
											{/if}
										{elseif $page.form.target == $k}
											{assign var=current value=true}
										{/if}
										<option value="{$k}"{if $current} selected="selected"{/if}{if !empty($l.mark)} style="color: red;"{/if}>{$l.name}</option>
									{/if}
								{/foreach}
							</select>
							
						</td>
					</tr>
					<tr valign="top">
						<td align="left" class="feedback_text">Текст:
							<textarea name="text" style="width:100%;height:100px" class="feedback_field"{if $page.form.target<0} disabled="disabled"{/if}>{$page.form.text}</textarea>
						</td>
					</tr>
					<tr>
						<td align="left" class="feedback_text">Ваш E-mail:
							<input type="text" name="conts" style="width:100%" value="{$page.form.conts}" class="feedback_field"{if $page.form.target<0}  disabled="disabled"{/if}>
						</td>
					</tr>
					<tr>
						<td class="feedback_text">
							<img src="{$page.form.captcha_path}" align="absmiddle" width="150" height="50" alt="число" border="0"> &gt;&gt; <input type="text" name="captcha_code" size="20" maxlength="4" class="txt" style="width:40px;" class="feedback_field"{if $page.form.target<0}  disabled="disabled"{/if}><br/>
						</td>
					</tr>
					<tr>
						<td align="center">
						<input type="submit" value="Отправить" style="width:130px" class="feedback_field" name="but"{if $page.form.target<0}  disabled="disabled"{/if}>
						</td>
					</tr>
				</table>
			</form>  
		
		</td>
	</tr>
</table>
