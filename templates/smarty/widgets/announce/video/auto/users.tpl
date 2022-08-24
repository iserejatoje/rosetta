{if !empty($res.list)}
<table width="100%" class="block_right" cellspacing="0" cellpadding="0" >
<tr>
	<th align="left" valign="bottom" width="18"><img src="/_img/design/200710_auto/bul-zag.gif" width="18" height="13"></th>
	<th><span>&nbsp;&nbsp;{if $CURRENT_ENV.regid == 74}ГлаZ народа{else}{$res.title|ucfirst}{/if}</span></th>
</tr>
</table>

{if isset($res.url)}
	{assign var="resurl" value=$res.url}
{else}
	{assign var="resurl" value="/`$ENV.section`/"}
{/if}

<table width="100%" class="block_right_news" cellspacing="3" cellpadding="0">
{foreach from=$res.list item=l key=sectionid}
	{if $l.cnt > 0}
		<tr>
			<td>
				{*<span class="anon_name"><a href="{$resurl}{$sectionid}/3/">{$l.info.name}</a></span> <span class="descr">({$l.cnt|number_format:0:'':' '})</span>*}
				<span class="anon_name"><a href="{$l.url}">{$l.info.name}</a></span> <span class="descr">({$l.cnt|number_format:0:'':' '})</span>
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
<div align="right" class="video-a-block-content"><a href="{$competition_link}" style="color:red;">Добавить видео</a></div>
{/if}

{/if}