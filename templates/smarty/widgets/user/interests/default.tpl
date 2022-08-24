{if sizeof($res.list) || !empty($res.about)}
<div class="block_info">
	<div class="title title_lt">
		<div class="left">
			<div class="actions">{if $res.UserID == $USER->ID}<span class="edit"><a href="/{$CURRENT_ENV.section}/mypage/interest.php">редактировать</a></span>{/if}</div>
			<div>Интересы</div>
		</div>
	</div>
	<div class="widget_content">
{if sizeof($res.list)}
		<div class="content">
			<div style="width: 48%;float:left">
				<div class="user_info_interest" style="padding-right: 15px;">
					{foreach from=$res.list item=g name=g}			
						{if $g.id>0 && $smarty.foreach.g.iteration % 2 != 0}
						<div class="section">
							{$g.title}
							<div class="interest">
							{foreach from=$g.interests item=i name=interest}
								<a href="/svoi/users/interest/{$i.id}/">{$i.title}{if $i.count} ({$i.count|number_format:0:'':' '}){/if}</a>{if !$smarty.foreach.interest.last}, {/if}
							{/foreach}
							</div>
						</div>
						{/if}
					{/foreach}
				</div>
			</div>
			<div style="width: 48%;float:left">
				<div class="user_info_interest" style="padding-left: 15px;">
					{foreach from=$res.list item=g name=g}			
						{if $g.id>0 && $smarty.foreach.g.iteration % 2 == 0}
						<div class="section">
							{$g.title}
							<div class="interest">
							{foreach from=$g.interests item=i name=interest}
								<a href="/svoi/users/interest/{$i.id}/">{$i.title}{if $i.count} ({$i.count|number_format:0:'':' '}){/if}</a>{if !$smarty.foreach.interest.last}, {/if}
							{/foreach}
							</div>
						</div>
						{/if}
					{/foreach}
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
{/if}
{if !empty($res.about)}
		<div style="width: 160px;" class="subtitle title_rb">
			<div class="left">
				<div>Мои&nbsp;увлечения</div>
			</div>
		</div>
		<div class="content">	
			<div class="user_info_interest">
				<div class="section">
					<div class="interest">{$res.about}</div>
				</div>
			</div>
		</div>
{/if}
	</div>
</div>
{/if}