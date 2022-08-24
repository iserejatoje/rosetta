{if $smarty.get.print}
	<script language="javascript">
	{literal}
	<!--
	window.print();
	-->
	{/literal}
	</script>
{else}
	<div align="right" class="text11" style="padding-bottom:2px">
		<a onclick="window.open('about:blank', 'rprint','width=760,height=500,resizable=1,menubar=0,scrollbars=1').focus();" href="/{$ENV.section}/search.php?station_from={$smarty.get.station_from}&station_to={$smarty.get.station_to}&date={$smarty.get.date}{if $smarty.get.back}&back=1{/if}{if $smarty.get.with_transfer}&with_transfer=1{/if}&print=1" target="rprint">Версия для печати</a>
	</div>
{/if}

{if isset($page.errors) && is_array($page.errors)}
	<br/><br/><div align="center" style="color:red"><b>
		{foreach from=$page.errors item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{else}

{$page.direct}
{$page.backward}

{/if}