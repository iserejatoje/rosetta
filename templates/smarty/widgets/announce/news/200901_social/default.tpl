{if is_array($res) && sizeof($res.data)}
<div class="block_info">

		<div class="title_trsp">
			<div class="left">
				<div>Новости</div>
			</div>
		</div>

		<div class="widget_content">

			<div class="news_content">

				{if is_array($res.data) && sizeof($res.data)}
					<ul class="list">
					{foreach from=$res.data item=l}
						<li>
							<b><a href="/community/{$res.obj_id}/news/{$l.NewsID}.php" title="{$l.Text|truncate:50|escape:'html'}">{$l.Title}</a></b><br/>
							<span class="info">
								{if $l.User}{$l.User->Profile.general.ShowName}, {/if}
								<span class="date">{$l.Created|simply_date}</span>
							</span>
						</li>
					{/foreach}
					</ul>
				{/if}
			</div>
			{if  $res.count > sizeof($res.data) || $res.can_add=== true}
			<div class="actions_panel">
				<div class="actions_rs">
					{if  $res.count > sizeof($res.data)}<a href="/community/{$res.obj_id}/news/last.php">Все события</a>{/if}
					{if  $res.count > sizeof($res.data) && $res.can_add=== true}<br/>{/if}
					{if $res.can_add=== true}<a href="/community/{$res.obj_id}/news/edit.php">Создать новость</a>{/if}
				</div>
			</div>
			<br clear="both"/>
			{/if}
		</div>
</div>
{/if}
