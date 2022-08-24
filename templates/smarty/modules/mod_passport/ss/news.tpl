<div class="title">Мои новости</div>
<br/>
<div style="float:right;width:200px;background-color:#FFFFFF;">
<div style="margin-left:10px;">
	<form method="POST">
		<input type="hidden" name="action" value="news" />
		<div class="block_title4"><span>Фильтр</span></div>
		{foreach from=$page.filter item=l key=k}
		<input type="checkbox" id="filter_{$k}" name="filter[{$k}]" {if $l.isset}checked="checked" {/if}/><label for="filter_{$k}"> {$l.title}</label><br />
		{/foreach}
		<div align="center" style="padding:8px;"><input type="submit" value="Применить" /></div>
	</form>
</div>
</div>
{foreach from=$page.list key=date item=l}
<div style="margin-bottom:12px;">
<div class="block_title4" style="margin-bottom:8px;"><span>{$date|simply_date:"%f"}</span></div>

{foreach from=$l key=key item=l3}

{assign var="action" value=$l3.action}

<div style="float:right" class="pcomment">{$l3.time|date_format:"%H:%M"}</div>

{if $action==2}
	<div class="pnews_el">По вашему интересу
		{foreach from=$l3.interest item=l4 name=fa2}
		<a href="{$l4.url}">{$l4.name}</a>
		{if $l4.count}<span class="tipsup"> <a href="{$l4.url}"><font color="red">{$l4.count|number_format:0:'':' '}</font></a></span>{/if}
		{if !$smarty.foreach.fa2.last} &gt; {/if}
		{/foreach}

		{if count($l3.list) == 1}
			появился новый человек: {foreach from=$l3.list item=l4}<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{/foreach}
		{else}
			появились новые люди:
			{foreach from=$l3.list item=l4 name=fa2}
			{if $l4.data.anonymous !== true}
				<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
			{else}
			{/if}
			{/foreach}
			<div style="clear:left;"></div>
		{/if}
	</div>
{elseif $action == 3 || $action == 4 || $action == 5}
	<div class="pnews_el">По вашему месту{if $action==4} работы{elseif $action==5} учебы{/if}
		<a href="{$l3.place.url}">{$l3.place.name}</a>{if !empty($l3.place.city)} ({$l3.place.city}){/if}
		{if $l3.place.count}<span class="tipsup"><a href="{$l3.place.url}"><font color="red">{$l3.place.count|number_format:0:'':' '}</font></a></span>{/if}

		{if count($l3.list) == 1}
			появился новый человек: {foreach from=$l3.list item=l4}<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{/foreach}
		{else}
			появились новые люди:
			{foreach from=$l3.list item=l4 name=fa2}
				<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
			{/foreach}
			<div style="clear:left;"></div>
		{/if}
	</div>
{elseif $action == 6}
	<div class="pnews_el">По вашему адресу
		{foreach from=$l3.address item=l4 name=fa2}
		<a href="{$l4.url}">{$l4.name}</a>
		{if $l4.count}<span class="tipsup"><a href="{$l4.url}"><font color="red">{$l4.count|number_format:0:'':' '}</font></a></span>{/if}
		{if !$smarty.foreach.fa2.last} &gt; {/if}
		{/foreach}

		{if count($l3.list) == 1}
			появился новый человек: {foreach from=$l3.list item=l4}<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{/foreach}
		{else}
			появились новые люди:
			{foreach from=$l3.list item=l4 name=fa2}
				<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
			{/foreach}
			<div style="clear:left;"></div>
		{/if}
	</div>
{elseif $action >= 7 && $action <= 12}
	<div class="pnews_el">{if $action==8}В форуме сообщества{else}В сообществе{/if}
		<a href="{$l3.community.url}">{$l3.community.name|trim}</a>

		{if $action==7}
			{if count($l3.list) == 1}
				появился новый человек: {foreach from=$l3.list item=l4}<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{/foreach}
			{else}
				появились новые люди:
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==8}
			{if count($l3.list) == 1}
				появилась новая тема: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{$l4.data.name}</a>{/foreach}
			{else}
				появились новые темы:
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.url}">{$l4.data.name}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{/if}
		{elseif $action==9}
			{if count($l3.list) == 1}
				появилось новое событие: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{$l4.data.name}</a>{/foreach}
			{else}
				появились новые события:
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.url}">{$l4.data.name}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{/if}
		{elseif $action==10}
			{if count($l3.list) == 1}
				появился новый опрос: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{$l4.data.name}</a>{/foreach}
			{else}
				появились новые опросы:
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.url}">{$l4.data.name}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{/if}
		{elseif $action==11}
			{if count($l3.list) == 1}
				появилась новоя фотография: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{if !empty($l4.data.name)}{$l4.data.name}{else}без имени{/if}</a>{/foreach}
			{else}
				появились новые фотографии:
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.thumb
							url=$l4.data.url
							text=$l4.data.name}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==12}
			{if count($l3.list) == 1}
				появился новый фотоальбом: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{if !empty($l4.data.name)}{$l4.data.name}{else}без имени{/if}</a>{/foreach}
			{else}
				появились новые фотоальбомы:
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.thumb
							url=$l4.data.url
							text=$l4.data.name}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{/if}
	</div>
{elseif $action >= 13 || $action <= 18}
	<div class="pnews_el">Ваш друг
		<a href="{$l3.user.infourl}">{$l3.user.showname|trim}</a>
		{if $action==13}
			добавил{if $l3.user.gender==2}а{/if} в друзья
			{if count($l3.list) == 1}
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{else}
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==14}
			исключил{if $l3.user.gender==2}а{/if} из друзей:
			{if count($l3.list) == 1}
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.infourl}">{$l4.data.showname}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{else}
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.avatarurl
							nophoto="/_img/modules/passport/user_unknown.gif"
							url=$l4.data.infourl
							text=$l4.data.showname}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==15}
			{if count($l3.info) == 1}
				добавил{if $l3.user.gender==2}а{/if} новую фотографию: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{if !empty($l4.data.name)}{$l4.data.name}{else}без имени{/if}</a>{/foreach}
			{else}
				добавил{if $l3.user.gender==2}а{/if} новые фотографии:
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.thumb
							url=$l4.data.url
							text=$l4.data.name}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==16}
			{if count($l3.info) == 1}
				добавил{if $l3.user.gender==2}а{/if} новый фотоальбом: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{if !empty($l4.data.name)}{$l4.data.name}{else}без имени{/if}</a>{/foreach}
			{else}
				добавил{if $l3.user.gender==2}а{/if} новые фотоальбомы:
				{foreach from=$l3.list item=l4 name=fa2}
					<div style="float:left;padding:4px;">{include file=$TEMPLATE.ssections.news_photo_small
							width=100 height=100
							photo=$l4.data.thumb
							url=$l4.data.url
							text=$l4.data.name}</div>
				{/foreach}
				<div style="clear:left;"></div>
			{/if}
		{elseif $action==17}
			{if count($l3.info) == 1}
				вступил{if $l3.user.gender==2}а{/if} в сообщество: {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{$l4.data.name}</a>{/foreach}
			{else}
				вступил{if $l3.user.gender==2}а{/if} в сообщества:
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.url}">{$l4.data.name}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{/if}
		{elseif $action==18}
			{if count($l3.info) == 1}
				покинул{if $l3.user.gender==2}а{/if} сообщество:  {foreach from=$l3.list item=l4}<a href="{$l4.data.url}">{$l4.data.name}</a>{/foreach}
			{else}
				покинул{if $l3.user.gender==2}а{/if} сообщества:
				{foreach from=$l3.list item=l4 name=fa2}
					<a href="{$l4.data.url}">{$l4.data.name}</a>{if !$smarty.foreach.fa2.last}, {/if}
				{/foreach}
			{/if}
		{/if}
	</div>
{/if}
{/foreach}
</div>

{/foreach}