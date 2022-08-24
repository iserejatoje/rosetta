<div align="center"><br /><br /><br /><br /><br /><br />
{if $res.status}Ваше SMS отправлено.
{else}Ошибка при отправлении{/if}<br />

<a href="javascript:void(0)" onclick="{$widget.instance}.beforeReload = widget_sms.prepareToDefault;{$widget.instance}.reload();{$widget.instance}.beforeReload = null;">отправить еще</a>
</div>