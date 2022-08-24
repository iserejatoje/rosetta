Это объявление некорректно?
<a onclick="moderate.showForm(<?=$vars['id']?>); return false;" href="#">Сообщите нам об этом</a>.
<div id="incorrect_container_<?=$vars['id']?>" class="incorrect_container" style="display:none;"> </div>

<div style="display:none;" id="incorrect_adv_div">
	<noindex>		
	<form id="incorrect_form">
		<div style="width:300px">
			<p>Выберите причину, по которой вы считаете это объявление некорректным, и/или напишите комментарии</p>
			<select onchange="moderate.onchange_incorrect_reason()" class="incorrect_reason" style="width:100%">
				<option selected="" value="">- выберите причину -</option>
				<? foreach ( $vars['reasons'] as $k => $v ): ?>
					<option value="<?=$k?>"><?=$v['s']?></option>
				<? endforeach; ?>
				<option value="-1">другая причина</option>
			</select>
			<textarea onblur="if(this.value=='')this.value='Комментарии'" onfocus="if(this.value=='Комментарии')this.value=''" style="width: 100%; display: none;" class="incorrect_comments">Комментарии</textarea>
			<? if ( !App::$User->IsAuth() ): ?>
				<div style="text-align:center">
					<img class="captcha_code_img" width="150" vspace="2" height="50" border="0" src="<?=$vars['captcha_path']?>"/>
					<br/>
					<input class="captcha_code" type="text" style="width: 150px;" value=""/>
					<br/>
					<span style="font-size: 10px;">Введите четырехзначное число, которое Вы видите на картинке</span>
				</div>
			<? endif; ?>
			<div style="text-align:center;padding-top:5px;">
				<input type="button" onclick="moderate.incorrectAdv();" value="Отправить" class="send_incorrect"/><input type="button" value="Отменить" onclick="moderate.hideForm()"/>
			</div>
		</div>
	</form>
	</noindex>
</div>
