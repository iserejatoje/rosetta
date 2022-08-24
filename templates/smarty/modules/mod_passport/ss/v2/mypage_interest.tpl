<script src="/_scripts/modules/passport/interest_v2.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">{literal}
	mp_interests.setGroupTemplate('<div id="customgroup${id}"><input type="hidden" id="hinterests${id}" value="" />'+
		'<div><a href="javascript:void(0);" onclick="mp_interests.removeGroup(${id});">${title}</a></div>'+
		'<div id="interests${id}"></div>'+
		'<div>'+
			'<input type="text" id="addinterest${id}" name="interest[${id}]" value="" />'+
			'<input type="button" value="Добавить" onclick="mp_interests.addInterest(${id});" />'+
		'</div></div>');
{/literal}</script>
<div class="title" style="padding: 5px;">Интересы</div>
<p>Укажите ваши интересы и найдите единомышленников!</p>
<br>
<div style="padding-left: 50px">
{foreach from=$page.groups item=l}
{if !$l.isbase}<div id="customgroup{$l.id}">{/if}
	<input type="hidden" id="hinterests{$l.id}" value="{foreach from=$l.interests item=l2 name=f}{$l2.title}{if !$smarty.foreach.f.last}|{/if}{/foreach}" />
	<div>{if !$l.isbase}<a href="javascript:void(0);" onclick="mp_interests.removeGroup({$l.id});">{$l.title}</a>{else}{$l.title}{/if}</div>
	<div id="interests{$l.id}">{foreach from=$l.interests item=l2 name=f}<a href="javascript:void(0);" onclick="mp_interests.removeInterest('{$l.id}', '{$l2.title}');">{$l2.title}</a>{if !$smarty.foreach.f.last}, {/if}{/foreach}</div>
	<div>
		<input type="text" id="addinterest{$l.id}" name="interest[{$l.id}]" value="" />
		<input type="button" value="Добавить" onclick="mp_interests.addInterest({$l.id});" />
	</div>
	<script language="javascript" type="text/javascript">mp_interests.addSuggest('addinterest{$l.id}', {$l.id});</script>
{if !$l.isbase}</div>{/if}
{/foreach}
	<div id="groups_add_place"></div>
</div>
<div>
	Добавить свою группу <br />
	<input type="text" id="addgroup" />
	<input type="button" value="Добавить" onclick="mp_interests.addGroup();" />
</div>
<br/><br/>