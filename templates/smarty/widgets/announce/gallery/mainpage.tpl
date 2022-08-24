{if is_array($res.data)}

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span><a href="{$res.url}">Фотогалерея</a></span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>

<div style="padding-left:6px;">
{foreach from=$res.data item=l}
<div align="center" style="width: 130px; position:relative;float:left">

	<div style="width: 100px; height: 100px; background: {if $user.avatar!='' && $user.avatarurl}
		 		url('{$user.avatarurl}') 
			{else}
				url('{$l.thumb.url}') 
			{/if} no-repeat center;">
        <a href="{$l.url}"><img src="/_img/x.gif" border="0" width="100" height="100" /></a>
    </div>
	
	<div style="padding: 4px;">
		<a href="{$l.url}">{$l.title|truncate:50}</a>
		{if $l.count > 0}
			{*<sup class="tip">{$l.count}</sup>*}
			<br/><span class="tip">Фотографий: <b>{$l.count}</b></span>
		{/if}
	</div>
</div>
{/foreach}
</div>
<div style="margin-bottom:30px;clear:both;"></div>
{/if}