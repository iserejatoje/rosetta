<table width="100%" border="0" cellspacing="0" cellpadding="20">
	<tr> 
		<td>

			<form id="frm_search" name="frm_search" action="/{$ENV.section}/{$CONFIG.files.get.search.string}" method="get" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="sortby" value="{$page.form.params.sortby}" />
				<input type="hidden" name="where" value="{$page.form.params.where}" />
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr valign="top" align="left">
						<td colspan="3" height="10px"></td>
					</tr>
					<tr valign="top" align="left">
						<td colspan="3" style="padding-left: 80px;">
							<b>Я ищу:</b><input onkeyup="search_make_desc();" type="text" name="query" style="width:500px;" value="{$page.form.query}" />
						</td>
					</tr>
					<tr valign="top" align="left">
						<td colspan="3" height="30px"></td>
					</tr>
					<tr valign="top" align="left">
						<td width="33%">
							{* 1 *}
							<b>Искомые слова расположение на странице:</b><br>
							<div style="padding-left:20px">
								{foreach from=$page.form.arr_in item=l key=k}
									<input onclick="search_make_desc();" type="radio" name="a_in" id="a_in_{$k}" 
									value="{$k}"{if $page.form.params.a_in==$k} checked="checked"{/if} />
									<label id="a_in_{$k}_lab" for="a_in_{$k}">{$l}</label><br/>
								{/foreach}
							</div>
						</td>
						
						<td width="34%">
							{* 2 *}
							<b>Искомые слова встречаются в тексте:</b><br>
							<div style="padding-left:20px">
								{foreach from=$page.form.arr_spell item=l key=k}
								<input onclick="search_make_desc();" type="radio" name="a_spell" id="a_spell_{$k}" 
								value="{$k}"{if $page.form.params.a_spell==$k} checked="checked"{/if} />
								<label id="a_spell_{$k}_lab" for="a_spell_{$k}">{$l}</label><br />
								{/foreach}
							</div>		
						</td>
						<td width="33%">{* 3 *}</td>
					</tr>
					<tr>
						<td colspan="3" height="15px"></td>
					</tr>
					<tr>
						<td colspan="3" bgcolor="#CCCCCC"><img src="/_img/x.gif" height="1px" width="1px" border="0" /></td>
					</tr>
					<tr><td colspan="3" height="15px"></td></tr>
					
					<tr valign="top" align="left">
						<td width="33%">
							{* 4 *}
							<b>Тематика страниц:</b><br>
							<div style="padding-left:20px">
							{if count($page.form.arr_t)>0}
								{foreach from=$page.form.arr_t item=l key=k}
									<input onclick="search_make_desc();" type="radio" name="a_t" id="a_t_{$k}" 
									value="{$k}"{if $page.form.params.a_t==$k} checked="checked"{/if} />
									<label id="a_t_{$k}_lab" for="a_t_{$k}">{$l}</label><br/>
								{/foreach}
							{/if}
							</div>
						</td>

						<td width="34%">
							{* 5 *}
							<b>Где искать:</b><br>
							<select name="a_c" style="width:90%" onchange="search_make_desc();">
								<option value="0"{if !$page.form.params.a_c} selected="selected"{/if}>где угодно</option>
								{if count($page.form.arr_c)>0}
									{foreach from=$page.form.arr_c item=l}
										{if count($l.nodes)>0}
										<option value="{$l.id}"{if $page.form.params.a_c==$l.id} selected="selected"{/if} >{$l.name}</option>
										{foreach from=$l.nodes item=l1}
											<option value="{$l1.id}"{if $page.form.params.a_c==$l1.id} selected="selected"{/if} >{$l1.name|indent:1:"&nbsp;-&nbsp;&nbsp;"}</option>
										{/foreach}
										{/if}
									{/foreach}
								{/if}
							</select>
						</td>
						
						<td width="33%">{* 6 *}</td>
					</tr>
					<tr valign="top" align="left">
						<td colspan="3" height="20px"></td>
					</tr>
				</table>

				<table width="100%" border="0" cellspacing="0" cellpadding="5" class="bg_color2">
					<tr> 
						<td style="padding-left:200px;" id="search_td_desc">&nbsp;</td>
					</tr>
					<tr> 
						<td style="padding-left:200px;"><input type="submit" style="width:74px;" value="Найти" /></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>

<script type="text/javascript" language="javascript">
{literal}
<!--
var search_td_desc = document.getElementById('search_td_desc');
var frm_search = document.getElementById('frm_search');
var search_cat_arr = new Array();
var search_cat_arr_index = new Array();
var re = new RegExp("(<[^>]*>)","ig");

{/literal}
{assign var="i" value="0"}
{if count($page.form.arr_c)>0}
{foreach from=$page.form.arr_c item=l key=k}
search_cat_arr[{$i}] = "на сайте {$l.name}";
search_cat_arr_index[{$i}] = "{$l.id}";
{assign var="i" value="`$i+1`"}
{foreach from=$l.nodes item=l1}
search_cat_arr[{$i}] = "в разделе {$l1.name}";
search_cat_arr_index[{$i}] = "{$l1.id}";
{assign var="i" value="`$i+1`"}
{/foreach}
{/foreach}
{/if}
{literal}


function search_make_desc(){
	text = "";
	
	if(frm_search.query.value)
	{
		for (var i = 0; i < frm_search.a_in.length; i++)
		{
			if(frm_search.a_in[i].checked) text = text + ', ' + 'встречаются на странице ' + document.getElementById('a_in_'+frm_search.a_in[i].value+'_lab').innerHTML;
		}
		for (var i = 0; i < frm_search.a_spell.length; i++)
		{
			if(frm_search.a_spell[i].checked) text = text + ', ' + 'употребляются в тексте ' + document.getElementById('a_spell_'+frm_search.a_spell[i].value+'_lab').innerHTML;
		}
		for (var i = 0; i < frm_search.a_t.length; i++)
		{
			if(frm_search.a_t[i].checked) text = text + ', ' + 'тематика - ' + document.getElementById('a_t_'+frm_search.a_t[i].value+'_lab').innerHTML;
		}
		if(frm_search.a_c.value > 0)
		{
			for (var i = 0; i < search_cat_arr_index.length; i++)
			{
				if(search_cat_arr_index[i]==frm_search.a_c.value) break;
			}
			text = text + ', ' + search_cat_arr[i];
		}
	
		text = "Искать " + '<b>&laquo;'+ frm_search.query.value.replace(re, '') +'&raquo;</b>' + text;
	}
	
	search_td_desc.innerHTML = (text?text:'&nbsp;');
}

search_make_desc();
//-->
{/literal}
</script>