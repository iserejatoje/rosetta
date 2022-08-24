{if !isset($margin)}
	{assign var="margin" value=true}
{/if}

{if $margin === true}
<div style="margin-right:3px; margin-bottom:3px;">
{/if}
<div>
	<div style="width: {$width}px; height: {$height}px; background: {if $photo!=''}
		 		url('{$photo}') 
			{else}
				url('{$nophoto}') 
			{/if} no-repeat center; padding-top:2px;">
        {if $url}<a href="{$url}"><img src="/_img/x.gif" border="0" width="100" height="100" /></a>{/if}
    </div>
	<div style="padding:4px" align="center" class="pcomment">{if $url}<a href="{$url}">{/if}{$text|truncate:15}{if $url}</a>{/if}</div>
</div>
{if $margin === true}
</div>
{/if}