
<script language="javascript">
var sections = {literal}{{/literal}{foreach from=$res.sections item=section key=k name=section}{$k}: {literal} { {/literal} name: "{$section.name}",list: {literal} { {/literal} {foreach from=$section.list item=subsection key=k1 name=subsection}{$k1}: "{$subsection}"{if !$smarty.foreach.subsection.last},{/if}{/foreach}{literal} } {/literal}{literal} } {/literal} {if !$smarty.foreach.section.last},{/if}{/foreach}{literal}}{/literal}
</script>

<table cellspacing="0" align="center" cellpadding="0" border="0" style="width:500px;">
<tr><td valign="top" >
<table cellspacing="0" cellpadding="0" border="0" bgcolor="#F3F8F8">
	<tr>
		<td class="t5gb" style="padding-left:10px;height:25px"><b>Самое полное толкование снов</b></td>
	</tr>
	<tr>
		<td style="padding-left:10px;height:50px">
			<form name="section_list" method="get" action="/{$CURRENT_ENV.section}/search/section.html" onSubmit="return checkformrazdel(this)">
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td style="padding:0px 0px 2px 2px"><span class="t7">выберите</span></td>
				</tr>
				<tr>
					<td>
						<select style="border: 1px solid rgb(5, 84, 173); color: rgb(26, 25, 71);" name="rid" onchange="buildList()">
							<option value="0">« тематический раздел »</option>
							{foreach from=$res.sections item=section key=k}
								<option value="{$k}" {if $res.params.pid > 0 && $res.params.rid == $k}selected="selected"{/if}>{$section.name}</option>
							{/foreach}
						</select>
					</td>
					<td class="t7">&#160;и&#160;</td>
					<td>
						<select style="border: 1px solid rgb(5, 84, 173); color: rgb(26, 25, 71);width:120px;" name="pid">
							<option value="0">« подраздел »</option>
							{if $res.sections[$res.params.rid] && $res.params.pid}
								{foreach from=$res.sections[$res.params.rid].list item=section key=k}
								<option value="{$k}" {if $res.params.pid == $k}selected="selected"{/if}>{$section}</option>
								{/foreach}
							{/if}
						</select>
					</td>
					<td>&#160;&#160;&#160;<input type="submit" value="Искать" class="txt"/></td>
				</tr>
			</table>
			</form>			
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;height:70px" class="txt3">
			<form action="/{$CURRENT_ENV.section}/search/word.html" onsubmit="return checkformword(this)" method="get">
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td colspan="3" class="txt3" style="padding:0px 0px 2px 2px"><span class="t7">ключевое слово</span></td>
				</tr>
				<tr>
					<td><input type="text" maxlength="50" value="" size="30" name="q" class="txt"/></td>
					<td>&#160;&#160;&#160;<input type="submit" value="Искать" class="txt" /></td>
					<td style="padding-left:25px;" align="center"><a href="/{$CURRENT_ENV.section}/rules.html" class="s1">Правила пользования<br/>разделом «Сонник»</a></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;height:20px" class="txt3">
			<span class="t5gb">Искать толкование по алфавиту</span>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;height:15px">
			{foreach from=$res.letters item=letter}
				<b><a href="/{$CURRENT_ENV.section}/search/abc.html?q={$letter}" class="txt3">{$letter}</a></b>
			{/foreach}
		</td>
	</tr>
	<tr><td>&#160;</td></tr>
</table></td></tr></table>