	{include file="`$TEMPLATE.sectiontitle`" rtitle="Работа: Вакансии и резюме по рубрикам"}
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr>
					<th>Вакансии ({$page.allvac|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/1.php" style="color:red;" {if $ENV.site.domain=="74.ru"}onclick="OnCounterClick(131);"{/if}>новые</a></th>
					<th>Резюме ({$page.allres|number_format:"0":",":" "}) &nbsp;&nbsp;<a href="/{$ENV.section}/resume/1.php" style="color:red;">новые</a></th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$page.razdel item=l name=razdel}
					{*capture name="link"}{if $ENV.regid == 74 && $l.rid == 5}http://cheldoctor.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(1,11,22))}http://chel.ru/job/{elseif $ENV.regid == 74 && in_array($l.rid,array(13,21,32))}http://chelfin.ru/job/{else}/{$ENV.section}/{/if}{/capture}
					{capture name="target"}{if $ENV.regid == 74 && in_array($l.rid,array(2,13,33,23,30,1,10))} target="_blank"{/if}{/capture*}
				<tr class="{excycle}">
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/vacancy/{$l.rid}/1.php">{if $l.rid==1 || $l.rid==37}<font color="red">{/if}{$l.rname}{if $l.rid==1 || $l.rid==37}</font>{/if}</a></div><div class="text11" style="float:right">{$l.vcount|number_format:"0":",":" "}</div></td>
					<td width="50%"><div style="float:left">&nbsp;&nbsp;<a href="/{$ENV.section}/resume/{$l.rid}/1.php">{if $l.rid==1 || $l.rid==37}<font color="red">{/if}{$l.rname}{if $l.rid==1 || $l.rid==37}</font>{/if}</a></div><div class="text11" style="float:right">{$l.rcount|number_format:"0":",":" "}</div></td>
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
				{elseif $smarty.foreach.razdel.iteration == 28 && $TEMPLATE.lastbanner2}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.lastbanner2`"}</td>
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
Тюменский бизнес-портал 72.ru представляет пользователям полезный раздел &laquo;Работа&raquo;. Здесь любой желающий найти хорошую работу может разместить резюме, а организации могут подать объявление об имеющихся вакансиях. Все анкеты модерируются, что позволяет создать уникальный банк вакансий и резюме. Подробный рубрикатор облегчает задачу поиска нужного резюме, а размещение вакансии в рубриках &laquo;Вакансии компаний&raquo; и &laquo;Вакансии кадровых агентств&raquo; до минимума сократит поиск самого подходящего кандидата.<br/>
Мы постоянно совершенствуем сервис &laquo;Работа&raquo;, стараясь сделать его еще более удобным и эффективным, поэтому, если у вас возникли вопросы, пожелания или рекомендации, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://72.ru/feedback/?from=1022', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;.<br/>
{/if}
{if $CURRENT_ENV.regid == 63}
Самарский городской сайт 63.ru уже много лет предлагает пользователям сети Интернет простой и эффективный способ поиска работы в Самаре. Ежедневно раздел &laquo;Работа&raquo; пополняют почти две тысячи вакансий и резюме. С нами сотрудничают кадровые агентства &mdash; ведущие представители рынка труда.<br />
Все объявления после их размещения на 63.ru подлежат обязательному модерированию, что делает базу вакансий и резюме уникальной.<br />
Мы постоянно совершенствуем наши сервис &laquo;Работа в Самаре&raquo;, стараясь сделать его еще более удобным и эффективным, поэтому, если у вас возникли вопросы, пожелания или рекомендации, воспользуйтесь ссылкой &laquo;<span title="Открыть" style="cursor: pointer; text-decoration: underline;" target="ublock" onclick="window.open('http://63.ru/feedback/?from=1006', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">Обратная связь</span>&raquo;.
{/if}
{if $CURRENT_ENV.regid == 59}
<span class="tgray9" align="left" style="border-bottom: 1px dashed; cursor: pointer;" onclick="javascript:getElementById('moreinfo').style.display=((getElementById('moreinfo').style.display=='none')?'block':'none');">Без работы не мыслит своего существования ни один взрослый, состоявшийся человек. Отсутствие работы зачастую означает не только материальный тупик, но и моральный дискомфорт, ведь подавляющему большинству людей свойственно увлекаться своей работой, выполнять ее с удовольствием.</span>
<div id="moreinfo" style="display: none;">
<p class="tgray9" align="left">Тем труднее приходится, если работа перестала приносить удовлетворение, или, что тоже случается нередко, под влиянием экономических катаклизмов человек утратил рабочее место. Далеко не у всех есть обширные связи и знакомства, посредством которых можно быстро найти новую работу. Между тем, согласно статистике, вакансии в Перми с каждым месяцем интересуют все большее количество людей. Работа в Перми, как и во многих других городах РФ, нужная тысячам стремящихся к стабильности потенциальным сотрудникам. Городской портал Перми предоставил каждому возможность найти свою работу: все вакансии Перми теперь находятся по одному адресу.</p>
<p class="tgray9" align="left">Поиск работы в Перми с помощью городского портала достаточно прост. Можно просмотреть вакансии по рубрикам, выбрав свою специализацию, или перейти по ссылке одной из компаний, разместивших в разделе &laquo;Работа в Перми&raquo; свою рекламу. Для получения максимально эффективного результата можно воспользоваться строкой поиска по ключевым словам. Примечательно, что принцип поиска разнонаправленный и рассчитан как на соискателей, так и на работодателей.</p>
<p class="tgray9" align="left">Городской портал Перми работает в тесном сотрудничестве с ведущими компаниями и кадровыми агентствами; база вакансий постоянно обновляется, пополняясь ежедневно более чем на тысячу предложений. Чтобы о вас узнало как можно большее количество работодателей, вы можете оставить в этом разделе свое резюме. В Перми нет более популярного и удобного сервиса по поиску работы, чем городской портал.</p>
<p class="tgray9" align="left">Раздел постоянно пополняется также аналитическими обзорами рынка труда. Здесь можно найти информацию об открытии новых филиалов различных компаний, о колебании среднего уровня зарплат, о степени востребованности той или иной специальности. Подробный справочник фирм, расположенный в правой части страницы, даст возможность ознакомиться со всеми работающими в Перми компаниями и представительствами зарубежных корпораций.</p>
</div>
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
<span class="tgray9" align="left" style="border-bottom: 1px dashed; cursor: pointer;" onclick="javascript:getElementById('moreinfo').style.display=((getElementById('moreinfo').style.display=='none')?'block':'none');">В период, когда финансовые трудности коснулись практически всех сфер экономики, поиск работы для тысяч людей актуален, как никогда. Поиск по запросу &laquo;работа в Ростове-на-Дону&raquo;, согласно статистике, является на сегодняшний день одним из наиболее частотных. Для удобства соискателей мы собрали все вакансии в Ростове-на-Дону на одном портале.</span>
<div id="moreinfo" style="display: none;">
<p class="tgray9" align="left">Регулярно пополняющаяся база предложений содержит сотни вариантов работы для специалистов различного профиля. Здесь есть работа в Ростове-на-Дону для топ-менеджеров и рядовых сотрудников, представителей творческих профессий и педагогов, медиков и разнорабочих. Вакансии в Ростове-на-Дону предлагают небольшие компании и филиалы крупных международных холдингов, салоны красоты и студии дизайна, гипермаркеты и рестораны, частные школы и медицинские центры. Все предложения рассортированы по категориям, и каждый посетитель сайта может, не теряя времени, просмотреть интересующие именно его предложения.</p>
<p class="tgray9" align="left">Городской портал работает в тесном сотрудничестве с десятками организаций, которые регулярно размещают на страницах сайта свою рекламу. Перейдя по ссылке в рекламном баннере, вы, возможно, найдете привлекательные предложения о работе в интересующей вас сфере.</p>
<p class="tgray9" align="left">Удобная система поиска позволяет быстро найти предложения о работе в Ростове-на-Дону по индивидуальному запросу. Этот же поиск поможет работодателю быстро найти и просмотреть имеющиеся резюме соискателей.</p>
<p class="tgray9" align="left">Вас интересуют имеющиеся вакансии в Ростове-на-Дону? Вы хотите, чтобы о вашей кандидатуре узнали потенциальные работодатели? Оставьте свое резюме в разделе &laquo;Работа&raquo;, и информация о вас будет доступна сотням интернет-пользователей. Такой способ поиска работы, по мнению экспертов, гораздо более эффективен, чем просмотр объявлений в печатных СМИ или расклейка объявлений о поиске работы на остановках общественного транспорта и уличных информационных щитах.</p>
<p class="tgray9" align="left">Десятки людей ежедневно находят посредством Интернет интересную, хорошо оплачиваемую работу. Вы можете стать одним из них, воспользовавшись услугами городского портала, и, в частности, данными из раздела &laquo;Работа&raquo;.</p>
</div>
{/if}
</p>