<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>
<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}

var ta_count = 0;

function add_field()
{
    var obj = document.getElementById('answer_list');
	obj.removeChild(document.getElementById('afteranswer'));
	ta_count++;
	var input = document.createElement("input");
	input.setAttribute("type","text");
	input.setAttribute("name","answer[]");
	input.setAttribute("value","");
	input.setAttribute("class","input_100");
	input.setAttribute("style","width:50%");
	input.setAttribute("id","t_answer"+ta_count);
	input.style.width = "50%";
	
	var delete_link = document.createElement("a");
	delete_link.setAttribute("href","javascript:void(0);");
	delete_link.setAttribute("name","delete_temp_answer_link");
	delete_link.setAttribute("style","padding-left: 10px;");
	delete_link.setAttribute("id","delete_temp_answer_link"+ta_count);
	//delete_link.setAttribute("onclick","del_temp_answer('"+ta_count+"');");
	delete_link.innerHTML = "Удалить";
		
	var br = document.createElement("br");
	br.setAttribute("id","br"+ta_count);

	var div = document.createElement("div");
	div.setAttribute("id","afteranswer");
	var button = document.createElement("input");
	button.setAttribute("type","button");
	button.setAttribute("value","Добавить ответ");
	//button.setAttribute("onclick","add_field();");
	button.setAttribute("id","add_field_button");
    div.appendChild(button);
	obj.appendChild(input);
	obj.appendChild(delete_link);
	obj.appendChild(br);
	obj.appendChild(div);
	
	$("#add_field_button").bind("click", add_field);
	$("#delete_temp_answer_link"+ta_count).bind("click", { cnt: ta_count}, function(e){
		var cnt = e.data.cnt;
		var obj = document.getElementById('answer_list');
		obj.removeChild(document.getElementById("t_answer"+cnt));
		obj.removeChild(document.getElementById("delete_temp_answer_link"+cnt));
		obj.removeChild(document.getElementById("br"+cnt));
	});
}

function del_temp_answer(cnt)
{
	var obj = document.getElementById('answer_list');
	obj.removeChild(document.getElementById("t_answer"+cnt));
	obj.removeChild(document.getElementById("delete_temp_answer_link"+cnt));
	obj.removeChild(document.getElementById("br"+cnt));
}
function intval(v) {
	v = parseInt(v);
	return isNaN(v) ? 0 : v;
}
function checkForm()
{
	if($('#manyans')[0].checked)
	{
		var min = intval($('#manyans_min')[0].value);
		var max = intval($('#manyans_max')[0].value);
		
		if(min <= 0) {
			alert("Значение в поле \"Минимальное кол-во ответов\" должно быть больше нуля!");
			return false;
		} else if(max < min) {
			alert("Значение в поле \"Максимальное кол-во ответов\" должно быть больше значения в поле \"Минимальное кол-во ответов\"!");
			return false;
		} else if (min > ($('input[name^=\'answer\']').size() - $('input[name^=\'del_ans\']:checked').size())) {
			alert("Минимальное кол-во ответов должно быть меньше или равно количества ответов в опросе");
			return false;
		} else if (max > ($('input[name^=\'answer\']').size() - $('input[name^=\'del_ans\']:checked').size())) {
			alert("Максимальное кол-во ответов должно быть меньше или равно количества ответов в опросе");
			return false;
		}
	}
	return true;
}

{/literal}</script>
<form id="cancel">
<input type="hidden" name="action" value="">
{$SECTION_ID_FORM}
</form>
<form method="post" onsubmit="return checkForm();">
{$SECTION_ID_FORM}
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="id" value="{$id}" />
<table width="100%" cellspacing="1">
<tr><td bgcolor="#F0F0F0">Дата</td><td width="100%">
{html_editdate current="`$date`" with_date="true" with_time="false"}
</td></tr>
<tr><td bgcolor="#F0F0F0">Вопрос</td><td width="100%"><input type="text" name="question" value="{$question}" class="input_100"></td></tr>
<tr><td bgcolor="#F0F0F0" valign="top">Ответы</td><td id="answer_list" width="100%">
{if !empty($answers)}
{foreach from=$answers item=l}<input type="text" name="answer[{$l.AnswerId}]" value="{$l.Name}" class="input_100" style="width:50%"> <input type="checkbox" name="del_ans[]" value="{$l.AnswerId}"> Удалить<br>{/foreach}
{else}
<input type="text" name="answer[]" value="" class="input_100" style="width:50%"><br>
{/if}
<div id="afteranswer"><input type="button" value="Добавить ответ" onclick="add_field();"/></div>
</td></tr>
<tr><td bgcolor="#F0F0F0">&nbsp;</td><td><input type="checkbox" name="Closed" value="1" {if $closed==1}checked{/if}>Закрыт</td></tr>
<tr><td bgcolor="#F0F0F0">&nbsp;</td><td><input type="checkbox" name="use_cookies" value="1" {if $use_cookies==1}checked{/if}>Использовать Cookies</td></tr>
<tr><td bgcolor="#F0F0F0">&nbsp;</td><td><input type="checkbox" name="captcha" value="1" {if $captcha==1}checked{/if}>Модуль защиты от ботов</td></tr>
<tr><td bgcolor="#F0F0F0">&nbsp;</td><td><input type="checkbox" onchange="$('#manyans_min')[0].disabled=$('#manyans_max')[0].disabled=!this.checked;" id="manyans" name="manyans" value="1" {if $manyans==1}checked{/if}>Множественный выбор</td></tr>
<tr><td bgcolor="#F0F0F0">Минимальное кол-во ответов:</td><td><input type="text" id="manyans_min" name="manyans_min" value="{$minans}" {if $manyans!=1}disabled{/if}></td></tr>
<tr><td bgcolor="#F0F0F0">Максимальное кол-во ответов:</td><td><input type="text" id="manyans_max" name="manyans_max" value="{$maxans}" {if $manyans!=1}disabled{/if}></td></tr>
<tr><td bgcolor="#F0F0F0">&nbsp;</td><td><input type="checkbox" name="visible" value="1" {if $visible==1}checked{/if}>Показывать опрос</td></tr>
<tr>
			<td bgcolor="#F0F0F0">Разделы</td>
			<td>
				<script> 
				{if !$smarty.get.user}
					var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}&action=moduletreenode',
					{literal}
					{
						max_elements: 0
					}
					{/literal});
					
					p.render_sections({$nodes});
					p.get_sections(0); 
				{/if}
				</script>
			</td>
		</tr>
</table>
<center><input type="submit" value="Сохранить" /> <input type="reset" value="Очистить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>