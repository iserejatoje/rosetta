<style>
{literal}
.users_search_form {
	padding: 10px;
}
.users_search_form .line_sep {
	clear:both;
	height: 10px;
}
.users_search_form .line_field {
	clear:both;
	width:520px;
}
.users_search_form .line_field .input_inactive {
	color: #b1b1b1;
}
.bg_color2_selected {
	background-color:#FFFFFF;
}
{/literal}
</style>



<script language="javascript">
{literal}
var bg_color2_prev = null;
function bg_color2_over(obj)
{
	bg_color2_prev = obj.className;
	obj.className = "bg_color2_selected";
}
function bg_color2(obj)
{
	obj.className = bg_color2_prev;
}
function bg_color2_out(obj)
{
	obj.className = bg_color2_prev;
}
{/literal}
</script>
<form method="get" action="/{$ENV.section}/{$CONFIG.files.get.search.string}" name="search_user">

<table width="100%" cellpadding="6" cellspacing="0" align="center">

	<tr class="bg_color3">
		<td width="30%">
			<input type="text" style="width:100%;" name="firstname" value="{$search_form.firstname}" size="15"
			{if $search_form.defaults.firstname == $search_form.firstname} class="input_inactive"{/if}
			onfocus="if(this.value == '{$search_form.defaults.firstname|escape:"quotes"}') this.value= '';"
			onblur="if(this.value == ''){literal}{{/literal} this.className = 'input_inactive'; this.value= '{$search_form.defaults.firstname|escape:"quotes"}' {literal}}{/literal}"
			onkeyup="if(this.value == '{$search_form.defaults.firstname|escape:"quotes"}') this.className = 'input_inactive'; else this.className = '';" />
		</td>
		<td width="30%">
			<input type="text" style="width:100%;" name="lastname" value="{$search_form.lastname}" size="15"
			{if $search_form.defaults.lastname == $search_form.lastname} class="input_inactive"{/if}
			onfocus="if(this.value == '{$search_form.defaults.lastname|escape:"quotes"}') this.value= '';"
			onblur="if(this.value == ''){literal}{{/literal} this.className = 'input_inactive'; this.value= '{$search_form.defaults.lastname|escape:"quotes"}' {literal}}{/literal}"
			onkeyup="if(this.value == '{$search_form.defaults.lastname|escape:"quotes"}') this.className = 'input_inactive'; else this.className = '';" />
		</td>
		<td width="30%">
			<input type="text" style="width:100%;" name="midname" value="{$search_form.midname}" size="15"
			{if $search_form.defaults.midname == $search_form.midname} class="input_inactive"{/if}
			onfocus="if(this.value == '{$search_form.defaults.midname|escape:"quotes"}') this.value= '';"
			onblur="if(this.value == ''){literal}{{/literal} this.className = 'input_inactive'; this.value= '{$search_form.defaults.midname|escape:"quotes"}' {literal}}{/literal}"
			onkeyup="if(this.value == '{$search_form.defaults.midname|escape:"quotes"}') this.className = 'input_inactive'; else this.className = '';" />
		</td>
	</tr>
	<tr class="bg_color2" valign="top">
		<td width="30%">
			<b>Город:</b><br />		
			{php}
				STPL::Display('controls/location.inline', array(
					'code' 			=> $this->_tpl_vars['search_form']['city'],
					'result' 		=> 'city',
					'limit' 		=> array(
					),
					'important' 	=> array(
						Location::OL_CITIES => 1
					),
					'active_level' 	=> array(
						Location::OL_REGIONS	=> 1,
						Location::OL_DISTRICTS	=> 0,
						Location::OL_CITIES		=> 1,
						Location::OL_VILLAGES	=> 0,
						Location::OL_STREETS	=> 0,
					),
					'level_type' => array(
						Location::OL_CITIES		=> array_merge(
							(array) Location::ST_REGION_CENTER_CITY,
							Location::$TC_CITIES
						)
					),
				));
			{/php}
		</td>
		<td width="30%" align="right">
			<b>Возраст
			от</b> <input type="text" name="age_from" value="{$search_form.age_from}" size="2" maxlength="3"
			{if $search_form.defaults.age_from == $search_form.age_from} class="input_inactive"{/if}
			onfocus="if(this.value == '{$search_form.defaults.age_from|escape:"quotes"}') this.value= '';"
			onblur="if(this.value == ''){literal}{{/literal} this.className = 'input_inactive'; this.value= '{$search_form.defaults.age_from|escape:"quotes"}' {literal}}{/literal}"
			onkeyup="if(this.value == '{$search_form.defaults.age_from|escape:"quotes"}') this.className = 'input_inactive'; else this.className = '';" />
			<b>до</b> <input type="text" name="age_to" value="{$search_form.age_to}" size="2" maxlength="3"
			{if $search_form.defaults.age_to == $search_form.age_to} class="input_inactive"{/if}
			onfocus="if(this.value == '{$search_form.defaults.age_to|escape:"quotes"}') this.value= '';"
			onblur="if(this.value == ''){literal}{{/literal} this.className = 'input_inactive'; this.value= '{$search_form.defaults.age_to|escape:"quotes"}' {literal}}{/literal}"
			onkeyup="if(this.value == '{$search_form.defaults.age_to|escape:"quotes"}') this.className = 'input_inactive'; else this.className = '';" />
			<div style="margin-right:18px;margin-top:4px;"><input style="margin:0px;vertical-align:middle;" type="checkbox" id="cb_photo" name="photo" value="1" {if $search_form.photo}checked="checked"{/if}/>
		<label for="cb_photo"> <b>с фото.</b></label></div>
		</td>
		<td width="30%" align="right">
			<div style="margin-right:30px;margin-bottom:4px;"><b>Пол:</b>
			<input style="margin:0px; vertical-align:middle;" type="checkbox" id="g1" name="gender1" value="1" {if $search_form.gender1 == 1}checked="checked"{/if} />
			<label for="g1"><b>муж.</b></label></div>
			<div style="margin-right:31px;">
			<input style="margin:0px; vertical-align:middle;" type="checkbox" id="g2" name="gender2" value="1" {if $search_form.gender2 == 1}checked="checked"{/if} />
			<label for="g2"><b>жен.</b></label></div>
		</td>
	</tr>
	<tr class="bg_color3">
		<td colspan="3">
			<input type="submit" value="Искать"/>
		</td>
	</tr>
</table>

</form>

