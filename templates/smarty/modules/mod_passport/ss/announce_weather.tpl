<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="announce_weather" />
<div class="title" style="padding: 5px;">Моя погода</div>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="showweather" id="showweather" value="1"{if $page.form.showweather} checked="checked"{/if} /> <label for="showweather">Показывать погоду</label></td>
	</tr>
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="currentweather" id="currentweather" value="1"{if $page.form.currentweather} checked="checked"{/if} /> <label for="currentweather">Показывать текущую погоду</label></td>
	</tr>
	<tr>
		<td class="bg_color2" align="right"><label for="city">Город:</label></td>
		<td class="bg_color4">
			 <select name="city" id="city">
				{foreach from=$page.form.city_arr item=v key=k}
					<option value="{$k}" {if $page.form.city == $k}selected="selected"{/if}>{$v.name}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>