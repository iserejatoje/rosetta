

{if sizeof($res)}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="block_title"><span>Кадровые центры</span></td>
</tr> 
</table>

			<table cellpadding="0" cellspacing="3" border="0" width="100%" class="table"> 
			{excycle values=" ,bg_color4"}
			{foreach from=$res item=l}
				{if trim($l.img_small.file) != ""}
				<tr valign="bottom">
					<td style="padding:5px;">
						<div {*style="border: 1px solid rgb(187, 198, 193);"*} align="center"><a href="{if $l.link}http://{$l.link}{else}/{$ENV.section}/vacancy/firm/{$l.fid}.php{/if}"  alt="{$l.fname|escape}{if !$l.link} ({$l.count|number_format:"0":",":" "}){/if}" title="{$l.fname|escape}{if !$l.link} ({$l.count|number_format:"0":",":" "}){/if}" {if $l.link}target="_blank"{/if}><img src="{$l.img_small.file}" width="{$l.img_small.w}" height="{$l.img_small.h}" alt="{$l.fname|escape}{if !$l.link} ({$l.count|number_format:"0":",":" "}){/if}" border="0"></a></div>
					</td>
				</tr>
				{else}
				<tr valign="bottom" class="{excycle}">
					<td><a href="{if $l.link}http://{$l.link}{else}/{$ENV.section}/vacancy/firm/{$l.fid}.php{/if}"  class="s1" alt="{$l.fname|escape}{if !$l.link} ({$l.count|number_format:"0":",":" "}){/if}" title="{$l.fname|escape}{if !$l.link} ({$l.count|number_format:"0":",":" "}){/if}" {if $l.link}target="_blank"{/if}>{$l.fname}</a> <span class="class="text11"">{if !$l.link}({$l.count|number_format:"0":",":" "}){/if}</span></td>
				</tr>
				{/if}
			{/foreach}
			</table>

{/if}