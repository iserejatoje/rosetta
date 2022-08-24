{if !empty($res.list)}

<table cellpadding="0" cellspacing="0" width="100%">
{*
<tr bgcolor="#FFFFFF" >
	<td height="2"><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
*}
<tr>
	<td style="background: #87B30A url('/_img/design/200805_afisha/green_search_bg.gif') repeat-x; padding-left: 10px" class="zag1" align="left">
		<br/>{if $CURRENT_ENV.regid == 74}ГлаZ народа{else}{$res.title|ucfirst}{/if}
	</td>
</tr>
</table>

{if isset($res.url)}
	{assign var="resurl" value=$res.url}
{else}
	{assign var="resurl" value="/`$ENV.section`/"}
{/if}

<table width="100%" class="block_right" cellspacing="3" cellpadding="0" style="padding-left: 10px;">

{foreach from=$res.list item=l key=sectionid}
	{if $l.cnt > 0}
	<tr>
		<td align="left">
{*{if isset($l.url)}{$l.url}{/if}{$ENV.section}/{$sectionid}/3/ *}
			{*<a href="{$resurl}{$sectionid}/3/" class="weis_big">{$l.info.name}</a> *}
			<a href="{$l.url}" class="weis_big">{$l.info.name}</a> 
		</td>
		<td class="weis">({$l.cnt|number_format:0:'':' '})</td>
	</tr>
	{/if}
{/foreach}

{assign var="competition_link" value=""}
{if $CURRENT_ENV.regid == 2}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/6.php"}
{elseif $CURRENT_ENV.regid == 16}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/11.php"}
{elseif $CURRENT_ENV.regid == 34}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/9.php"}
{elseif $CURRENT_ENV.regid == 59}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/5.php"}
{elseif $CURRENT_ENV.regid == 61}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/7.php"}
{elseif $CURRENT_ENV.regid == 63}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/8.php"}
{elseif $CURRENT_ENV.regid == 72}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/10.php"}
{elseif $CURRENT_ENV.regid == 74}
	{assign var="competition_link" value="http://`$CURRENT_ENV.site.regdomain`/competition/12.php"}
{elseif isset($res.competition_url)}
	{assign var="competition_link" value=$res.competition_url}
{/if}

{if !empty($competition_link)}
	<tr><td colspan="2"><div align="right" style="padding: 6px 2px 10px 0px;"><a href="{$competition_link}" style="color:red;">Добавить видео</a></div></td></tr>
{/if}

</table>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	<td valign="bottom" align="right" colspan="2"><img height="16" width="16" src="/_img/design/200805_afisha/search_korner.gif"/></td>
</tr>
<tr bgcolor="#ffffff">
	<td height="2"><img height="2" width="1" src="/_img/design/200805_afisha/x.gif"/></td>
</tr>
</table>


{/if}