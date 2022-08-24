<style>
{literal}
.domain_select {
	padding-top:2px;
	padding-bottom:2px;
}
{/literal}
</style>

<div class="title">Выбери себе адрес!</div>
{*<p>Вы можете выбрать себе коротки адрес. Бла-бла-бла, бла-бла-бла. Бла-бла-бла, бла-бла-бла. Бла-бла-бла, бла-бла-бла. Бла-бла-бла, бла-бла-бла. Бла-бла-бла, бла-бла-бла. Бла-бла-бла, бла-бла-бла.</p>*}
<br />
{if empty($page.domain)}
<div>
	<input type="hidden" id="NameDomainType" value="{$page.Type}">
	<input type="hidden" id="ObjectID" value="{$page.ObjectID}">
	<input type="text" value="{$smarty.get.d}" name="Name" style="vertical-align:middle; width:150px;" id="NameDomain"><span class="title">.{$page.TitleDomain}</span>
	&nbsp;&nbsp;&nbsp;<input type="button" value="Выбрать" onClick="choose_domain.getDomain(0);" id="NameDomainTryButton">
	<div class="tip">
		Длина адреса должна быть от {$CONFIG.limits.min_domain_name_len} до {$CONFIG.limits.max_domain_name_len} символов из списка: a-z, 0-9, "-".<br>
	</div>
</div>
<div style="display: none; padding-bottom: 4px; height: 18px;" id="NameDomainLoading">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<img src="/_img/modules/block_forum/wait.gif"/>
			</td>
			<td>
				<b>Подождите, идет проверка...</b>
			</td>
		</tr>
	</table>
</div>
<div id="NameDomainMessages" style="display:none;">
</div>
<div id="NameDomainResult" style="display:none; width:300px;padding:1px;margin-top:10px;" class="bg_color3">
	<div class="bg_color4" style="padding:10px;" id="NameDomainResultText">
	</div>
</div>
{else}
<div id="my_domain">
<b>Ваш адрес:</b>
<a href="http://{$page.domain.Name}.{$page.domain.Domain}" target="_blank" class="title">{$page.domain.Name}.{$page.domain.Domain}</a>
<span class="tip" style="margin-left:10px;">
	<a href="javascript:void(0);" onClick="choose_domain.ChangeDomain()">изменить</a>
	<a href="javascript:void(0);" onClick="choose_domain.DeleteDomain()">удалить</a>
</span>
</div>
<div id="edit_domain" style="display:none">
	<input type="hidden" id="NameDomainType" value="{$page.Type}">
	<input type="hidden" id="ObjectID" value="{$page.ObjectID}">
	<input type="text" value="{$page.domain.Name}" name="Name" style="vertical-align:middle; width:150px;" id="NameDomain"><span class="title">.{$page.TitleDomain}</span>
	&nbsp;&nbsp;&nbsp;<input type="button" value="Выбрать" onClick="choose_domain.getDomain(1);" id="NameDomainTryButton">
	<input type="button" value="Отмена" onClick="choose_domain.CancelDomain();">
<div style="display: none; padding-bottom: 4px; height: 18px;" id="NameDomainLoading">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<img src="/_img/modules/block_forum/wait.gif"/>
			</td>
			<td>
				<b>Подождите, идет проверка...</b>
			</td>
		</tr>
	</table>
</div>
<div id="NameDomainMessages" style="display:none;">
</div>
<div id="NameDomainResult" style="display:none; width:300px;padding:1px;margin-top:10px;" class="bg_color3">
	<div class="bg_color4" style="padding:10px;" id="NameDomainResultText">
	</div>
</div>
</div>
{/if}