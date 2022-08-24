<div style="float:left">
	<h1>{if $res.TitleType==2 }
			{$res.TitleArr.name},<br/><font style="font-size:14px;font-weight:normal;">
			{$res.TitleArr.position}:<br/> <b>{$res.TitleArr.text}</b></font>
		{else}
			{$res.Title}
		{/if}
	</h1>
</div>
<br clear="both"/>
		

	{$res.Text}


{*<div style="float:right; width: auto; margin-left: 20px;">Просмотров: {$res.Views|number_format:0:" "}</div>*}
	