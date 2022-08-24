{if $res.state=="advanced"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="middle">
	<td height="25px" align="right" style="padding-right:50px;"><a href="/{$ENV.section}/">простой поиск</a></td>
</tr>
</table>




{else}
{*<script type="text/javascript" language="javascript">{literal}
	$(document).ready(function(){
		var word = '{/literal}{$res.word.Word}{literal}';
		var query = '{/literal}{$res.query}{literal}';
		var form = $($("#query").attr('form'));
		var el = $("#query");

		if (!word || query.length != 0)
			el.focus();
		else {
			el.css('color', '#CCCCCC').val(word);
			var change = function() {
				if (word && el.attr('_clear') !== true)
					el.val('');

				el.attr('_clear', true);
				el.css('color', '');
			}

			el.one(($.browser.opera ? "keypress" : "keydown")+' click', change);
			//el.one('click', change);
			form.one('submit', function() {
				if (word && el.attr('_clear') !== true)
					this.wordid.value = {/literal}{if $res.word.WordID}{$res.word.WordID}{else}0{/if}{literal};
			});
		}

	});{/literal}
</script>*}

{include file="`$CONFIG.templates.ssections.words`" word="`$res.word`" query="`$res.query`" query_field="query"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="middle">
	<td style="padding-left:10px;padding-right:10px;" class="bg_color2">


		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<form name="frm_search" action="/{$ENV.section}/{$CONFIG.files.get.search.string}" method="get" enctype="application/x-www-form-urlencoded">
		<input type="hidden" name="sortby" value="{$res.sortby}" />
		<input type="hidden" name="a_t" value="{$res.a_t}" />
		<input type="hidden" name="a_spell" value="{$res.a_spell}" />
		<input type="hidden" name="a_c" value="{$res.a_c}" />
		<input type="hidden" name="adv_params" value="{$res.adv_params}" id="adv_params" />
		<input type="hidden" name="wordid" value="0" />
		<tr>
			<td align="left" colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" /></td>
		</tr>
		<tr>
			<td align="left">&nbsp;</td>
			<td align="center" style="padding-left:10px;" class="txt_color4">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" /></td>
		</tr>
		<tr>
			<td width="65%"><input type="text" name="query" id="query" style="width:100%;font-size: 17px;" value="{$res.query}" /></td>
			<td align="left" style="padding-left:10px;"><input type="submit" style="width:100px;font-size: 17px;" value="Найти" /> <nobr>&nbsp;&nbsp;{if $CURRENT_ENV.regid==74}<span style="padding-bottom: 2px;"><a href="/{$ENV.section}/top.php" style="font-size: 10px;">Top 100 запросов</a>{else}&nbsp;{/if}</span></nobr></td>
		</tr>
		<tr>
			<td align="left">
			<input onclick="_ChangeWhere(this.form);" type="radio" id="where_3" name="where" value="3"{if !in_array($res.where, array(1, 2)) || $res.where == 3} checked="checked"{/if} /><label for="where_3">на {$CURRENT_ENV.site.domain}</label>
			&nbsp;&nbsp;
			<input onclick="_ChangeWhere(this.form);" type="radio" id="where_2" name="where" value="2"{if $res.where == 2} checked="checked"{/if} /><label for="where_2">в {$CURRENT_ENV.site.name_where}</label>
			&nbsp;&nbsp;
			<input onclick="_ChangeWhere(this.form);" type="radio" id="where_1" name="where" value="1"{if $res.where == 1} checked="checked"{/if} /><label for="where_1">в Интернете</label>
			</td>
			{* <td align="center"><a href="/{$ENV.section}/help.php">помощь</a></td> *}
		</tr>
		<tr id="where_3_add">
			<td align="left" colspan="2">
{*if $res.where == 3}
	{if isset($res.a_c) && $res.a_c > 0}
			<input type="checkbox" name="a_c" value="{$res.a_c}" id="where_3_cat" checked="checked" /><label for="where_3_cat">
		{if $res.section.type == 1}
			на сайте {$res.section.name}
		{else}
			в разделе {$res.section.name}{if !empty($res.section.parent)} на сайте {$res.section.parent.name}{/if}
		{/if}
			</label>
			&nbsp;&nbsp;
	{/if}
{/if*}
			</td>
		</tr>
		</form>
		</table>


	</td>
</tr>
</table>

{/if}