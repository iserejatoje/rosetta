<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank">{$GLOBAL.title[$BLOCK.section]}</a></td></tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
{foreach from=$BLOCK.res.list item=l}
        <tr>
                <td width="37">&nbsp;</td>
                <td valign="top" bgcolor="#F3F3F3">
                        <b>
                        {if $l.begin|date_format:"%m"==$l.end|date_format:"%m"}
                        {if $l.begin|date_format:"%e"!=$l.end|date_format:"%e"}{$l.begin|date_format:"%e"|replace:" ":""}-{/if}{$l.end|date_format:"%e"|replace:" ":""} {$l.begin|month_to_string:2}
                        {else}
                        {$l.begin|date_format:"%e"} {$l.begin|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.begin|date_format:"%Y"} {/if} -{$l.end|date_format:"%e"|replace:" ":""} {$l.end|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.end|date_format:"%Y"} {/if}
                        {/if}
                        </b>
                </td>
        </tr>
        <tr>
                <td width="37">&nbsp;</td>
                <td class=bok><a href="/{$BLOCK.section}/{$l.id}.html">{$l.name} ({$l.company})</a></td>
        </tr>
        <tr>
                <td width="37"><img src="/_img/x.gif" height="8"></td>
                <td><img src="/_img/x.gif" height="8"></td>
        </tr>
{/foreach}
        <tr>
                <td width="37">&nbsp;</td>
                <td>&nbsp;</td>
        </tr>
</table>