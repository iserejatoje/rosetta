<a href="{$LIST.url}"><img src="/img/{$LIST.logo}" border="0" vspace="2" align="right"></a>
{$LIST.block}
<table cellpadding="3" cellspacing="0" border="0" width="100%">
<tr>
{foreach from=$LIST.links item=l name=lks key=k} 
{if ($k%2)}<td>{/if}
<a class="t9" href="{$LIST.url}/{$l.path}/" target="_blank" {if $l.imp}style="color:red;"{/if}>{$l.name}</a>
{if ($k%2)}<br/><img src="/_img/x.gif" width="1" height="3" /><br/>{/if}
{if !($k%2)}</td>{/if}
{/foreach}
</tr>
</table>