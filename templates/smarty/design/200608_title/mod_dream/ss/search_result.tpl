{if is_array($res.talks) && sizeof($res.talks)}
{php}
$this->_tpl_vars['tList_1'] = '';
$this->_tpl_vars['tList_2'] = '';
$this->_tpl_vars['tList_3'] = '';

	foreach($this->_tpl_vars['res']['talks'] as $k => $v) {
		if ( ceil(sizeof($this->_tpl_vars['res']['talks'])/3) > $k) {
			$this->_tpl_vars['tList_1'] .= "<img src=\"/_img/design/200608_title/b3.gif\">&#160;<a href=\"/{$this->_tpl_vars['CURRENT_ENV']['section']}/show/{$v['did']}.html\">{$v['word']}</a><br>";
		}
		else if ( (2 * ceil(sizeof($this->_tpl_vars['res']['talks'])/3)) > $k) {
			$this->_tpl_vars['tList_2'] .= "<img src=\"/_img/design/200608_title/b3.gif\">&#160;<a href=\"/{$this->_tpl_vars['CURRENT_ENV']['section']}/show/{$v['did']}.html\">{$v['word']}</a><br>";
		} else {
			$this->_tpl_vars['tList_3'] .= "<img src=\"/_img/design/200608_title/b3.gif\">&#160;<a href=\"/{$this->_tpl_vars['CURRENT_ENV']['section']}/show/{$v['did']}.html\">{$v['word']}</a><br>";
		}
	}
{/php}

<br><table cellpadding="3" cellspacing="0" width="100%"> 
	<tr>
		<td class="t5gb">
			{if $res.word}
				Результат поиска по ключевому слову &laquo;{$res.word}&raquo;
			{elseif $res.letter}
				Ключевые слова на букву &laquo;{$res.letter}&raquo;
			{else}
				Результат поиска по теме &laquo;{$res.section.rname} :: {$res.section.pname}&raquo;
			{/if}
			({$res.count|intval})
		</td>
	</tr> 
</table><br/>

<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<tr>
		<td valign="top">{$tList_1}</td>
		<td valign="top">{$tList_2}</td>
		<td valign="top">{$tList_3}</td>
	</tr>
</table><br/><br/>

{elseif trim($res.word) != ''}

<center>
	<form method="post">
	<b>
		<font color="red">
			Не найдено ни одного толкования, удовлетворяющего условиям поиска.
		</font>
	</b><br/><br/>
		<input type="hidden" name="word" value="{$res.word}">
		<input type="hidden" name="action" value="request_word">
		<input type="submit" value="Отправить запрос"><br/><br/>
		Отправьте запрос редактору и в ближайшее время, указанное вами ключевое слово появится на сайте.
	</form>
</center>
{else}
<center>
<b>
	<font color="red">
		К сожалению по вашему запросу ничего не найдено
	</font>
</b>
</center><br/><br/>
{/if}

{if sizeof($res.others)}
<table cellpadding="3" cellspacing="0" width="100%"> 
	<tr>
		<td class="t5gb">
			Смотрите также
		</td>
	</tr> 
</table>
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td valign="top"><b>Другие подразделы:</b></td>
		<td valign="top">
			{foreach from=$res.others item=other}
				<img src="/_img/design/200608_title/b3.gif">&#160;<a href="/{$CURRENT_ENV.section}/search/section.html?rid={$other.rid}&pid={$other.pid}" class="s1">{$other.pname}</a><br>
			{/foreach}
		</td>
	</tr>
</table>
{/if}