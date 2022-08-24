<div class="announce">
	<div class="colored-wrapper">
		<div class="title">
			<a href="/service/go/?url={"`$res.url`"|escape:"url"}" target="_blank">Продажа:</a>
		</div>
		
		<div class="content">
			<div class="line">
				<a href="/service/go/?url={"`$res.url`list_status/4/1.php"|escape:"url"}" target="_blank">Залоговое имущество</a> <span class="count">(<span>{$res.status_count[4]|number_format:0:' ':' '}</span>)</span>
			</div>
			<div class="line">
				<a href="/service/go/?url={"`$res.url`list_status/5/1.php"|escape:"url"}" target="_blank">Арестованное имущество</a> <span class="count">(<span>{$res.status_count[5]|number_format:0:' ':' '}</span>)</span>
			</div>
		</div>
	</div>
</div>