{include file="design/rosetta/header.tpl"}
	{if $BLOCKS.center.mainslider}
	 	{$BLOCKS.center.mainslider}
	{/if}


	{if $BLOCKS.center.catalog}
		{$BLOCKS.center.catalog}
	{/if}

	{foreach from=$BLOCKS.main item=block}{$block}{/foreach}
{include file="design/rosetta/footer.tpl"}