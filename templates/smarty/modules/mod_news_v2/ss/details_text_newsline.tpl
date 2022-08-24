<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="8"></td></tr>
<tr><td>
    <table cellpadding="0" cellspacing="0" border="0">
		<tr><td>
			<span class="title">{if date('Ymd') != date('Ymd', $l.date)}{$res.date|date_format:"%e.%m.%Y"}{/if} {$res.date|date_format:"%H:%M"}</span>
			<span class="title2"><a name="{$res.id}"></a>{$res.name}</span>
		</td></tr>
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="justify">
<!-- Text article -->
{$res.text|screen_href|mailto_crypt}
<!-- Text article: end -->
</td></tr>
{if $res.author_name }
	<tr><td height="10px"></td></tr>
	<tr><td align="right">
{assign var="user_email" value=$res.author_email}
	<b>{if $res.author_email}{$res.author_name} ({$user_email|mailto_crypt}){else}{$res.author_name}{/if}, <i>специально для {$ENV.site.domain|ucfirst}</i></b>
	</td></tr>
{/if}
{if $res.photographer_name}<tr><td align="right" class="txt_color1">{$res.photographer_name}</td></tr>{/if}
<tr><td>
{if !empty($res.link) && !strpos($res.link, 'rugion.ru')}
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td><noindex><a href="{$res.link}" target="_blank">обсудить на форуме</a></noindex></td>
</tr>
</table>
{/if}
</td></tr>
<tr><td height="25px"></td></tr>
</table>