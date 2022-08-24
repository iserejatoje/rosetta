<table width="100%" class="block_right" cellspacing="3" cellpadding="0" >
{*		<tr><th><span>
			{$ENV.site.title[$ENV.section]}
		</span></th></tr>*}
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
		<tr><th><span>
{*if ($ENV.section=='news' && $CURRENT_ENV.site.domain=='ufa1.ru' && $l.id==232)}
Пожелания уфимским спортсменам
{elseif  ($ENV.section=='news' && $CURRENT_ENV.site.domain=='116.ru' && $l.id==255)}
Пожелания казанским спортсменам
{elseif  ($ENV.section=='news' && $CURRENT_ENV.site.domain=='v1.ru' && $l.id==210)}
Пожелания волгоградским спортсменам
{elseif ($ENV.section=='news' && $CURRENT_ENV.site.domain=='59.ru' && $l.id==459)}
Пожелания пермским спортсменам
{elseif ($ENV.section=='news' && $CURRENT_ENV.site.domain=='161.ru' && $l.id==202)}
Пожелания ростовским спортсменам
{elseif ($ENV.section=='news' && $CURRENT_ENV.site.domain=='63.ru' && $l.id==713)}
Пожелания самарским спортсменам
{elseif ($ENV.section=='business' && $CURRENT_ENV.site.domain=='72.ru' && $l.id==334)}
Пожелания тюменским спортсменам
{elseif ($ENV.section=='news' && $CURRENT_ENV.site.domain=='chelyabinsk.ru' && $l.id==1498)}
Пожелания челябинским спортсменам
{elseif ($ENV.section=='bizvip' && $l.id==9)}
Пожелания сборной России
{else*}
	{$ENV.site.title[$ENV.section]}
{*/if*}
</span></th></tr>
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr><td><a href="/{$ENV.section}/{$res.group}{$l.id}.html" class="anon"><span class="anon_name">{if $l.type==2}{$l.name_arr.name},</span> <span class="anon_position">{$l.name_arr.position}{else}{$l.name}{/if}</span></a></td></tr>
	<tr>
		<td>
			{if $l.img1.file }
				<a href="/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.anon item=anon key=k}
					{if $k<3}{$anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if $l.otz.count}
				{foreach from=$l.otz.list item=o}
					<span class="bl_name"><b>{$o.name|truncate:20:"..."}:</b></span> <span class="bl_otziv">{$o.otziv|truncate:40:"...":false}
					<a href="{$o.url}"><small>&gt;&gt;</small></a></span><br/>
				{/foreach}
			{/if}
		</td>
	</tr>
	{if ($ENV.section=='news' && $CURRENT_ENV.site.domain=='ufa1.ru' && $l.id==232) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='116.ru' && $l.id==255) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='v1.ru' && $l.id==210) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='59.ru' && $l.id==459) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='161.ru' && $l.id==202) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='63.ru' && $l.id==713) || ($ENV.section=='business' && $CURRENT_ENV.site.domain=='72.ru' && $l.id==334) || ($ENV.section=='news' && $CURRENT_ENV.site.domain=='chelyabinsk.ru' && $l.id==1498) || ($ENV.section=='bizvip' && $l.id==9)}
	<tr>
		<td align="right" valign="top"><a href="/{$ENV.section}/{$res.group}{$l.id}.html#addcomment"><small>написать пожелание</small></a></td>
	</tr>
	{/if}
	<tr valign="bottom"><td>
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>