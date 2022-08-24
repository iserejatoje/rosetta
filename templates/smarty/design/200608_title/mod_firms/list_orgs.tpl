<script><!--{literal}
function AttentForm(id)
{
  window.open("/{/literal}{$SITE_SECTION}{literal}/attention.html?id="+id, "ereg", "menubar=no, status=no, scrollbars=yes, toolbar=no, top=20, left=20, width=500,height=450");
}{/literal}
//--></script>

<!-- begin content -->

{capture name=pageslink}
{if count($res.pages.btn) > 0}<span class="gl">
	Страницы:&#160;
	{if !empty($res.pages.back)}<a href="{$res.pages.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if !empty($res.pages.next)}<a href="{$res.pages.next}">&gt;&gt;</a>{/if}
{/if}</span>
{/capture}
{if $TEMPLATE.searchform}
{include file="`$TEMPLATE.searchform`"}
{else}
<table border="0" cellpadding="0" cellspacing="0" align=center width="100%">
	<tr>
		<td>&#160;</td>
	</tr>
	<tr>
		<td class="gl" height="22" align="center" >
						<b>
						{if !empty($res.rtitle)}{$res.rtitle}
						{else}
							{foreach from=$res.pathdesc item=path}
							{if $path.path!=$res.base}<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$path.path}/">{/if}{$path.data.name}{if $path.path!=$res.base}</a>&nbsp;/&nbsp;{/if}
							{/foreach}
						{/if}</b>
		</td>
	</tr>
	<tr>
		<td height="3"><img src="/_img/x.gif" width="1" height="3"></td>
	</tr>
</table>
{/if}

<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td>
{if $smarty.capture.pageslink!="" }
	{$smarty.capture.pageslink}
{/if}
</td>
<td align="right" class="gl">Всего компаний: {$res.all}</td>
</tr>
</table>
<br>
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
<tr bgcolor="#dee7e7">
	{if !empty($res.rtitle)}<th class="gl">Раздел</th>{/if}
	{if $res.have_rating}<th class="gl">Рейтинг</th>{/if}
	<th class="gl">Название компании</th>
	<th class="gl" width="25%">Контакты</th>
	<th class="gl" width="30%">Отзывы</th>
</tr>
{excycle values="#FFFFFF,#F3F8F8"}
{foreach from=$res.list item=l}
	<tr bgcolor="{excycle}">
		{if isset($l.pathdesc)}
		<td align="center" class="gl">
			{foreach from=$l.pathdesc item=ld name=path}<a href="/{$SITE_SECTION}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{$ld.path}/">{$ld.data.name}</a>{if !$smarty.foreach.path.last}&nbsp;/&nbsp;{/if}{/foreach}
		</td>
		{/if}
		{if $res.have_rating}<td class="gl" align="center">{$l.rate}</td>{/if}
		<td align="center" class="gl">
			{if $l.commercial>=1 && !empty($l.logotype) && $l.logotype!='none'}<a href="/{$SITE_SECTION}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if isset($l.pathdesc)}{$l.path}{else}{$res.base}{/if}/{$l.id}.html?p={$res.page}{if !empty($searchstr)}&str={$searchstr}{elseif !empty($searchletter)}&letter={$searchletter}{/if}" class="zag2"><img src="{$res.img_path}{$l.logotype}" border="0"></a><br/><img src="/_img/x.gif" width="1" height="5"><br/>{/if}
			<a href="/{$SITE_SECTION}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if isset($l.pathdesc)}{$l.path}{else}{$res.base}{/if}/{$l.id}.html?p={$res.page}{if !empty($searchstr)}&str={$searchstr}{elseif !empty($searchletter)}&letter={$searchletter}{/if}" class="zag2">{$l.name}</a>
		</td>
	{*	<td align="center" >{if $l.cityname}{$l.cityname}, {/if}{$l.address}</td>
		<td align="center" class="gl">
			{if $l.tel}{$l.tel}{else}-{/if}
		</td> *}  

		<td align="center" class="gl">{if $l.cityname}{$l.cityname}, {/if}{$l.address}{if $l.tel}<br/>Тел.: {$l.tel}{/if}
		{if $l.commercial>=1}
			{if $l.email}<br/>{$l.email|mailto_crypt}{/if}
			{if $l.url}<br/><noindex><a href="http://{$l.url}" target="_blank">{$l.url}</a></noindex>{/if}
		{/if}
		</td>
		<td align="center" class="gl">
	   {if $l.otz.otziv!=''}
			<font class="dop10">
			<b>{$l.otz.name}</b>, {$l.otz.date|date_format:"%e.%m"}:
			&nbsp;{$l.otz.otziv|truncate:70:"...":false}&nbsp;<a href="/{$SITE_SECTION}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if isset($l.pathdesc)}{$l.path}{else}{$res.base}{/if}/{$l.id}.html?page={$l.otz.p}#{$l.otz.id}" class="gl">&gt;&gt;</a>
			</font><br/>
		{/if}
		</td> 
	</tr>
{/foreach}
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td>
{if $smarty.capture.pageslink!="" }
	{$smarty.capture.pageslink}
{/if}
</td>
<td align="right" class="gl">Всего компаний: {$res.all}</td>
</tr>
</table>
<br>
<div align="left">{$smarty.capture.pages}</div>
<!-- end content -->
