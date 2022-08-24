<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="8"></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						{if is_array($res.Tags) && sizeof($res.Tags)}
						<div class="tag-item-list">
							<strong>Метки: </strong>
							{foreach from=$res.Tags item=tag name=tags}
								<a href="/tags/{$tag.Name|urlencode}/">{$tag.Name}</a>{if !$smarty.foreach.tags.last}, {/if}
							{/foreach}
						</div>
						{/if}
						<span class="title">{if date('Ymd') != date('Ymd', $res.Date)}{$res.Date|date_format:"%e.%m.%Y"}{/if} {$res.Date|date_format:"%H:%M"}</span>
						<span class="title2" {if $res.isMarked}style="color:red;"{/if}><a name="{$res.id}"></a>{$res.Title}</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="justify">
			<!-- Text article -->
			{if !$res.hideLinks}
				{$res.Text}
			{else}
				{$res.Text|mailto_crypt}
			{/if}
			<!-- Text article: end -->
			<br/>
			<br/>
			{include file="`$CONFIG.templates.ssections.above_list`" aboverefs="`$res.aboverefs`" color="#eeeeee"}
		</td>
	</tr>
	{if $res.AuthorName }
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td align="right">
			<b>{if $res.AuthorEmail}{$res.AuthorName} ({$res.AuthorName|mailto_crypt}){else}{$res.AuthorName}{/if}, <i>специально для {$ENV.site.domain|ucfirst}</i></b>{if $res.isAdvert} <img src="/_img/design/common/rr.gif" width="11" height="11" alt="На правах рекламы" title="На правах рекламы" border="0" />{/if}
		</td>
	</tr>
	{/if}
	{if $res.PhotographerName}
	<tr>
		<td align="right" class="txt_color1">{$res.PhotographerName}</td>
	</tr>
	{/if}
	<tr>
		<td height="10px"></td>
	</tr>
	{if $ENV.section_page != 'print'}
	<tr>
		<td class="tip">
		<div style="float:right; width: auto; margin-left: 20px;"><a href="/{$ENV.section}/{$res.NewsID}-print.html" class="descr" target="print" onclick="window.open('about:blank', 'print','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></div>
		<div style="float:right; width: auto; margin-left: 20px;">Просмотров: {$res.Views|number_format:0:" "}</div>
		</td>
	</tr>
	{/if}
	<tr>
		<td>
		{include file="`$CONFIG.templates.ssections.cross_social`" title="`$res.Title`" utitle="`$res.unicodetitle`" descr="`$res.simpletext`" url="`$res.FullUrl`" thumb="`$res.Thumb`" date="`$res.Date`"}
		<br/>
		</td>
	</tr>
	<tr>
		<td class="tip" colspan="2">
			<a href="/{$ENV.section}/{'Y/m/d'|date:$res.Date}/">Все новости дня</a></div>
		</td>
	</tr>
</table>