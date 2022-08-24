<style>
{literal}
.code {
	color: #FF8000;
	font-family: "Courier New" Tahoma Verdana;
}
{/literal}
</style>
<h1 align="center">Экспорт объявлений недвижимости на сайт {$ENV.site.domain}</h1>  
  
<p>Экспорт объявлений позволяет автоматизировать процесс публикации объявлений на сайт {$ENV.site.domain}, что позволяет экономить время, а следовательно и деньги.</p>
  
<p><strong>Описание услуги:</strong></p>
  
<p>Вы подготавливаете и публикуете обновляемый файл с объявлениями. Мы регулярно&nbsp; публикуем объявления из Вашего файла на сайте {$ENV.site.domain}. </p>
  
<p><strong>Общие требования:</strong></p>
  
<ol>
<li>Экспорт данных      производиться в формате XML      (eXtensible Markup Language);</li>
<li>Экспортируемый файл должен      находиться в интернете и быть доступен по протоколу HTTP;</li>
<li>Экспортируемый файл может      быть сжат в <a target="_blank" href="http://ru.wikipedia.org/wiki/ZIP">формате ZIP</a> &nbsp;(в этом случае файл должен иметь      расширение &laquo;zip&raquo;);</li>
<li>Экспортируемый файл должен      содержать не более 10000 объявлений;</li>
<li>Размер файла должен быть      меньше 10 Мегабайт;</li>
<li>Каждое объявление должно      иметь уникальный идентификатор (ID);</li>
<li>Экспортируемый файл должен      удовлетворять требованиям формата, описанным в разделе &laquo;Формат файла&raquo;      данного документа;</li>
</ol>
  
<p><strong>Формат файла данных:</strong></p>
  
<p>Корневой элемент <span class="code">&lt;Export-Sale&gt;</span> содержит два элемента <span class="code">&lt;Date&gt;</span> и &nbsp;<span class="code">&lt;Advertises&gt;</span>.</p>
  
<p>Элемент <span class="code">&lt;Date&gt;</span> должен содержать дату генерации файла в формате ISO 8601 (например: 2008-07-26T20:34:37+06:00). Подробнее: <a target="_blank" href="http://en.wikipedia.org/wiki/ISO_8601">на английском</a>, <a target="_blank" href="http://ru.wikipedia.org/wiki/ISO_8601">на русском</a>.</p>
  
<p>Элемент <span class="code">&lt;Advertises&gt;</span> должен содержать элементы <span class="code">&lt;Adv&gt;</span>.</p>
  
<p>Элемент <span class="code">&lt;Adv&gt;</span> является описанием объявления. Элемент <span class="code">&lt;Adv&gt;</span> должен иметь атрибут ID, равный уникальному идентификатору объявления. Все элементы внутри <span class="code">&lt;Adv&gt;</span> описывают свойства объявления.</p>
  
<p><strong>Свойства объявления:</strong></p>
  
<p>1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Обязательные свойства</p>
  
<p>1.1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Rub&gt;</span> - Идентификатор рубрики</p>
  
<p>1.2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Object&gt;</span> - Идентификатор типа жилья</p>
  
<p>1.3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Region&gt;</span> - Идентификатор района</p>
  
<p>1.4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Series&gt;</span> - Идентификатор серии </p>
  
<p>1.5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Build-type&gt;</span> - Идентификатор типа дома</p>
  
<p>1.6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Status&gt;</span> - Идентификатор состояния</p>
  
<p>1.7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Stage&gt;</span> - Идентификатор стадии строительства (в случае новостройки, в противном случае равно нулю)</p>
  
<p>1.8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Address&gt;</span> - Адрес объекта (поле должно быть оформлено в текстовом виде)</p>
  
<p>1.9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Area-Build&gt;</span> - Площадь помещения (число с плавающей запятой) в кв. метрах</p>
  
<p>1.10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Floor&gt;</span> - Этажность помещения (целое число)</p>
  
<p>1.11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Floors&gt;</span> - Этажность здания (целое число)</p>
  
<p>1.12.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<span class="code">&lt;Area-Site&gt;</span> - Площадь участка (число с плавающей запятой)</p>
  
<p>1.13.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Area-Site-Unit&gt;</span> - Идентификатор единиц измерения площади участка</p>
  
<p>1.14.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Contacts&gt;</span> - Контактные данные (поле должно быть оформлено в текстовом виде)</p>
  
<p>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Дополнительные свойства</p>
  
<p>2.1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Description&gt;</span> - Дополнительная информация (поле должно быть оформлено в текстовом виде)</p>
  
<p>2.2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Ipoteka&gt;</span> - Возможность продажи по ипотеке (0 - нет, 1 - да)</p>
  
<p>2.3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Price&gt;</span> - Цена (число с плавающей запятой)</p>
  
<p>2.4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Price-Unit&gt;</span> - Идентификатор единиц измерения цены</p>
  
<p>2.5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Age-Build&gt;</span> - Идентификатор возрасты здания</p>
  
<p>2.6.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Decoration&gt;</span> - Идентификатор отделки</p>
  
<p>2.7.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Lavatory&gt;</span> - Идентификатор типа санузла</p>
  
<p>2.8.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Phone&gt;</span> - Наличие телефона (0 - нет, 1 - да)</p>
  
<p>2.9.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Balcony&gt;</span> - Наличие балкона (0 - нет, 1 - да)</p>
  
<p>2.10.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Elevator&gt;</span> - Наличие лифта (0 - нет, 1 - да)</p>
  
<p>2.11.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Intercom&gt;</span> - Наличие домофона (0 - нет, 1 - да)</p>
  
<p>2.12.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Alarm&gt;</span> - Наличие сигнализации (0 - нет, 1 - да)</p>
  
<p>2.13.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Furniture&gt;</span> - Наличие мебели (0 - нет, 1 - да)</p>
  
<p>2.14.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="code">&lt;Images&gt;</span> - Элемент со списком фотографий. Должен содержать элементы <span class="code">&lt;Image&gt;</span>.</p>
  
<p>2.14.1.&nbsp;&nbsp; <span class="code">&lt;Image&gt;</span> - HTTP адрес фотографии</p>
  
<p><strong>Идентификаторы свойств:</strong></p>
  
<p>Идентификаторы свойств доступны по адресу: <a href="http://{$ENV.site.domain}/{$ENV.section}/export_id.php">http://{$ENV.site.domain}/{$ENV.section}/export_id.php</a></p>
  
<p>Формат выдачи: Идентификатор - Название</p>
  
<p><strong>Пример:</strong></p>
  
<p>Пример файла экспорта находиться по адресу: <a href="http://{$ENV.site.domain}/{$ENV.section}/export_example.xml">http://{$ENV.site.domain}/{$ENV.section}/export_example.xml</a></p>
  
<p>Пример программы для формирования файла экспорта на языке PHP: <a href="http://{$ENV.site.domain}/{$ENV.section}/export_example_script.php">http://{$ENV.site.domain}/{$ENV.section}/export_example_script.php</a></p>
  
<p>&nbsp;</p>
