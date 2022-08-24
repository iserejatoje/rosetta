{*ширина уменьшеня со 136 до 130, чтобы при разрешении 1024 в строку входило 4 пользователя*}

{if !isset($margin)}
	{assign var="margin" value=true}
{/if}

{if $margin === true}
<div style="margin-right:3px; margin-bottom:3px;">
{/if}
<div align="center" style="width: 178px; height:168px;  margin:2px; padding:1px;" class="bg_color3">
	<div class="bg_color4" style="width: 178px; height:168px;">
	{if $user.anonymous !== true}
	<div style="width: 100px; height: 100px; background: {if $user.avatar!='' && $user.avatarurl}
		 		url('{$user.avatarurl}') 
			{else}
				url('/_img/modules/passport/user_unknown.gif') 
			{/if} no-repeat center; padding-top:2px;">
        <a href="{$user.infourl}"><img src="/_img/x.gif" border="0" width="100" height="100" /></a>
    </div>
	<div style="padding:4px" class="text11"><a href="{$user.infourl}"><b>{if !empty($name_color)}<font color="{$name_color}">{/if}{$user.showname|truncate:30}{if !empty($name_color)}</font>{/if}</b></a></div>
	{if $user.showvisited}
	<div class="tip" style="margin-bottom: 5px;">{$user.showvisited|user_online:"%f %H:%M":"%d %F":$user.gender}</div>    
	{/if}
	<div class="tip"><a href="javascript:void(0)" onclick="{$user.replyjs}return false;">отправить сообщение</a></div>
	{else}
	<div style="width: 100px; height: 100px; background: url('/_img/modules/passport/user_unknown.gif') no-repeat center;">
		<img src="/_img/x.gif" border="0" width="100" height="100" />
	</div>

	<div style="padding:4px"><a>Анонимный пользователь</a></div>
	
	{/if}
	</div>
</div>

{if $margin === true}
</div>
{/if}
