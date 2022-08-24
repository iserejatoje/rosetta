{* 
	:TODO:
	
	TRASH
	
	Переменные из модуля на прямую в смарти отдаваться не должны.
	Каждый логический блок должен генерироваться отдельным методом.
	
	Всё что идет ниже не верно!!!
*}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="t5gb" align="center"><br/><br/>Вакансии&nbsp;по&nbsp;рубрикам</td>
</tr>
<tr>
	<td>
		<table cellpadding="0" cellspacing="5" border="0" width="100%">
        {foreach from=$razdel item=l}
            {capture name="link"}/{$CURRENT_ENV.section}/{/capture}
            {capture name="target"}{/capture}
			<tr>
				<td class="t7"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" hspace="2" />&#160;<a class="s1" 
					href="{$smarty.capture.link}?cmd=vaclst&rid={$l.rid}&p=1" 
					{$smarty.capture.target}>{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname} [{$l.vcount|number_format:"0":",":" "}]{if $l.rid==22 || $l.rid==23}</font>{/if}</a>
				</td>
            </tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>