{if isset($incorrect_marks)}
		<div id="incorrect_adv_div" style="display: none;" align="center"><noindex>		
		<form id="incorrect_form">
			<table cellspacing="0" cellpadding="5" width="300">
				<tr><td>
				<p>Выберите причину, по которой вы считаете это объявление некорректным, и/или напишите комментарии</p>
				</td></tr>
				<tr><td>
				<select class="incorrect_reason" width="100%" onchange="mod_job_incorrect_obj.onchange_incorrect_reason()">
					<option value="" selected>-- Выберите причину --</option>	
				{foreach from=$incorrect_marks key=id item=item}
					<option value="{$id}">{$item}</option>					
				{/foreach}
					<option value="other_marks">впишите свою причину</option>				
				</select>
				</td></tr>
				<tr><td>
				<textarea class="incorrect_comments" style="width: 100%; display: none;" onkeypress="mod_job_incorrect_obj.textarea_maxlength()" onfocus="if(this.value=='Комментарии')this.value=''" onblur="if(this.value=='')this.value='Комментарии'">Комментарии</textarea>
				</td></tr>
				{if !$USER->IsAuth()}
				<tr>
					<td align="center">
						<img class="captcha_code_img" src="{$res.captcha_path}" width="150" height="50" border="0" vspace="2"/><br/>
						<input type="text" class="captcha_code" value="" style="width:150;" /><br />
						<span style="font-size: 10px;">Введите четырехзначное число, которое Вы видите на картинке</span>
					</td>
				</tr>
				{/if}
				<tr><td align="center">
				<input class="send_incorrect" type="button" value="Отправить" onclick="mod_job_incorrect_obj.incorrect_adv();"/><input type="button" onclick="mod_job_incorrect_obj.hide()" value="Отменить"/>
				</td></tr>
			</table>
			      
		</form>
		</noindex>
		</div>
{/if}
