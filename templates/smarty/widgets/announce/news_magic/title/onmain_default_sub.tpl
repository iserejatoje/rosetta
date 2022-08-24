{php}$this->_tpl_vars['_dates'] = array();{/php}

<table width="100%" cellpadding="0" cellspacing="4" border="0">
	
	<tr>
		<td class="t12">
			{if $res.Title}
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">{$res.Title}</td>
					<td align="left">{if $res.TitleLink}&nbsp;&nbsp;(<a href="/service/go/?url={$res.TitleLink|escape:'url'}" class="t11_grey" target="_blank">все новости</a>){/if}</td>
				</tr>
				<tr>
					<td align="left" height="1" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td>
					<td></td>
				</tr>
			</table>
			{/if}
			{foreach from=$res.mainNews item=l key=k}
			<table class="t12" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="left" class="t12" style="padding-top: 5px;"><b>Главное: </b>
					<a href="/service/go/?url={$l->url.absolute|escape:'url'}" class="ssyl" target="_blank" {if $l->isMarked}style="color:red;"{/if}>{$l->title|truncate:100:"..."} </a> 
					{if $l->AddMaterial == 1}
						<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">
					{elseif $l->AddMaterial == 2}
						<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">
					{/if}
					</td>
				</tr>
			</table>
			{/foreach}
		</td>
	</tr>
	{foreach from=$res.newsList item=l key=k}

		{if mktime(0,0,0) > $l->tsDate && !in_array(date("d M", $l->tsDate),$_dates)}
		<tr>
			<td class="t12">
				{php}$this->_tpl_vars['_dates'][] = date("d M", $this->_tpl_vars['l']->tsDate);{/php}
				<div><b>{$l->tsDate|date_format:"%d"} {$l->tsDate|month_to_string:2}</b></div>
			</td>
		</tr>
		{/if}
		
		<tr>
			<td class="t12" {*{if $l->AddMaterial == 2}style="background-color: #d7e8ea;"{/if}*}>
			{*<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
			{if $l->AddMaterial==2}<td style="background-color: #a8d5db; width: 19px;" valign="top"><img src="/_img/design/200608_title/common/video_green.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" hspace="3" vspace="3"></td>
				<td style="padding: 3px 3px 3px 3px;">
			{else}
				<td>
			{/if}*}
			{$l->Date|date_format:"%H:%M"}&nbsp;
			{if ($CURRENT_ENV.regid==74 && strpos($l->url.relative, '225837'))} {* по заказу Серёги Боваренко, 07.08.2009 *}
				<a href="http://chelyabinsk.ru/newsline/225837.html" target="_blank" {if $l->isMarked}style="color:red;"{/if}>{$l->Title}</a>
			{else}
				<a href="/service/go/?url={$l->url.relative|escape:'url'}" target="_blank" {if $l->isMarked}style="color:red;"{/if}>{$l->Title}</a>
			{/if}
			{if $l->AddMaterial == 1}
				<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">
			{elseif $l->AddMaterial == 2}
				<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">
			{/if}
                        {*</td>
			</tr></table>*}
			</td>
		</tr>

	{/foreach}
	
	{foreach from=$res.importantNews item=l key=k}
	
		<tr>
			<td class="t12" {*{if $l->AddMaterial == 2}style="background-color: #d7e8ea;"{/if}*}>
			{*<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
			{if $l->AddMaterial==2}<td style="background-color: #a8d5db; width: 19px;" valign="top"><img src="/_img/design/200608_title/common/video_green.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" hspace="3" vspace="3"></td>
				<td style="padding: 3px 3px 3px 3px;">
			{else}
				<td>
			{/if}*}
			<img src="/_img/design/200608_title/common/b3.gif" width="4" height="4" border="0" alt="" valign="absmiddle">&nbsp;
			<a href="/service/go/?url={$l->url.absolute|escape:'url'}" target="_blank" {if $l->isMarked}style="color:red;"{/if}>{$l->Title}</a>
			{if $l->AddMaterial == 1}
				<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">
			{elseif $l->AddMaterial == 2}
				<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">
			{/if}
                        {*</td>
			</tr></table>*}
			</td>
		</tr>

	{/foreach}
</table>