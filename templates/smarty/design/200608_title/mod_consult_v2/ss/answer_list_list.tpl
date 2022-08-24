{capture name=pages}
{if count($res.pages.btn) > 0}
	<font class="dop4">Страницы: </font>
	{if !empty($res.pages.back)}<a href="{$res.pages.back}" class="dop">&lt;&lt;</a>&nbsp;{/if}
	{foreach from=$res.pages.btn item=l}
		{if $l.active==0}<a href="{$l.link}" class="dop">{else}<b  class="dop2">{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
	{/foreach}
	{if !empty($res.pages.next)}<a href="{$res.pages.next}" class="dop">&gt;&gt;</a>{/if}
{/if}
{/capture}

<br/>
<!-- begin content -->
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font class="zag7">Здравствуйте, {$USER->Profile.general.ShowName}.</font>
		</td>
	</tr>
</table>
<br/><br/><br/>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<b><a href="list.html">Новые вопросы</a>&nbsp;-&nbsp;<font style="color:red">{$res.count_new}</font></b>
	</td>
	<td align="right">
		<b><a href="list.html?onboard=1">Опубликованные вопросы</a>&nbsp;-&nbsp;{$res.count_old}</b>
	</td>
</tr>
</table>
<div align="left"><br/>{$smarty.capture.pages}</div>
<br/>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
{foreach from=$res.list item=l}
	<form method="post">
	<input type="hidden" name="action" value="update_quest" />
	<input type="hidden" name="id" value="{$l.id}" />
	<table width="100%" align="center" cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td valign="top" align="right"><b>Раздел:</b></td>
			<td align="left"><font class="zag3">{php}
			echo $this->_tpl_vars['res']['rubric_names'][
			
			$this->_tpl_vars['res']['consults']['ids'][
			
				$this->_tpl_vars['l']['st_id']
				
				]['path']
			
			];
			
			{/php}</font></td>
		</tr>
		<tr>
			<td valign="top" align="right"><b>Дата:</b></td>
			<td align="left">{$l.date|date_format:"%d.%m.%Y"}</td>
		</tr>
		<tr>
			<td valign="top" align="right"><b>Имя:</b></td>
			<td align="left">{$l.name}</td>
		</tr>
		<tr>
			<td valign="top" align="right"><b>E-mail:</b></td>
			<td align="left">{$l.email}</td>
		</tr>
		<tr>
			<td valign="top" align="right"><b>Текст вопроса:</b></td>
			<td align="left"><textarea  style="width:400px" name="otziv" cols="" rows="8">{$l.otziv}</textarea></td>
		</tr>
		<tr>
			<td valign="top" align="right"><b>Текст ответа:</b></td>
			<td align="left"><textarea  style="width:400px" name="answer" cols="" rows="8">{$l.answer}</textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%" align="center" cellpadding="3" cellspacing="0" border="0">
					<tr>
					<td>Показать <input type="checkbox" name="onboard" value="1" {if $l.onboard} checked {/if}/></td>
					<td><input type="submit" value="Сохранить изменения" /></td>
					<td>Удалить <input type="checkbox" name="delete" value="1"/></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
	</form>
	<br/>
{/foreach}
	</td>
	</tr>
</table>
<br/>
<div align="left"><br/>{$smarty.capture.pages}</div>
<!-- end content -->
<br/>

