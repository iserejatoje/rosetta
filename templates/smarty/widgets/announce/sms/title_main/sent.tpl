<div class="message">
{if $res.status}Ваше SMS отправлено.
{else}Ошибка при отправлении{/if}<br />

<a class="servicebig" href="javascript:void(0)" onclick="{$widget.instance}.beforeReload = widget_sms.prepareToDefault;{$widget.instance}.reload();{$widget.instance}.beforeReload = null;">отправить еще</a>
</div>