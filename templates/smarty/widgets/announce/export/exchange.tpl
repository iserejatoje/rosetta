{foreach from=$res.cb item=l}{if $l.cost}{$l.cur_name} = {$l.cost|number_format:2:'.':' '} {/if}{/foreach}
