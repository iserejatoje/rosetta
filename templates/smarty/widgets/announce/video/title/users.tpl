{if !empty($res.list)}
<div class="video-a-block-container">

<table class="video-a-block-content">
	<tr>
		<td colspan="2">
			<div class="video-a-block-title" style="padding-right: 5px;"><span>{$res.title|ucfirst}</span></div>
		</td>
	</tr>

{if isset($res.url)}
	{assign var="resurl" value=$res.url}
{else}
	{assign var="resurl" value="/`$ENV.section`/"}
{/if}

{foreach from=$res.list item=l key=sectionid}
	{if $l.cnt > 0}
		<tr>
			<td width="100%">
				{*<a href="{$resurl}{$sectionid}/3/">{$l.info.name}</a> *}
				<a href="{$l.url}">{$l.info.name}</a> 
			</td>
			<td>({$l.cnt|number_format:0:'':' '})</td>
		</tr>
	{/if}
{/foreach}


</table>

{assign var="competition_link" value=""}
{if $CURRENT_ENV.regid == 2}
	{assign var="competition_link" value="/competition/6.php"}
{elseif $CURRENT_ENV.regid == 16}
	{assign var="competition_link" value="/competition/11.php"}
{elseif $CURRENT_ENV.regid == 34}
	{assign var="competition_link" value="/competition/9.php"}
{elseif $CURRENT_ENV.regid == 59}
	{assign var="competition_link" value="/competition/5.php"}
{elseif $CURRENT_ENV.regid == 61}
	{assign var="competition_link" value="/competition/7.php"}
{elseif $CURRENT_ENV.regid == 63}
	{assign var="competition_link" value="/competition/8.php"}
{elseif $CURRENT_ENV.regid == 72}
	{assign var="competition_link" value="/competition/10.php"}
{elseif $CURRENT_ENV.regid == 74}
	{assign var="competition_link" value="/competition/12.php"}
{elseif isset($res.competition_url)}
	{assign var="competition_link" value=$res.competition_url}
{/if}

{if !empty($competition_link)}
<div align="right" class="video-a-block-content"><a href="{$competition_link}" style="color:red;">Добавить видео</a></div>
{/if}

</div>
{/if}