{if is_array($res.list) && sizeof($res.list)}
<div class="block_info">
	<div class="title title_lt">
		<div class="left">
			<div>
				<div class="actions"><span class="edit"><a href="/user/{$res.userid}/gallery/ratings.php">Все оценки</a></span></div>
				<div>Оценки</div>
			</div>
		</div>
	</div>
	
	{foreach from=$res.list item=photos key=albumid}
		{foreach from=$photos item=arr key=photoid}	
			{foreach from=$arr.votes item=vote}
				<div class="float_left">						
					{include file=$config.templates.voted_photo photo=$arr.photo vote=$vote}
				</div>	
			{/foreach}
		{/foreach}
	{/foreach}
{/if}