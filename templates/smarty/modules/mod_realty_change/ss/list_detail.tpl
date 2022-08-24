{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a href="{$l.link}" class="s5b">[{$l.text}]</a>&nbsp;
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

{* Detail list *}

{foreach from=$page.list item=l key=_k}
			{* Table of data for each rows *}
			<table width="100%" cellspacing="1" border="0" class="table2">
				<tr>
					<th colspan="2">{$ENV._arrays.rubrics[$l.rub]}</th>
				</tr>
				<tr>
					<td align="right" width="150" class="bg_color2">Дата:</td>
					<td class="bg_color4">{$l.date_start|simply_date}</td>
				</tr>
				{if $l.scheme}
				<tr>
					<td align="right" width="150" class="bg_color2">Схема обмена:</td>
					<td class="bg_color4">{$l.scheme}</td>
				</tr>
				{/if}
				{if $l.have}
				<tr>
					<td align="right" width="150"  class="bg_color2">Имеется:</td>
					<td class="bg_color4">{$l.have}{if !empty($l.img1) || !empty($l.img2) || !empty($l.img3)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}</td>
				</tr>
				{/if}
				{if $l.need}
				<tr>
					<td align="right" width="150" class="bg_color2">Требуется:</td>
					<td class="bg_color4">{$l.need}</td>
				</tr>
				{/if}
				{if $l.description|trim}
				<tr>
					<td align="right" width="150" class="bg_color2">Доп. информация:</td>
					<td class="bg_color4">{$l.description}</td>
				</tr>
				{/if}
				{if $l.contacts|trim != ''}
				<tr>
					<td align="right" width="150" class="bg_color2">Контакты:</td>
					<td class="bg_color4">{$l.contacts|strip_tags|trim}
					{* if $l.uid==81185 || $l.uid==86282 || $l.uid==86283 || $l.uid==86285 || $l.uid==86287 || $l.uid==103658}
						<img src="/img/misc/kvadrat.gif" width="78" height="15" border="0" alt="АН КВАДРАТ">
					{/if}
					{if $l.uid==27169 || $l.uid==108510}
						<img src="/img/misc/elkina85.gif" width="130" height="15" border="0" alt="Центр Недвижимости Елькина 85">
					{/if}
					{if $l.uid==1785 || $l.uid==90167 || $l.uid==26539 || $l.uid==26554}
						<img src="/img/misc/makler.gif" width="73" height="11" border="0" alt="АН Маклер">
					{/if *}
					</td>
				</tr>
				{/if}
				{if $l.img1}
				<tr>
					<td align="center" colspan="2">
						<a onclick="ImgZoom('{$l.img1.src}','adv_sale_{$l.id}',{$l.img1.w},{$l.img1.h});return false;" href="{$l.img1.src}">смотреть фото</a>
					</td>
				</tr>
				{/if}
			</table>
			{* END Table of data for each rows *}
		</td>
	</tr>
	<tr>
		<td height="15"></td>
	</tr>

{/foreach}
{* Detail list *}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/><br/>
{/if}
<br/><br/>