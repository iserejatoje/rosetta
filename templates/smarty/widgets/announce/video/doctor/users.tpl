{if !empty($res.list)}

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="right"><span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:15px; color:#0881B9; font-weight:bold;">{if $CURRENT_ENV.regid == 74}ГлаZ народа{else}{$res.title|ucfirst}{/if}</span></td>
	</tr>
</table>

{if isset($res.url)}
	{assign var="resurl" value=$res.url}
{else}
	{assign var="resurl" value="/`$ENV.section`/"}
{/if}

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">

{foreach from=$res.list item=l key=sectionid}
	{if $l.cnt > 0}
		<tr>
			<td width="100%">
				{*<a href="{$resurl}{$sectionid}/3/" class="zag4"><strong>{$l.info.name}</strong></a> <font class="dop5">({$l.cnt|number_format:0:'':' '})</font>*}
				<a href="{$l.url}" class="zag4"><strong>{$l.info.name}</strong></a> <font class="dop5">({$l.cnt|number_format:0:'':' '})</font>
			</td>
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
<div align="right" style="padding-top: 6px;"><a href="{$competition_link}" style="color:red;">Добавить видео</a></div>
{/if}

{/if}