<div class="fcontrol" style="padding: 10px 0px 10px 0px">
Сейчас на сайте:
{if is_array($res.data) && sizeof($res.data)>0}
{assign var=cnt value=0}
{foreach from=$res.data item=l}
{if $cnt == 1}, {/if}<a href="{$l.infourl}">{$l.showname}</a>{assign var=cnt value=1}
{/foreach}
{else}
никого нет
{/if}
</div>
