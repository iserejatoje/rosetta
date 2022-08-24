<script><!--{literal}
function AttentForm(id)
{
  window.open("/{/literal}{$SITE_SECTION}{literal}/attention.html?id="+id, "ereg", "menubar=no, status=no, scrollbars=yes, toolbar=no, top=20, left=20, width=500,height=450");
}{/literal}
//--></script>

<!-- begin content -->
<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td colspan="2">&#160;</td>
	</tr>
	<tr>
		<td colspan="2" align=center class="title2">{$res.info.name}</td>
	</tr>
	<tr>
		<td colspan="2" class="gl" height="22" align="center" >
						<b>
						{if sizeof($res.pathdesc)}
							{foreach from=$res.pathdesc item=path name=pathdesc
							}<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$path.path}/">{$path.data.name}</a>{if !$smarty.foreach.pathdesc.last}&nbsp;/&nbsp;{/if}{
							/foreach}
						{/if}
						</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">&#160;</td>
	</tr>
{*{if $CURRENT_ENV.regid!=74}
	<tr>
		<td colspan="2" class="tip" style="font-size:10px; text-align:right;">(просмотров: {$res.info.views})</td>
	</tr>
{/if}*}
	<tr>
		<td colspan="2">
			<table cellspacing="1" cellpadding="4" width="100%">
				{foreach from=$res.fields key=_k item=_l}
				{if ($res.info.commercial>=1 && $_l.packet=='pay') || $_l.packet==''}
				{*if $_l.type!='title' && $res.info[$_k]!='' && $res.info[$_k]!='none'*}
				{if $_l.type!='title' && trim($res.info[$_k])!='' && $res.info[$_k]!='none'}
				<tr>
					{if $_l.type!='withouttitle'}
					<td align="right" width="100" bgcolor="#E3ECF2" class="gl">{$_l.title} </td>
					{/if}
					<td width="90%" class="gl" {if $_l.type=='withouttitle'} colspan="2"{/if}{if $_k=="logotype"}align="center"{/if}>
						{if $_l.type=='file'}
							{if $res.info[$_k]!='' && $res.info[$_k]!='none'}<a href="{$res.docs_path}{$res.info[$_k]}" target="_blank">скачать</a>{/if}
						{elseif $_k=='logobig'}
							<img src="{$res.img_path}{$res.info[$_k]}">
						{elseif $_l.type=='date'}
							{$res.info[$_k]|date_format:"%d.%m.%Y"}
						{else}
							{if $_l.type=='url'}<noindex><a href="http://{$res.info[$_k]|url:false}" target="_blank">{/if}
							{* if $_l.type=='email'}<a href="mailto:{$res.info[$_k]}">{/if *}
							{if $_l.type == 'url'}
							{$res.info[$_k]|screen_href|url:false}
							{else}
							{$res.info[$_k]|screen_href|mailto_crypt}
							{/if}
							{if $_l.type=='url'}</a></noindex>{/if}
							{* if $_l.type=='email'}</a>{/if *}
						{/if}
					</td>
				</tr>
				{/if}
				{/if}
				{/foreach}
				{if !empty($res.afisha)}
				<tr>
			    		<td align="right" width="100" bgcolor="#E3ECF2">Афиша</td>
					<td width="90%" class="gl">
						<a href="{$res.afisha.url}">События ({$res.afisha.count})</a>
					</td>
				</tr>		
				{/if}

				{if $res.scount>0 && $res.info.commercial>=1}
				<tr>
				<td align="right" width="80" bgcolor="#E3ECF2" class="gl">Услуги</td>
				<td class="gl">
				{foreach from=$res.service item=sb}
					<a href="{$sb.link}" target="_blank">{$sb.name}</a><br>
				{/foreach}
				</td>
				</tr>
				{/if}
			</table>
		</td>
	</tr>
	{if $res.pcount>0 && $res.info.commercial>=1}
	<tr>
		<td colspan="2" align=center>
			<table cellpadding=0 cellspacing=0 border=0 width=100%>
			{capture name="i"}0{/capture}
			{foreach from=$res.photos item=ph}
				{if $smarty.capture.i==0}<tr>{/if}
				<td align=center><a target="_blank" href="{$res.photos_path}{$ph.big}"><img hspace=3 vspace=3 src="{$res.photos_path}{$ph.small}" alt="{$ph.descr}" title="{$ph.descr}" border=0></a></td>
				{capture name="i"}{$smarty.capture.i+1}{/capture}
				{if $smarty.capture.i==4}</tr>
					{capture name="i"}0{/capture}
				{/if}
			{/foreach}
			{if $smarty.capture.i!=0}</tr>{/if}
			</table>
		</td>
	</tr>
	{/if}
	<tr>
		<td class="gl"><a href="javascript:AttentForm({$res.info.id})">Сообщить о неточностях</a></td>
		<td align="right" class="gl"><a href="/{$SITE_SECTION}/{if !empty($searchletter)}search/{$searchletter}.html&p={$res.page}{elseif !empty($searchstr)}search.html?str={$searchstr}&p={$res.page}{else}{$res.base}/{if !empty($res.page) && $res.page!=1}?p={$res.page}{/if}{/if}">вернуться</a></td>
	</tr>
	<tr>
		<td colspan="2"><br><br></td>
	</tr>
</table>
<!-- end content -->
{*if $res.info.commercial!=1*}
{include file="`$TEMPLATE.ssections.comments`"}
<br>
{if $res.info.is_otz}
{include file="`$TEMPLATE.commentform`"}
{/if}
{*/if*}