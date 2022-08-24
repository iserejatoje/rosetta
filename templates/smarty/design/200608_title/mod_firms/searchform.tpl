	{if $CURRENT_ENV.site.domain=="72.ru"}
		<center><noindex><a href="http://86.ru/firms/"  rel="nofollow" target="_blank" style="color:red;">Справочник фирм ХМАО</a>
		&nbsp;&nbsp;&nbsp;<a href="http://89.ru/firms/" rel="nofollow" target="_blank" style="color:red;">Справочник фирм ЯНАО</a>
		</noindex></center><br/>
	{/if}
	{if $CURRENT_ENV.site.domain=="86.ru"}
		<center><noindex><a href="http://72.ru/firms/"  rel="nofollow" target="_blank" style="color:red;">Справочник фирм Тюмени</a>
		&nbsp;&nbsp;&nbsp;<a href="http://89.ru/firms/" rel="nofollow" target="_blank" style="color:red;">Справочник фирм ЯНАО</a>
		</noindex></center><br/>
	{/if}	
	{if $CURRENT_ENV.site.domain=="89.ru"}
		<center><noindex><a href="http://72.ru/firms/"  rel="nofollow" target="_blank" style="color:red;">Справочник фирм Тюмени</a>
		&nbsp;&nbsp;&nbsp;<a href="http://86.ru/firms/" rel="nofollow" target="_blank" style="color:red;">Справочник фирм ХМАО</a>
		</noindex></center><br/>
	{/if}
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center">
    {php}
		$abc = array(
			'a' => 'А', 'b' => 'Б', 'v' => 'В', 'g' => 'Г', 'd' => 'Д', 'e' => 'Е', 'jo'=> 'Ё', 
			'zh' => 'Ж', 'z' => 'З', 'i' => 'И', 'jj' => 'Й', 'k' => 'К', 'l' => 'Л', 'm' => 'М',
			'n' => 'Н', 'o' => 'О', 'p' => 'П', 'r' => 'Р', 's' => 'С', 't' => 'Т', 'u' => 'У', 
			'f' => 'Ф', 'kh' => 'Х', 'c' => 'Ц', 'ch' => 'Ч', 'sh' => 'Ш', 'shh' => 'Щ', 'y' => 'Ы', 
			'eh' => 'Э', 'yu' => 'Ю', 'ya' => 'Я');

		foreach ($abc as $key => $letter)
			echo "<a href=\"/{$this->_tpl_vars['CURRENT_ENV']['section']}".($_SESSION["group"]!=''?"/".$_SESSION["group"]:"")."/search/$key.html\">$letter</a> ";
	{/php}</td>
  </tr>
</table><br/>
{if !empty($res.rtitle) || sizeof($res.pathdesc) > 0}
<table border="0" cellpadding="0" cellspacing="0" align=center width="100%">
					
					<tr>
						<td height="1" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" height="1"></td>
					</tr>
					<tr>
						<td>&#160;</td>
					</tr>
					
					<tr>
						<td class="gl" height="22" align="center" ><b>{if !empty($res.rtitle)}{$res.rtitle}{
						else}
							{foreach from=$res.pathdesc item=path}{
							if $path.path!=$res.base}<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$path.path}/">{/if}{$path.data.name}{if $path.path!=$res.base}</a>&nbsp;/&nbsp;{/if}{
							/foreach}{
						/if}</b></td>
					</tr>
					<tr>
						<td height="3"><img src="/_img/x.gif" width="1" height="3"></td>
					</tr>
</table>
{/if}