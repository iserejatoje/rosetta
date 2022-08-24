	{include file="`$TEMPLATE.sectiontitle`" rtitle="Работа: Вакансии и резюме по рубрикам"}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<th>Вакансии ({$page.allvac|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/1.php" style="color:red;" {if $ENV.site.domain=="74.ru"}onclick="OnCounterClick(131);"{/if}>новые</a></th>
					<th>Резюме ({$page.allres|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/resume/1.php" style="color:red;">новые</a></th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$page.razdel item=l name=razdel}
					{*capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
					{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(1,5,11,13,21,22,32))} target="_blank"{/if}{/capture*}
				<tr class="{excycle}">
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/{$l.rid}/1.php">{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname}{if $l.rid==22 || $l.rid==23}</font>{/if}</a></div><div class="text11" style="float:right">{$l.vcount|number_format:"0":",":" "}</div></td>
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/resume/{$l.rid}/1.php">{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname}{if $l.rid==22 || $l.rid==23}</font>{/if}</a></div><div class="text11" style="float:right">{$l.rcount|number_format:"0":",":" "}</div></td>
				</tr>
				{if $smarty.foreach.razdel.iteration == 7 && ($CURRENT_ENV.regid != 16) && $TEMPLATE.midbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{elseif ($smarty.foreach.razdel.iteration == 5) && ($CURRENT_ENV.regid == 16) && $TEMPLATE.midbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{elseif $smarty.foreach.razdel.iteration == 14 && $TEMPLATE.nizbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.nizbanner`"}</td>
				</tr>
				{elseif $smarty.foreach.razdel.iteration == 21 && $TEMPLATE.lastbanner}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.lastbanner`"}</td>
				</tr>
				{/if}
			{/foreach}
			</table>
<br/><br/><br/>
<p class="tgray9" align="left">
{if $CURRENT_ENV.regid == 2}
Раздел сайта Ufa1.ru &laquo;работа&raquo; является одним из лидеров на рынке поиска работы в Уфе. В базе данных сайта содержится более четырех тысяч вакансий и резюме.<br/>
Сайт Ufa1.ru предоставляет возможность удобного поиска по сервису. Подробный рубрикатор позволяет быстро найти нужную информацию не только соискателям, но и работодателям. На нашем сайте вас ждут новости о важнейших событиях кадрового рынка в Уфе, качественная база вакансий компаний и резюме квалифицированных специалистов.<br/>
Мы стремимся к тому, чтобы работа с порталом Ufa1.ru была удобна всем нашим посетителям. Если у вас возникли вопросы, пожелания или рекомендации, пишите нам в раздел &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://ufa1.ru/feedback/?from=1016', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;. Мы всегда рядом и делаем все, чтобы поиск работы с нашим сайтом был наиболее комфортным!<br/>
{/if}
{if $CURRENT_ENV.regid == 72}
<p class="text11" align="center">
Тюменский бизнес-портал 72.ru представляет пользователям полезный раздел &laquo;Работа&raquo;. Здесь любой желающий найти хорошую работу может разместить резюме, а организации могут подать объявление об имеющихся вакансиях. Все анкеты модерируются, что позволяет создать уникальный банк вакансий и резюме. Подробный рубрикатор облегчает задачу поиска нужного резюме, а размещение вакансии в рубриках &laquo;Вакансии компаний&raquo; и &laquo;Вакансии кадровых агентств&raquo; до минимума сократит поиск самого подходящего кандидата.<br/>
Мы постоянно совершенствуем сервис &laquo;Работа&raquo;, стараясь сделать его еще более удобным и эффективным, поэтому, если у вас возникли вопросы, пожелания или рекомендации, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://72.ru/feedback/?from=1022', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;.<br/>
{/if}
{if $CURRENT_ENV.regid == 63}
Самарский городской сайт 63.ru уже много лет предлагает пользователям сети Интернет простой и эффективный способ поиска работы в Самаре. Ежедневно раздел &laquo;Работа&raquo; пополняют почти две тысячи вакансий и резюме. С нами сотрудничают кадровые агентства &mdash; ведущие представители рынка труда.<br />
Все объявления после их размещения на 63.ru подлежат обязательному модерированию, что делает базу вакансий и резюме уникальной.<br />
Мы постоянно совершенствуем наши сервис &laquo;Работа в Самаре&raquo;, стараясь сделать его еще более удобным и эффективным, поэтому, если у вас возникли вопросы, пожелания или рекомендации, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://63.ru/feedback/?from=1006', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;.
{/if}
{if $CURRENT_ENV.regid == 59}
Пермский городской сайт 59.ru уже много лет предлагает пользователям простой и эффективный способ поиска работы в Перми. Ежедневно в банк вакансий и резюме раздела &laquo;Работа&raquo; поступает полторы тысячи объявлений. С нами сотрудничают ведущие пермские предприятия и организации, кадровые агентства &mdash; лидеры рынка труда.<br />
На нашем сайте вы всегда можете найти последние новости о важнейших событиях местного кадрового рынка, анализ пермских зарплат, качественную базу вакансий компаний и резюме квалифицированных специалистов.<br />
Все объявления в разделе &laquo;Работа в Перми&raquo; модерируются, поэтому перед размещением рекомендуем ознакомиться с правилами. Если у вас возникли вопросы или пожелания, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://59.ru/feedback/?from=1018', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;.
{/if}
{if $CURRENT_ENV.regid == 16}
Казанский городской портал 116.ру предлагает своим пользователям простой и эффективный поиск работы в Казани с использованием самых современных технологий. Наш банк вакансий и резюме ежедневно пополняется тысячей объявлений, и мы прилагаем все усилия, чтобы это число постоянно росло. Мы сотрудничаем с ведущими казанскими кадровыми центрами и предприятиями, заботясь о том, чтобы у вас была возможность выбрать из множества вариантов самый подходящий.<br />
Все объявления, поступающие в базу раздела &laquo;Работа в Казани&raquo;, модерируются, поэтому рекомендуем начать с ознакомления с правилами размещения.<br />
Для удобства пользователей все объявления распределены по отраслевым рубрикам. Мы постоянно совершенствуем наши сервисы, стараясь сделать их еще более эффективными, поэтому, если у вас возникли вопросы или пожелания, напишите нам.
{/if}
{if $CURRENT_ENV.regid == 34}
Волгоградский городской портал V1.ru предлагает пользователям сети Интернет простой и современный способ поиска работы в Волгограде. Раздел &laquo;Работа&raquo; обновляется ежедневно.<br />
Вакансии и резюме разделены строго по рубрикам &mdash; это позволяет сориентироваться в спросе на профессии и определиться с уровнем оплаты труда. Все объявления модерируются, и перед размещением рекомендуем ознакомиться с правилами.<br />
Мы стараемся сделать работу наших сервисов еще более комфортной, не останавливаясь на достигнутом. Поэтому, если у вас возникли вопросы или пожелания по сервису &laquo;Работа в Волгограде&raquo;, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://v1.ru/feedback/?from=866', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo; и напишите нам.
{/if}
{if $CURRENT_ENV.regid == 61}
Если вы задумались о смене места работы или вам нужны квалифицированные сотрудники в команду, ростовский городской портал 161.ru предлагает самый современный и простой способ найти подходящую кандидатуру. Раздел &laquo;Работа в Ростове-на-Дону&raquo; содержит большую базу резюме и самые свежие вакансии ростовского рынка труда.<br />
Вакансии и резюме разделены строго по рубрикам. Все объявления раздела &laquo;Работа в Ростове&raquo; проходят обязательную модерацию, что исключает спам и навязчивые повторы. Перед размещением рекомендуем ознакомиться с правилами.<br />
Мы постоянно совершенствуем наши сервисы, стараясь сделать их еще более эффективными, поэтому, если у вас возникли вопросы или пожелания, напишите нам. Также на форуме 161.ru вы можете найти отзывы о компаниях Ростова-на-Дону и поделиться своим опытом поиска работы с помощью нашего сайта.
{/if}
</p>