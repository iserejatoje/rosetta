{literal}
<script language="JavaScript">
<!--
function ChangeRubric()
{
	var rubricator, frm, rsi, str, subar, si, i;

	rubricator = {{/literal}{foreach from=$res.parentlist item=l name=parentlist}{if !$smarty.foreach.parentlist.first},{/if}{$l.id} : "{foreach from=$res.tree item=pl}{if $pl.parent==$l.id}{$pl.id}|{$pl.data};{/if}{/foreach}"{/foreach}{literal}}
	frm = document.firmform;

	if (frm.rub.selectedIndex >= 0 && frm.rub.options[frm.rub.selectedIndex]) {
		rsi = frm.rub.options[frm.rub.selectedIndex].value;
		if (rsi > 0) {
			str = rubricator[rsi];
			subar = str.split(";");
			si = subar.length-1;
			frm.subrub.length = si;

			for(i=0; i<si; i++) {
				entar = subar[i].split("|");
				frm.subrub.options[i].value = entar[0];
				frm.subrub.options[i].text = entar[1];
			}
		}
	}
}

        function AddRub() {
			var si, str, i, frm, id;

			frm = document.firmform;

			if (frm.subrub.length && frm.subrub.selectedIndex >= 0) {
				si = frm.subrub.selectedIndex;
				id = frm.subrub.options[si].value;
				str = frm.subrub.options[si].text;
				for (i=0;i<frm.selrub.length;i++) {
					if(frm.selrub.options[i].value == id) {
						alert("Этот вид уже выбран");
						return;
					}
				}

				var newOpt = new Option(str,frm.subrub.options[si].value);
				frm.selrub.options.add(newOpt);
				frm.rlist.value += frm.subrub.options[si].value + ";";
				if(si < (frm.subrub.length-1)) {
					frm.subrub.selectedIndex++;
				}
			} else return;
		}

        function RmRub()
        { var frm, si, i, str, rstr, slen, p1, p2;

          frm = document.firmform;
          if(frm.selrub.length == 0) {
            alert("Список пустой");
            return;
          }
          si = frm.selrub.selectedIndex;
          if(si == -1) {
            alert("Не выбрана деятельность для удаления");
            return;
          } else {
            str = frm.selrub.options[si].value+"";
            slen = str.length;
            slen++;
            for(i=si; i<(frm.selrub.length-1); i++) {
              frm.selrub.options[i].text = frm.selrub.options[i+1].text;
            }
            frm.selrub.options[i].text = "";
            frm.selrub.length--;
            rstr = frm.rlist.value;
            si = rstr.indexOf(str, 0);
            p1 = rstr.substring(0, si);
            p2 = rstr.substring(si+slen, rstr.length);
            frm.rlist.value = p1+p2;
          }
        }
    function ResetForm()
    { var initlist;
      document.firmform.reset();
      document.firmform.selrub.length=initlist.length;
      document.firmform.rlist.value = "";
      for(i=0; i<initlist.length; i++) {
        document.firmform.selrub.options[i].text=initlist[i];
        document.firmform.rlist.value += initlist[i] + ";";
      }
    }
// -->
</script>
{/literal}

{if $error}<div align="center" style="color:red"><b>{$error}</b></div><br/><br/>{/if}
<form name="firmform" method="post" enctype="multipart/form-data">
<input type="hidden" name="rlist" value="{foreach from=$rlist item=r key=rk}{$rk};{/foreach}">
<input type="hidden" name="action" value="{$res.action}">

<table cellspacing="2" cellpadding="3" width="100%">
{*	<tr>
		<td bgcolor="#F0F0F0" align="right" >Сферы<br/>деятельности</td>
		<td width="100%">
			<select style="width:100%" name="rub" size=1 onChange="ChangeRubric();">
				<option value="0">-- ВЫБЕРИТЕ РУБРИКУ --</option>
				{foreach from=$res.parentlist item=l}
				{if $l.haschildren == 1}
				<option value="{$l.id}" {if $l.id==$rootdir}selected="selected"{/if}>
					{"&nbsp;&nbsp;&nbsp;"|str_repeat:$l.level+1}{$l.data.name}
				</option>
				{/if}
				{/foreach}
			</select><br/>
			<SELECT style="width:100%" name="subrub" size=5>
			{foreach from=$res.tree item=l}
			{if $l.parent==$rootdir}
				<option value="{$l.id}">{$l.data}</option>
			{/if}
			{/foreach}
			</SELECT><br/>
			<input type="button" value=" Добавить деятельность " onClick="AddRub()">&#160;&#160;&#160;<input type="button" value=" Удалить деятельность " onClick="RmRub()">
			<select style="width:100%" name="selrub" size=5>{foreach from=$rlist item=r key=rk}<option value="{$rk}">{$r}</option>{/foreach}</select>
		</td>
	</tr> *}
	{foreach from=$res.form key=key item=item}
	<tr>
		<td bgcolor="#F0F0F0" nowrap="nowrap" align="right" >
			{$item.title}
		</td>
		<td width="100%" valign="top">
			{if $item.type=='string'}
				{if $item.name == 'url'}
				<input type="text" name="{$item.name}" value="{$item.value|url:false|escape}" style="width:100%" />
				{else}
				<input type="text" name="{$item.name}" value="{$item.value|escape}" style="width:100%" />
				{/if}
				{if $item.description}<br/>
					<small>{$item.description}</small>
				{/if}
			{elseif $item.type=='textarea'}
				<textarea name="{$item.name}" style="width:100%;{if isset($item.height)}height:{$item.height}{/if}">{$item.value}</textarea>
			{elseif $item.type=='richarea'}
				{$item.value}
			{elseif $item.type=='dropdown'}
				<div>
					<select name="{$item.name}" style="width:100%" {if $item.name=="regid"}onChange="ChangeRegion();"{/if}>
					<!--selected={$item.selected}-->
					{assign var=sel value=false}
					{foreach from=$item.rows item=l}
						<option value="{if $l.id!=""}{$l.id}{else}0{/if}"{if $item.selected==$l.id}{assign var=sel value=true} selected="selected"{/if}>{$l.data}</option>
					{/foreach}
					</select>
				</div>
{if $item.freedata==true}<div><input type="text" name="{$item.name}_str"{if $sel==false} value="{$item.selected}"{/if} style="width:100%" /></div>{/if}
{elseif $item.type=='file'}
{if $item.value!='none' && $item.value!=''}
	{if $item.name=='logotype' || $item.name=='logobig'}
	<img src="{$img_url}{$item.value}" border=0 />&#160;&#160;<input type="checkbox" name="del_{$item.name}" />&#160;удалить
	{else}
	<a href="{$docs_url}{$item.value}" target="_blank" title="открыть">{$item.value}</a>&#160;&#160;<input type="checkbox" name="del_{$item.name}" />&#160;удалить
	{/if}
{/if}
<input type="file" name="{$item.name}"  style="width:100%"/>
{/if}

{if $item.name=='cityname'}
	{if $CURRENT_ENV.site.domain=="72.ru"}
		<center><noindex><a href="http://86.ru/firms/addorg.html"  rel="nofollow" target="_blank" style="color:red;">ХМАО</a>
		&nbsp;&nbsp;&nbsp;<a href="http://89.ru/firms/addorg.html" rel="nofollow" target="_blank" style="color:red;">ЯНАО</a>
		</noindex></center>
	{/if}
	{if $CURRENT_ENV.site.domain=="86.ru"}
		<center><noindex><a href="http://72.ru/firms/addorg.html"  rel="nofollow" target="_blank" style="color:red;">Тюмень</a>
		&nbsp;&nbsp;&nbsp;<a href="http://89.ru/firms/addorg.html" rel="nofollow" target="_blank" style="color:red;">ЯНАО</a>
		</noindex></center>
	{/if}
	{if $CURRENT_ENV.site.domain=="89.ru"}
		<center><noindex><a href="http://72.ru/firms/addorg.html"  rel="nofollow" target="_blank" style="color:red;">Тюмень</a>
		&nbsp;&nbsp;&nbsp;<a href="http://86.ru/firms/addorg.html" rel="nofollow" target="_blank" style="color:red;">ХМАО</a>
		</noindex></center>
	{/if}
	{if $CURRENT_ENV.site.domain=="63.ru"}
		<center><noindex><a href="http://tolyatty.ru/firms/addorg.html"  rel="nofollow" target="_blank" style="color:red;">Тольятти</a></noindex></center>
	{/if}
{/if}

</td>
</tr>
{if $item.name=='cityname'}
<tr>
		<td bgcolor="#F0F0F0" align="right" >Сферы<br/>деятельности</td>
		<td width="100%">
			<select style="width:100%" name="rub" size=1 onChange="ChangeRubric();">
				<option value="0">-- ВЫБЕРИТЕ РУБРИКУ --</option>
				{foreach from=$res.parentlist item=l}
				{if $l.haschildren == 1}
				<option value="{$l.id}" {if $l.id==$rootdir}selected="selected"{/if}>
					{"&nbsp;&nbsp;&nbsp;"|str_repeat:$l.level+1}{$l.data.name}
				</option>
				{/if}
				{/foreach}
			</select><br/>
			<SELECT style="width:100%" name="subrub" size=5>
			{foreach from=$res.tree item=l}
			{if $l.parent==$rootdir}
				<option value="{$l.id}">{$l.data}</option>
			{/if}
			{/foreach}
			</SELECT><br/>
			<input type="button" value=" Добавить деятельность " onClick="AddRub()">&#160;&#160;&#160;<input type="button" value=" Удалить деятельность " onClick="RmRub()">
			<select style="width:100%" name="selrub" size=5>{foreach from=$rlist item=r key=rk}<option value="{$rk}">{$r}</option>{/foreach}</select>
		</td>
	</tr>

{/if}
{/foreach}
{*if !empty($res.session_id)}
	<tr>
		<td width="150" align="right" valign="top" bgcolor="#F0F0F0" >Защита от роботов: </td>
		<td ><img src="/_ar/pic.gif?{$res.session_id}" width="150" height="50" align="middle" alt="код" border="0"> &gt;&gt; <input type="text" name="antirobot" size="20" style="font-size:12px">
		<br />Введите четырехзначное число, которое Вы видите на картинке</td>
	</tr>
	{/if*}

{if isset($res.captcha_path)}
	<tr>
      <td width="150" align="right" valign="top" bgcolor="#F0F0F0" >Код защиты от роботов</td>
      <td><img src="{$res.captcha_path}" width="150" height="50" border="0" align="middle" /> &gt;&gt; <input type=text name="captcha_code" style=width:100px value="">
			<br />Введите четырехзначное число, которое Вы видите на картинке</td>
    </tr>
{/if}

	<tr>
		<td colspan="2"></td>
	</tr>
{if !isset($user)}
	<tr bgcolor="#F0F0F0">
		<td colspan="2"><img height="1" src="/_img/x.gif" width="1"></td>
	</tr>
	<tr>
		<td align="left" colspan="2">Для того, чтобы добавить компанию в справочник (и иметь возможность в дальнейшем редактировать информацию о ней), необходимо <a href="javascript:void(0)" onclick="window.open('/{$SITE_SECTION}/register.html', 'ereg', 'menubar=no, status=no, scrollbars=no, toolbar=no, top=20, left=20, width=500,height=350');">зарегистрироваться</a>. <br>
		<br>
		Если Вы уже являетесь зарегистрированным пользователем, то введите имя и пароль. </td>
	</tr>
	<tr>
		<td width="150" align="right" bgcolor="#F0F0F0" >* Имя: </td>
		<td><input type="text" name="login" style="width:350px; font-size:12px" value="{$res.form.login.value}"></td>
	</tr>
	<tr>
		<td width="150" align="right" bgcolor="#F0F0F0" >* Пароль: </td>
		<td><input type="password" name="password" style="width:350px; font-size:12px"></td>
	</tr>
	<tr>
		<td colspan="2" align="left" class="text11">Процесс регистрации является обязательным!!! </td>
	</tr>
	<tr bgcolor="#F0F0F0">
		<td colspan="2"><img height="1" src="/_img/x.gif" width="1"></td>
	</tr>
{/if}
	<tr>
		<td valign="top" colspan="2"><input type="hidden" name="action" value="{$res.action}">
		<input type="hidden" name="id" value="{$res.id}">
		<input type="submit" value="Применить" class="button">
			<input type="reset" value="Очистить" class="button"></td>
	</tr>
</table>
{$res.session_code}
</form>