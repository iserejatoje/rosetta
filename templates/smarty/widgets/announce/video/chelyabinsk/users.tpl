{if !empty($res.list)}
<table border="0" cellpadding="3" cellspacing="0" width="100%">
  <tr><td align="left" class="dop2" bgcolor="#999999">{if $CURRENT_ENV.regid == 74}ГлаZ народа{else}{$res.title|ucfirst}{/if}</td></tr>
</table>

{if isset($res.url)}
	{assign var="resurl" value=$res.url}
{else}
	{assign var="resurl" value="/`$ENV.section`/"}
{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="3">

{foreach from=$res.list item=l key=sectionid}
	{if $l.cnt > 0}
		<tr>
			<td align="left">
				{*<a href="{$resurl}{$sectionid}/3/" class="bl_title">{$l.info.name}</a> *}
				<a href="{$l.url}" class="bl_title">{$l.info.name}</a> 
			</td>
			<td class="tip">({$l.cnt|number_format:0:'':' '})</td>
		</tr>
	{/if}
{/foreach}


</table>

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
<div align="right" style="padding-right: 1px;"><a href="{$competition_link}" style="color:red;">Добавить видео</a></div>
{/if}

{/if}