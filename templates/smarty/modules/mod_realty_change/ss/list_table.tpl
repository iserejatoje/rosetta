{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a class="s5b" href="{$l.link}">[{$l.text}]</a>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $page.pageslink.next!="" }<td style="font-size:11px"><a href="{$page.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

{if $smarty.capture.pageslink}
	{$smarty.capture.pageslink}<br/><br/>
{/if}

{* Table list *}
<table width="100%" cellspacing="2" border="0" class="table2">
	<tr>
		<th width="40px">Дата</th>
		<th width="50%">Имеется</th>
		<th width="50%">Требуется</th>
	</tr>
	{assign var=sort_key value=''}

{foreach from=$page.list item=l key=_k}
	{if $l.rub != $sort_key}
		<tr>
			<td colspan="3" align="center">
				<b>{$ENV._arrays.rubrics[$l.rub]}</b>
			</td>
		</tr>
		{assign var=sort_key value=$l.rub}
	{/if}

	<tr class="{if $_k%2}bg_color4{/if}" align="center">
		<td class="text11">
			<span class="s3">{$l.date_start|simply_date:"%f":"%d-%m"}</span><br />{$l.date_start|date_format:"%H:%M"}{* "H:i"|date:$l.date_start *}
		</td>

		<td align="left">
		{if $l.scheme}
				Схема обмена:&nbsp;{$l.scheme}
		{/if}
		{if $l.have}
				<br/>{$l.have}{if !empty($l.img1) || !empty($l.img2) || !empty($l.img3)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}
		{/if}
			{if $l.contacts|trim != ''}<br />Контакты:&nbsp;
			{$l.contacts|trim|strip_tags|truncate:60}
			<br />
			{/if}
			<div align="right">
        		<a href="/{$ENV.section}/details.html?id={$l.id}">подробнее</a>
        	</div>
		</td>
		<td align="left">
		{if $l.need}
				{$l.need}
			{else}<center>-</center>{/if}

		</td>
	</tr>

{/foreach}
</table>
{* Table list end*}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/><br/>
{/if}