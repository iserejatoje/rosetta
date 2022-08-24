<table cellpadding="0" cellspacing="0" border="0" style="margin-left: 8px;">
	<tr align="center" valign="middle">
{if $CURRENT_ENV.regid == 74}
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'newsline'}_selected{/if}"><a href="http://chelyabinsk.ru/newsline/" target="_blank"><span>Новости</span></a></td>
{elseif $CURRENT_ENV.regid == 63}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'newsline'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/factsline/"><span>Новости</span></a></td>
{else}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'newsline'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/newsline/"><span>Новости</span></a></td>
{/if}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'mail'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/mail/"><span>Почта</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'job'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/job/"><span>Работа</span></a></td>

{if in_array($CURRENT_ENV.regid,array(78,54,66,16,163,93,62,71,29,76,43,53,61,59,63,72,2,34,74,26,56,48,51,55,35,36,38))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'map'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/map/"><span>Карта</span></a></td>
{/if}

{if !in_array($CURRENT_ENV.regid,array(34,74,72,59,63,2,38))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'search'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/search/"><span>Поиск</span></a></td>
{/if}

{if in_array($CURRENT_ENV.regid,array(72,34,59,63,16,61,2))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'video'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/video/"><span>Видео</span></a></td>
{elseif in_array($CURRENT_ENV.regid,array(74))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'video'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/video/"><span>ТВ</span></a></td>
{/if}

{if $CURRENT_ENV.regid == 16}
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://116dengi.ru/" target="_blank"><span>Финансы</span></a></td>
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://116auto.ru/car/" target="_blank"><span>Авто</span></a></td>
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://116metrov.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 61}
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://161bank.ru/"><span>Финансы</span></a></td>
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://161auto.ru/car/"><span>Авто</span></a></td>
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://161metr.ru/realty/"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 59}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://www.dengi59.ru/" target="_blank"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://www.avto59.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://www.kvartira59.ru/realty/" target="_blank"><span>недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 63}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://dengi63.ru/" target="_blank"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://doroga63.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://dom63.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 72}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://72dengi.ru/" target="_blank"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://72avto.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://72doma.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 2}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://102banka.ru/" target="_blank"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://102km.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://102metra.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 34}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://34banka.ru/" target="_blank"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://34auto.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://34metra.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
{elseif $CURRENT_ENV.regid == 74}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://autochel.ru/car/" target="_blank"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://domchel.ru/realty/" target="_blank"><span>Недвижимость</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://chel.ru/partner/" target="_blank"><span>Компании</span></a></td>
{elseif $CURRENT_ENV.regid == 75}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'exchange'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/exchange/"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'car'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/car/"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'realty'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/realty/"><span>Недвижимость</span></a></td>
{else}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'exchange'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/exchange/"><span>Финансы</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'car'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/car/"><span>Авто</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'realty'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/realty/"><span>Недвижимость</span></a></td>
{/if}

{if !in_array($CURRENT_ENV.regid,array(74))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'firms'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/firms/"><span>Компании</span></a></td>
{/if}

{if $CURRENT_ENV.regid != 74}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'weather'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/weather/"><span>Погода</span></a></td>
{/if}

{if $CURRENT_ENV.regid == 16}
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://116vecherov.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 61}
                <td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://161vecher.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 59}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://afisha59.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 63}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{* if $CURRENT_ENV.section == 'dnevniki'}_selected{/if *}"><a href="http://freetime63.ru/"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 72}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{* if $CURRENT_ENV.section == 'dnevniki'}_selected{/if *}"><a href="http://72afisha.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 2}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://102vechera.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 34}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://34vechera.ru/" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 74}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="/service/go/?url={"http://2074.ru/"|escape:"url"}"><span>Hi-Tech</span></a></td>
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top"><a href="http://mychel.ru/afisha/afisha.php?cmd=list" target="_blank"><span>Афиша</span></a></td>
{elseif $CURRENT_ENV.regid == 93}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'love'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/afisha/"><span>Отдых</span></a></td>
{else}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'love'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/love/"><span>Отдых</span></a></td>
{/if}


{if !in_array($CURRENT_ENV.regid,array(78,54,66,163,93,62,71,26,29,76,43,48,51,53,2,16,34,35,55,56,59,63,72,61))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'svoi'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/blog/"><span>Блоги</span></a></td>
{/if}

		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'forum'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/forum/"><span>Форумы</span></a></td>

{if in_array($CURRENT_ENV.regid,array(14,66,89,86,76,75,72,71,70,68,62,60,56,53,51,48,45,43,42,38,35,29,26,16,55,61,2,34,193,93,174,54,78,24,163,36,102,59,63,16,61,74))}
		<td onmouseover="menu_top_over(this);" onmouseout="menu_top_out(this);" class="menu_top{if $CURRENT_ENV.section == 'baraholka'}_selected{/if}"><a href="{if isset($CURRENT_ENV.site.regdomain)}http://{$CURRENT_ENV.site.regdomain}{/if}/baraholka/"><span>Барахолка</span></a></td>
{/if}
	</tr>
</table>