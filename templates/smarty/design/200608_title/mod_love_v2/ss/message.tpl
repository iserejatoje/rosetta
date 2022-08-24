{foreach from=$res.list item=l}
{if !$l.isnew}<img src="/img/love/001.gif" alt="письмо прочитано">
{else}<img src="/img/love/002.gif" alt="письмо не прочитано">
{/if}&#160;<font color="#{if $l.uid == $res.uid}990000{else}2297C6{/if}">
<b>{$res.userFROM}</b> 
{$l.date|date_format:"%d.%m.%Y"} в {$l.date|date_format:"%H:%M"}<br>{$l.msg}</font><hr color="#A0CADB" width=100 size=1 align=left>
{/foreach}