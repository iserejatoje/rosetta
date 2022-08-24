{include file="design/200608_title/mod_main_region_v2/header_main.tpl"}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td width="150" bgcolor="#E9EFEF">
<!--Left col -->
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			{foreach from=$BLOCKS.left item=l}
				<tr><td>
					{$l}
				</td></tr>
				<tr><td align="left" bgcolor="#E9EFEF"><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
			{/foreach}
			</table>
<!--Left col :END -->
		</td>
		<td width="8"><img src="/_img/x.gif" width="8" height="1" border="0"></td>
		<td>
<!--Center col -->
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr valign="top">
				<td style="padding-right:8px">
				{$BLOCKS.top.search_form}
				{$BLOCKS.top.newsline}
				{$BLOCKS.top.conference}

{* begin - news *}
				<table width="100%" cellpadding="0" cellspacing="4" border="0">
				{foreach from=$MAIN.news item=l}
				<tr><td>
				{if $l.type=='title'}
					<table class="t12" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">{$l.title}</td>{*<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>*}</tr>
						<tr><td align="left" height="1" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
					</table>
				{elseif $l.type=='row'}
					<a href="/service/go/?url={$l.row_url|escape:"url"}" target="_blank"><b>{$l.row_title}</b></a><b>:</b> <a href="/service/go/?url={$l.url|escape:"url"}" target="_blank">{$l.title}</a>{if $l.add_material==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">{elseif $l.add_material==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">{/if}<br/>
				{/if}
				</td></tr>
				{/foreach}
				</table>
{* end - news *}

{* begin - interview *}
				<table width="100%" cellpadding="0" cellspacing="4" border="0">

				<tr><td>
                    <table class="t12" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">Интервью</td></tr>
						<tr><td align="left" height="1" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
					</table>
				</td></tr>
				{foreach from=$MAIN.article item=l}
                {if $l.art_type==2}
				<tr><td>
				{if $l.type=='row'}
					{if $l.isnew}<font color="red"><b>new</b> </font>{/if}<font class="txt_blue"><b>{$l.row_title}:</b></font> {if empty($l.add_info)}<a href="/service/go/?url={$l.url|escape:"url"}" target="_blank">{$l.title}</a>{else}<a href="/service/go/?url={$l.url|escape:"url"}" target="_blank"><font color="red">{$l.title}</font></a>, {$l.add_info}{/if}{if $l.add_material==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">{elseif $l.add_material==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">{/if}<br/>
				{/if}
				</td></tr>
				{/if}
				{/foreach}
				{$BLOCKS.row_consult.consult_auto}
				</table>
{* end - interview *}

{* begin - article *}
				<table width="100%" cellpadding="0" cellspacing="4" border="0">
                <tr><td>
                    <table class="t12" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">Статьи, обзоры, аналитика</td></tr>
						<tr><td align="left" height="1" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
					</table>
                </td></tr>
				{foreach from=$MAIN.article item=l}
                {if $l.art_type==1}
                <tr><td>
				{if $l.type=='row'}
					{if $l.isnew}<font color="red"><b>new</b> </font>{/if}<font class="txt_blue"><b>{$l.row_title}:</b></font> <a href="/service/go/?url={$l.url|escape:"url"}" target="_blank">{$l.title}</a>{if $l.add_material==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">{elseif $l.add_material==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">{/if}<br/>
				{/if}
                </td></tr>
                {/if}
				{/foreach}
				</table>
{* end - article *}
{* begin - conference *}
{$BLOCKS.conference.0}
{* end - conference *}

				{if !empty($BLOCKS.center)}
				{foreach from=$BLOCKS.center item=l}<div>{$l}</div>{/foreach}
				{/if}

				</td>
				<td width="300">
		{$BLOCKS.right.exchangeright}
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
		</table>
		{$BLOCKS.right.autoright}
		{$BLOCKS.right.saleright}
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
			<tr><td align="center" bgcolor="#E9EFEF" style="padding-top:4px;padding-bottom:5px;">
				<div align="center" style="padding-top:3px;padding-bottom:3px;">
				<font class="t12b"><b>Общение</b>:</font>
				<a class="a12" href="/love/" target="_blank">знакомства</a>,
				<a class="a12" href="/blog/" target="_blank">дневники</a>
				</div>
				<font class="t12b"><a class="a12" href="/forum/view.php"><b>Форумы</b></a>:</font>
				<a class="a12" href="/forum/view.php?id=1009563" target="_blank">авто</a>,
				<a class="a12" href="/forum/view.php?id=1009532">за жизнь</a>,
				<a class="a12" href="/forum/view.php?id=1009553">СМИ</a>,
				<a class="a12" href="/forum/view.php?id=1009554">здоровье</a>,
				<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
				<a class="a12" href="/forum/view.php?id=1009580">компьютеры и интернет</a>, <a class="a12" href="/forum/view.php?id=1009581">путешествие</a>,
				<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
				<a class="a12" href="/forum/view.php?id=1009550" target="_blank">знакомства</a>, <a class="a12" href="/forum/view.php?id=1009552">работа и образование</a>
				<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
				<a class="a12" href="/forum/view.php?id=1009558">спорт</a>, <a class="a12" href="/forum/view.php?id=1009548">требуется помощь!</a>

			</td></tr>
			<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
		</table>
{*      		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /></td></tr>
			<tr><td align="center" bgcolor="#E9EFEF" style="padding-top:3px;padding-bottom:6px;">
				<a href="/firms/"><b>Справочник фирм</b></a> &nbsp;&nbsp; <a href="/hadv/"><b>Частные объявления</b></a><br/>
                                <a href="/blog/"><b>Дневники</b></a> &nbsp;&nbsp; <a href="/love/" target="_blank"><b>Знакомства</b></a>  &nbsp;&nbsp; <a href="/horoscope/"  target="_blank"><b>Гороскоп</b></a>
			</td></tr>
			<tr><td><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /></td></tr>
		</table>*}
				</td>
			</tr>
			</table>


<!--Center col :END -->
		</td>
	</tr>
	<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
	<tr>
		<td colspan="3" height="2"{* bgcolor="#E9EFEF"*}><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
</table>
<!-- Olimpiada Block-->
{if !empty($BLOCKS.olimpiada)}

{include file="modules/mod_olympiad/block_main.tpl"}

{/if}
<!--End of Olimpiada Block-->
<!-- Main Block-->
<table border="0" cellspacing="0" cellpadding="0" width="100%"> 
	<tr><td colspan="3" height="8"><img src="/_img/x.gif" height="2" alt="" /></td></tr>

	<tr><td colspan="3">{include file="design/200608_title/common/block_main_gorod_online.tpl"}</td></tr>

  	<tr>
    	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
    		<div style="padding: 5px; 5px 0px 5px">
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/newsline/" target="_blank">
				Новости онлайн</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
{*
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/bizvip/" target="_blank">
				Россия и мы</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
*}
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/conference/" target="_blank" class="txt_red">
				Онлайн-конференция</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
     		</div>
      	</td>
    	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="10" alt="" /></td>
    	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.main.first_left}
					<img src="/_img/x.gif" width="1" height="4" border="0" alt="" /><br/>
				</td>
				<td bgcolor="#ffffff" rowspan="3"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.main.first_right}
					<img src="/_img/x.gif" width="1" height="4" border="0" alt="" /><br/>
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.main.second_left}
				</td>
				<td width="50%" valign="top">
					{$BLOCKS.main.second_right}
				</td>
			</tr>
		</table>
		</td>
  	</tr>
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
</table>
<!--End of Main Block-->

<!-- Begin Job Vacancy Block-->
<table border="0" cellspacing="0" cellpadding="0" width="100%"> 
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr><td colspan="3" height="2" bgcolor="#D7E8EA"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="3" bgcolor="#D7E8EA" class="stitle2">
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" bgcolor="#E9EFEF" style="padding:1px 4px 1px 20px;" class="t12"><a href="/job/" target="_blank"><img src="/_img/design/200608_title/common/rugion_job.gif" title="Работа" alt="Работа" border="0"></a></td>
		<td width="150" style="padding-left:30px; height: 30px;" class="t12slogan">
			все&nbsp;о&nbsp;работе&nbsp;в&nbsp;Саратове</td>
		<td style="padding-left:30px;padding-right:10px;">
		</td>
	</tr></table></td></tr>
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr>
	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
		<div style="padding:5px 5px 5px 5px">
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/job/my/vacancy/add.php" target="_blank" style="color:red">
				Добавить вакансию</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/job/my/resume/add.php" target="_blank">
				Добавить резюме</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/job/vacancy/search.php" target="_blank">
				Искать вакансию</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
        		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/job/resume/search.php" target="_blank">
				Искать резюме</a><br/>
        		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
	</td>
	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="8" alt="" /></td>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0 width="100%">
			<tr>
				<td valign="top" align="left">
					{$BLOCKS.job_vacancy[0]}
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<!-- End Job Vacancy Block-->
<!-- fin -->
<table border="0" cellspacing="0" cellpadding="0" width="100%"> 
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr><td colspan="3" height="2" bgcolor="#D7E8EA"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="3" bgcolor="#D7E8EA" class="stitle2">
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" bgcolor="#E9EFEF" style="padding:1px 4px 1px 20px;" class="t12"><a href="/exchange/"><img src="/_img/design/200608_title/common/rugion_fin.gif" title="Финансы" alt="Финансы" border="0"></a></td>
		<td width="150" style="padding-left:30px; height: 30px;" class="t12slogan">
			все&nbsp;о&nbsp;деньгах&nbsp;в&nbsp;Саратове</td>
		<td style="padding-left:30px;padding-right:10px;">
		</td>
	</tr></table></td></tr>
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr>
	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
		<div style="padding:5px 5px 5px 5px">
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/newsline_fin/" target="_blank">Лента новостей</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/tech/" target="_blank">Финансовые технологии</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/exchange/" target="_blank" style="color:red">Курсы валют</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009584" target="_blank">Форум</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/skills/" target="_blank">Финграмота</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
	</td>
	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="14" alt="" /></td>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0 width="100%">
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.fin.first_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.fin.first_right}
				</td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.fin.second_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.fin.second_right}
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- /fin -->

<!-- auto -->
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr><td colspan="3" height="2" bgcolor="#D7E8EA"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="3" bgcolor="#D7E8EA" class="stitle2">
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" bgcolor="#E9EFEF" style="padding:1px 4px 1px 20px;" class="t12"><a href="/advertise/"><img src="/_img/design/200608_title/common/rugion_auto.gif" title="Авто" alt="Авто" border="0"></a></td>
		<td width="150" style="padding-left:30px; height: 30px;" class="t12slogan">
			все&nbsp;об&nbsp;авто&nbsp;в&nbsp;Саратове</td>
		<td style="padding-left:30px;padding-right:10px;">&nbsp;
		</td>
	</tr></table></td></tr>
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr>
	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
		<div style="padding:5px 5px 5px 5px">
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/newsline_auto/" target="_blank">Лента новостей</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/autostop/" target="_blank">Автостоп</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/accident/" target="_blank">Автокатастрофы</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/advertise/" target="_blank" style="color:red">Объявления</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/opinion/" target="_blank">Отзывы</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009563" target="_blank">Форум</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/pdd/" target="_blank">Штрафы ГИБДД</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
	</td>
	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="14" alt="" /></td>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0 width="100%">
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.auto.first_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.auto.first_right}
				</td>
			</tr>
			<tr>
				<td colspan="3"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.auto.second_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.auto.second_right}
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- /auto -->
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<!-- dom -->
<table border="0" cellspacing="0" cellpadding="0" width="100%"> 
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr><td colspan="3" height="2" bgcolor="#D7E8EA"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="3" bgcolor="#D7E8EA" class="stitle2">
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" bgcolor="#E9EFEF" style="padding:1px 4px 1px 20px;" class="t12"><a href="/sale/"><img src="/_img/design/200608_title/common/rugion_dom.gif" title="Недвижимость" alt="Недвижимость" border="0"></a></td>
		<td width="150" style="padding-left:30px; height: 30px;" class="t12slogan">
			строительство&nbsp;и&nbsp;обустройство&nbsp;недвижимости</td>
		<td style="padding-left:30px;padding-right:10px;">
		</td>
	</tr></table></td></tr>
<tr><td colspan="3"><img src="/_img/x.gif" height="8" alt="" /></td></tr>
<tr>
	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
		<div style="padding:5px 5px 5px 5px">
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/newsline_dom/" target="_blank">Лента новостей</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/articles/" target="_blank">Домострой</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/sale/" target="_blank" style="color:red">Продажа-покупка жилья</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/rent/" target="_blank">Аренда жилья</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/commerce/" target="_blank">Коммерческая недвижимость</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009597" target="_blank">Форум</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/hints/" target="_blank">Дом советов</a><br/>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
	</td>
	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="14" alt="" /></td>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0 width="100%">
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.dom.first_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.dom.first_right}
				</td>
			</tr>
			<tr>
				<td colspan="3"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.dom.second_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.dom.second_right}
					{$BLOCKS.dom.second_right_1}
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- /dom -->
<!-- vecher block begin-->
<tr><td colspan="5" height="8"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="5" height="2" bgcolor="#D7E8EA"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr><td colspan="5" bgcolor="#D7E8EA" class="stitle2">
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" bgcolor="#E9EFEF" style="padding:5px 4px 4px 20px;" class="t12"><a href="/weekfilm/"><img src="/_img/design/200608_title/common/rugion_erholen.gif" title="Отдых" alt="Отдых" border="0"></a></td>
		<td width="150" style="padding-left:30px; height: 30px;" class="t12slogan">
			все&nbsp;развлечения&nbsp;Саратова</td>
		<td style="padding-left:30px;padding-right:10px;">
		</td>
	</tr></table></td></tr>
<tr><td colspan="5" height="5"><img src="/_img/x.gif" height="2" alt="" /></td></tr>
<tr>
	<td class="menu" width="150" valign="top" bgcolor="#E9EFEF">
		<div style="padding:5px">
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/weekfilm/" target="_blank">Фильм недели</a><br />
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/starspeak/" target="_blank">Звезды говорят</a><br>
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			{*<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/love/" target="_blank">Знакомства</a><br />
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />*}
			{*<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/gallery/" target="_blank" style="color:red">Фотогалерея</a><br />*}
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/horoscope/" target="_blank">Гороскоп</a><br />
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/dream/" target="_blank">Сонник</a><br />
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
			<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009533" target="_blank">Форум</a><br />
			<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
	</td>
	<td bgcolor="#ffffff"><img src="/_img/x.gif" width="14" alt="" /></td>
	<td valign="top">
		<table cellpadding="0" cellspacing="0" border=0>
			<tr><td width="50%" valign="top">
				{$BLOCKS.vecher.first_left}
				<img src="/_img/x.gif" width="1" height="4" border="0" alt="" /><br/>
			</td>
			<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
			<td width="50%" valign="top">
				{$BLOCKS.vecher.first_right}
				<img src="/_img/x.gif" width="1" height="4" border="0" alt="" /><br/></td>
			</tr>
			<tr>
				<td width="50%" valign="top">
					{$BLOCKS.vecher.second_left}
				</td>
				<td bgcolor="#ffffff"><img src="/_img/x.gif" width="20" alt="" /></td>
				<td width="50%" valign="top">
					{$BLOCKS.vecher.second_right}
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- vecher block end -->

<!-- Begin Forums Block-->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="3" height="8"><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#E9EFEF"><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
	<tr>
		<td bgcolor="#ffffff" colspan="5"><img src="/_img/x.gif" width="8" alt="" /></td>
	</tr>
	<TR>
		  <TD width="150" valign="top" bgcolor="#e9efef">
		<div style="padding: 5px 5px 5px 5px;">
		<span style="margin-left:4px" class="t12"><b>Форумы Саратова</b><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/" target="_blank">
		Форум на {$CURRENT_ENV.site.domain}</a><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009584" target="_blank">
		Всё о финансах</a><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009563" target="_blank">
		Автофорум</a><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009597" target="_blank">
		Все о доме</a><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0" align="middle" alt="" /> <a href="/forum/view.php?id=1009533" target="_blank">
		Все о развлечениях</a><br>
		<img src="/_img/x.gif" width="1" height="7" border="0" alt="" /><br />
		</div>
  		</TD>
  		<TD width="14"><IMG alt="" src="/_img/x.gif" width=14></TD>
		<TD valign="top">
			{$BLOCKS.last_row.lastsection}
		</TD>
	</TR>
	<tr>
		<td colspan="3" height="8"><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#E9EFEF"><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
	<tr>
		<td bgcolor="#ffffff" colspan="5"><img src="/_img/x.gif" width="8" alt="" /></td>
	</tr>
</table>
<!-- End Forums Block-->

<!-- Begin Firms Block-->
{*<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<TD width="150" valign="top" bgcolor="#e9efef">
		</TD>
  		<TD width="14"><IMG alt="" src="/_img/x.gif" width=14></TD>
		<TD valign="top">
			{$BLOCKS.last_row.firmsection}
		</TD>
	</tr>
	<tr>
		<td colspan="3" height="8"><img src="/_img/x.gif" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#E9EFEF"><img src="/_img/x.gif" height="3" alt="" /></td>
	</tr>
	<tr>
		<td bgcolor="#ffffff" colspan="5"><img src="/_img/x.gif" width="8" alt="" /></td>
	</tr>
</table>*}
<!-- End Firms Block-->

<!--Job Block-->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="150" bgcolor="#E9EFEF" valign="top" style="padding-top:8px;padding-bottom:3px;">
			{$BLOCKS.last_row.yandex_direct}
			{$BLOCKS.last_row.statistic}
		</td>
		<td style="padding-left:10px" valign="top">
	    		<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td align="center" colspan="3"></td>
				</tr>
				<tr>
					<td width="50%" valign="top">{$BLOCKS.last_row.poll}</td>
					<td bgcolor="#ffffff" width="20">&nbsp;</td>
					<td width="50%" valign="top">{$BLOCKS.last_row.job}</td>
				</tr>
			</table>
		</td>
	</tr>
<!--Job Block: End-->
</table>
{include file="design/200608_title/mod_main_region_v2/footer_main.tpl"}