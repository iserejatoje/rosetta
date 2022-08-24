<div class="weather">
	{if sizeof($UERROR->ERRORS)}
		<div class="error" style="text-align:center;padding-top: 30px;"><span>{$UERROR->GetErrorsText()}</span></div>
	{else}
		{$page.weather_current}
		{$page.weather_10days}
	{/if}
</div>