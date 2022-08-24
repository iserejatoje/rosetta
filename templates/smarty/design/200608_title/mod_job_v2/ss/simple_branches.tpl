{if isset($res.selected_branches[$aid])}
{$res.selected_branches[$aid]}
{elseif isset($res.other_position[$aid])}
{$res.other_position[$aid]}
{else}не указана{/if}