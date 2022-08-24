{if sizeof($res) && sizeof($res.list)}
<div class="announce">
	<div class="colored-wrapper">
		<div class="title">
			<a href="/service/go/?url={$res.title_url}" target="_blank">{$res.title}:</a>
		</div>
		
		<div class="content">
			{foreach from=$res.list item=l}
				<div class="line">
					<a href="/service/go/?url={$res.title_url}{$l.sale}/{$l.link}/" target="_blank">{$l.name|truncate:30}</a> <span class="count">(<span>{$l.cnt|number_format:0:' ':' '}</span>)</span>
				</div>
			{/foreach}
		</div>
	</div>
</div>
{/if}