<input type="hidden" id="hinterests{$id}" value="" />
<div>{$title}</div>
<div id="interests{$id}"></div>
<div>
	<input type="text" id="addinterest{$id}" name="interest[{$id}]" value="" />
	<input type="button" value="Добавить" onclick="mp_interests.addInterest({$id});" />
</div>