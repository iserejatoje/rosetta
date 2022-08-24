{if (isset($res.cars) && sizeof($res.cars)) || (isset($res.anketa) && sizeof($res.anketa)) }
<div class="block_info">
	<div class="title title_lt">
		<div class="left">
			<div class="actions">{if $res.UserID == $USER->ID}<span class="edit"><a href="/{$CURRENT_ENV.section}/mypage/auto.php">редактировать</a></span>{/if}</div>
			<div>Авто</div>
		</div>
	</div>
	<div class="widget_content">
		<div class="content">
		
			{if sizeof($res.cars) }
			<div class="user_info_auto">		
				<div class="list">
				{foreach from=$res.cars item=car}
					<div>
						<a href="/passport/users_auto.php?s=1&subpage=auto&marka={$car.MarkaID}&model={$car.ModelID}"><span class="marka">{$car.MarkaName}</span> {$car.ModelName}{if $car.Count} ({$car.Count|number_format:0:'':' '}){/if}</a>{if $car.Year>0}, {$car.Year} г.в.{/if}{if $car.Volume>0}, {$car.Volume} см<sup>3</sup>{/if}, {if $car.WheelType==1}правый{else}левый{/if} руль</div>
				{/foreach}
				</div>	
			</div><br clear="both"/>
			{/if}
			
			{if sizeof($res.anketa) }
			<div>
				<table style="position: relative" cellspacing="0" cellpadding="0" class="user_info_auto_interests">			
					{foreach from=$res.anketa item=q}
						{if count($q.answer) > 0}
						{assign var=question_id value=$q.question_id|strtolower}
						<tr class="field">
							<td class="key">{$q.question}:</td><td>
							{foreach from=$q.answer item=q2 name=f}
							{if $q2.id > 0}
								<a href="/passport/users_auto.php?s=1&subpage=anketa&Anketa[{$q.question_id}]={$q2.id}">{$q2.answer}{if isset($res.counter[$question_id][$q2.id]) && $res.counter[$question_id][$q2.id]} ({$res.counter[$question_id][$q2.id]|number_format:0:'':' '}){/if}</a>{if !$smarty.foreach.f.last}, {/if}
							{else}
								{$q2.answer}{if !$smarty.foreach.f.last}, {/if}
							{/if}
							{/foreach}
							</td>
						</tr>
						{/if}
					{/foreach}
				</table>
			</div>
			{/if}
		</div>
	</div>
</div>
{/if}