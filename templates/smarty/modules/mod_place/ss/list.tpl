<form method="get" action="/{$ENV.section}/search/" name="search_user">
<table class="bg_color2" width="100%" cellpadding="5" style="margin-bottom: 20px;">
	<tr>
		<td width="100%">
			<input type="text" name="query" style="width: 100%;" {if $page.query}value="{$page.query}"{else}onclick="this.value=''"  value="Укажите параметры поиска"{/if}/>
		</td>
		<td>
			<input type="submit" value="Искать"/>
		</td>
	</tr>
</table>

</form>

{$page.list}