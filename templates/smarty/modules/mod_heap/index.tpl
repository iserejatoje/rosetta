<html>
<head>
{$TITLE->Head}
{literal}
<script type="text/javascript">
tinyMCE_GZ.init({
	mode: 'none'
});

function toggleEditor(id) {
	if (!tinyMCE.getInstanceById(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}

</script>
{/literal}

</head>
<body>
В Челябинске сейчас: {$smarty.now|date_format:"%d.%m.%Y %T"}
<form method="POST">
	<input type="hidden" name="action" value="refresh">
	<div align="center">
		<input type="submit" value="Обновить">
	</div>
</form>
<div style="text-align: left;">
<form method="POST" id="form_filter">
	<input type="hidden" name="action" value="apply_filter">
	<div style="float: right; width:300px; position: ralative;">
		<div style="position: absolute; width:292px; z-index: 99; background-color: #FFFFCE; border: 1px solid #BFBF00; padding: 4px; font-size: 10px;">
			<span style="cursor: hand; cursor: pointer; font-size: 12px; color: red;" onclick="{literal}var f1 = document.getElementById('filter_list_item'); if(f1.style.display == 'block'){f1.style.display = 'none';}else{f1.style.display = 'block';}{/literal}"
			><b>{$page.groups_[$page.group_selected].title}:</b></span><br />
			<div style="display: none; cursor: default; height: 400px; overflow: auto;" id="filter_list_item">
{foreach from=$page.groups_[$page.group_selected].sections key=k item=l}
			{$l}<br />
{/foreach}
			</div>	
		</div>	
	</div>
	<div>
		<select name="group">
{foreach from=$page.groups item=l}
	{if sizeof($l.children) > 0}
	<optgroup label="{$l.title}">
	{foreach from=$l.children key=key item=val}
			<option value="{$key}"{if $key==$page.group_selected} selected="selected"{/if}>{$val.title}</option>
	{/foreach}
	</optgroup>
	{/if}
{/foreach}
		</select>
		<input type="submit" value="Применить">
	</div>
</form>
</div>
<form method="POST" id="form_apply" onsubmit="return form_apply_submit();">
	<input type="hidden" name="change_filter_on_the_fly" value="" />
	<input type="hidden" name="action" value="apply">
	<table border="1" width="100%">
{foreach from=$page.res key=k item=l}
		<tr valign="top">
			<td nowrap="nowrap" id="_commands{$l.key}" width="1px">
{foreach from=$l.commands item=cs}
{foreach from=$cs item=c}
				<div style="padding: 3px; height: 25px; {if $c.default==true}font-weight: bold; background-color: rgb(203, 232, 191);{else}font-weight: normal;{/if}">
				
				<label style="display:block;white-space:nowrap;">
				<input onclick="
					$('#_commands{$l.key} > div').css('font-weight', 'normal').css('backgroundColor', 'rgb(255, 255, 255)'); $($(this).get(0).parentNode.parentNode).css('font-weight', 'bold').css('backgroundColor', 'rgb(203, 232, 191)');" type="radio" name="act[{$l.section}][{$l.key}]" value="{$c.action}" {if $c.default==true} checked="checked"{/if}>&nbsp;{$c.title}</label>
			</div>
{/foreach}
{/foreach}
			</td>
			<td valign="top"><b>{$l.site_title} - {$l.section_title}{if !empty($l.subsection_title)} - {$l.subsection_title}{/if}</b><br>{include file="`$l.template`" params=$l.list parent=$l}</td></tr>
{/foreach}
	</table><br>
	<div align="center">
		<input type="checkbox" name="ch_change_filter_on_the_fly" id="ch_change_filter_on_the_fly"
			title="Поставьте галочку, если после сохранения хотите поменять фильтр на указанный вверху страницы." /><label for="ch_change_filter_on_the_fly"> Сменить фильтр</label>
		<input type="submit" value="Применить"> <input type="reset" value="Сброс"> 
	</div>
</form>

<script type="text/javascript" language="javascript">

{literal}	
	var form_filter = document.getElementById('form_filter');
	var form_apply = document.getElementById('form_apply');
	function form_apply_submit()
	{
		if(form_apply.ch_change_filter_on_the_fly.checked)
		{
			form_apply.change_filter_on_the_fly.value = form_filter.group.value;
		}
		else
		{
			form_apply.change_filter_on_the_fly.value = '';
		}
		return true;
	}
{/literal}

</script>

</body>
</html>
