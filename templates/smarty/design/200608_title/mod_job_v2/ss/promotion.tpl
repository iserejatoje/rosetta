{include file="`$TEMPLATE.sectiontitle`" rtitle="Способы продвижения вакансий на сайте"}

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table2">
	<tr>
		<td class="text11" style="padding-right: 8px;" valign="bottom" width="100%"><br/>

			<p class="title_normal" style="font-weight: bold;">РАЗМЕЩЕНИЕ В РУБРИКЕ «ВАКАНСИИ КОМПАНИЙ»</p>
			<ol type=1>
			<li><p align="justify">Это доверие соискателей к вакансиям, за которые отвечает целая  компания.</p></li>
			<li><p align="justify">Это размещение информации рекламного характера на собственной странице.</p></li>
			<li><p align="justify">Это возможность добавлять неограниченное количество вакансий.</p></li>
			<li><p align="justify">Это первые позиции в поиске вакансии по ключевым словам.</p></li>
			</ol>

			<p class="title_normal" style="font-weight: bold;">РАЗМЕЩЕНИЕ В РУБРИКЕ «ВАКАНСИИ АГЕНТСТВ»</p>
			<ol>
			<li><p align="justify">Это  доверие соискателей к вакансиям, за которые отвечает кадровое агентство.</p></li>
			<li><p align="justify">Это размещение информации рекламного характера на собственной странице.</p></li>
			<li><p align="justify">Это возможность добавлять неограниченное количество вакансий.</p></li>
			<li><p align="justify">Это первые позиции в поиске вакансии по ключевым словам.</p></li>
			</ol>

			<p class="title_normal" style="font-weight: bold;">РАЗМЕЩЕНИЕ ВАКАНСИИ «КРАСНОЙ СТРОКОЙ»</p>
			<ol>
			<li><p align="justify">Название вашей вакансии выделяется красным цветом.</p></li>
			<li><p align="justify">Вакансия автоматически занимает лидирующие позиции в  общем списке.</p></li>
			<li><p align="justify">Это первые позиции в поиске вакансии по ключевым словам.</p></li>
			</ol>


			<p class="title_normal" style="font-weight: bold;">АБОНЕНТСКАЯ ЗОНА</p>
			<ol>
			<li><p align="justify">Это возможность добавлять неограниченное количество вакансий.</p></li>
			</ol>

			<p class="title_normal" style="font-weight: bold;">УСЛУГА «ПОИСК»</p>
			<ol>
			<li><p align="justify">Это  возможность добавлять неограниченное количество вакансий.</p></li>
			<li><p align="justify">Это первые позиции в поиске вакансии по ключевым словам.</p></li>
			</ol>

			<p class="title_normal" style="font-weight: bold;">БАННЕРНАЯ РЕКЛАМА</p>
			{if !empty($CURRENT_ENV.site.reklama_url)}
				{assign var="url_case" value=$CURRENT_ENV.site.reklama_url}
			{else}
				{if in_array($CURRENT_ENV.site.domain, array('38.ru','42.ru','43.ru','48.ru','51.ru','53.ru','154.ru','omsk1.ru','56.ru','tolyatty.ru','60.ru','62.ru','ekat.ru','68.ru','70.ru','71.ru','178.ru'))}
					{assign var="url_case" value="http://`$CURRENT_ENV.site.regdomain`/price/"}
				{else}
					{assign var="url_case" value="http://`$CURRENT_ENV.site.regdomain`/pages/reklama.html"}
				{/if}
			{/if}
			<p>См. <a href="{if $ENV.site.domain=='74.ru'}http://info74.ru/?view=rek{else}{$url_case}{/if}" target="_blank">Прайс</a></p>

		</td>
	</tr>
</table>