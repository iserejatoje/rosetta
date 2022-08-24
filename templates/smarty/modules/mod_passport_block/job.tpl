<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="left">
	<td class="block_title"><span>Моя работа</span></td>
</tr>
</table>
<div align="right" class="tip"><a href="/passport/announce/job.php"><font color="#999999">настройка</font><img src="/_img/modules/passport/settings.gif" height="10" width="10" border="0" title="настройка" style="vertical-align:middle;margin-left:4px;" /></a></div>
<table width="100%">
	<tr>
		<td class="tip">
			<a href="{$res.myvac_url}"><font color="#999999">мои вакансии: {$res.my.vacancy.count}</font></a>
		</td>
		<td class="tip" width="100%">
			  <a href="{$res.addvac_url}">добавить</a>
		</td>
	</tr>
	<tr>
		<td class="tip">
			<a href="{$res.myres_url}"><font color="#999999">мои резюме: {$res.my.resume.count}</font></a>
		</td>
		<td class="tip" width="100%">
			  <a href="{$res.addres_url}">добавить</a>
		</td>
	</tr>
</table>
{if count($res.myres) > 0}
<table width="100%" cellspacing="4" cellpadding="0" border="0">
	<tr>
		<td class="tip" style="text-align:center;font-weight:bold">
			<a href="{$res.myres_url}">Мое резюме</a>
		</td>
		<td class="tip" align="right">
			{if !empty($res.myres_edit)}<a href="{$res.myres_edit}">ред.</a>{/if}
		</td>
	</tr>
</table>
{/if}

{if count($res.myvac) > 0}
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{foreach from=$res.myvac item=l}
	<tr>
		<td class="tip">
			<a href="{$l.url}">{$l.dolgnost}</a>
			<br/>З/П: {$l.paysum_text}
		</td>
	</tr>
{/foreach}
</table>
{/if}

{if $res.favorites.vacancy.count > 0}
<div style="padding:4px;" class="tip" align="center"><a href="{$res.favoritesvac_url}">избранные вакансии{if $res.favorites.vacancy.count > $res.favorites_limit}: {$res.favorites.vacancy.count}{/if}</a></div>
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{foreach from=$res.favorites.vacancy.list item=l}
	<tr>
		<td class="tip">
			<a href="{$l.url}">{$l.dolgnost}</a>
			<br/>З/П: {$l.paysum_text}
		</td>
	</tr>
{/foreach}
</table>
{/if}

{if $res.favorites.resume.count > 0}
<div style="padding:4px;" class="tip" align="center"><a href="{$res.favoritesres_url}">избранные резюме{if $res.favorites.resume.count > $res.favorites_limit}: {$res.favorites.resume.count}{/if}</a></div>
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{foreach from=$res.favorites.resume.list item=l}
	<tr>
		<td class="tip">
			<a href="{$l.url}">{$l.dolgnost}</a>
			<br/>З/П: {$l.paysum_text}
		</td>
	</tr>
{/foreach}
</table>
{/if}

{if count($res.last.vacancy.list) > 0}
<div class="t11_grey" style="margin-left: 4px; margin-top: 10px;">Новые вакансии</div>
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{foreach from=$res.last.vacancy.list item=l}
	<tr>
		<td class="tip">
			<a href="{$l.url}">{$l.dolgnost}</a>
			<br/>З/П: {$l.paysum_text}
		</td>
	</tr>
{/foreach}
	<tr>
		<td class="tip" align="right"><a href="{$res.allvac_url}">все вакансии</a></td>
	</tr>
</table>
{/if}
{if count($res.last.resume.list) > 0}
<div class="t11_grey" style="margin-left: 4px; margin-top: 10px;">Новые резюме</div>
<table width="100%" cellspacing="4" cellpadding="0" border="0">
{foreach from=$res.last.resume.list item=l}
	<tr>
		<td class="tip">
			<a href="{$l.url}">{$l.dolgnost}</a>
			<br/>З/П: {$l.paysum_text}
		</td>
	</tr>
{/foreach}
	<tr>
		<td class="tip" align="right"><a href="{$res.allres_url}">все резюме</a></td>
	</tr>
</table>
{/if}