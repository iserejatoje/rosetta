{literal}

<script type="text/javascript">
	
	$(document).ready(function () {
	
		$("#mapAccordion").accordion({header : 'div.ui-accordion-link',duration: 500, fullheight: true});
	
		var activeTab = 0;
		var activeBalloon = '';
		var hash = window.location.hash.substr(1).split('/');

		for(var i=0;i<hash.length;i++) {	
			if (hash[i].search(/^tab-\d+$/i) != -1) {
				activeTab = hash[i].replace(/tab-(\d+)/i, '$1')-1
			}
			
			if (hash[i].search(/^balloon-.+$/i) != -1) {
				activeBalloon = hash[i].replace(/balloon-(.+)/i, '$1')
			}
		}
	
		$('#map_area').yandexmap({
			placeMarksList: {/literal}{if $page.placeMarksListJS}{$page.placeMarksListJS}{else}'[]'{/if}{literal},
			RulerState: '{/literal}{$page.Rule}{literal}',
			placeMarkCode: '{/literal}{$page.Code}{literal}',
			geoSearchQuery: '{/literal}{"\\"|str_replace:"\\\\":$page.Query}{literal}',
			mapCenter: {
				Coords: [
					'{/literal}{$page.Coords[0]}{literal}',
					'{/literal}{$page.Coords[1]}{literal}'
				],
				Span: [
					'{/literal}{$page.Span[0]}{literal}',
					'{/literal}{$page.Span[1]}{literal}'
				],
				Type: '{/literal}{$page.Type}{literal}'
			}
		});
		{/literal}{if $smarty.get.co >= 12}{literal}
		
		var options = {/literal}{$page.CityOnLine}{literal};
		
		options.header = $('#CityOnLine');
		options.activeBalloon = activeBalloon;
		
		var yandexMapCityOnline = new $.yandexmap.cityonline($('#map_area'), options);

		$("#mapAccordion").find("div.ui-accordion-link").each(function(i) {
			$(this).bind('click', {index: i}, function(e) {
				
				yandexMapCityOnline.hideLayer();
			
				switch(e.data.index) {
					case 1:					
						yandexMapCityOnline.showLayer();
						
						var currentBalloon = $('#map_area').get(0).yandexMap.getBalloon();
						if (!currentBalloon || currentBalloon.getContent().id != 'cityOnLineBalloon')
							$('#map_area').get(0).yandexMap.closeBalloon();
						else if (currentBalloon)
							currentBalloon.mapAutoPan();
						
					break;
					default:
						$('#map_area').get(0).yandexMap.closeBalloon();
				}
			})
		});
		
		$("#mapAccordion").activate(activeTab);
		$("#mapAccordion").find("div.ui-accordion-link:eq("+activeTab+")").trigger('click');

		{/literal} {/if} {literal}
	});

</script>
{/literal}

<div id="map_cmw">
	<div class="title">
		<div class="close"><img height="14" border="0" width="14" style="cursor: pointer;" alt="Закрыть" src="/_img/modules/map_google/krest.gif" id="map_cmw_close"/></div>
		<div class="text">Ссылка на эту карту</div>
	</div>
	<div class="body">
		<input type="text" value="" id="map_cmw_link"/>
		<br/>
		<small>Вы можете передать ссылку через эл. почту</small>
	</div>
</div>

<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td id="map_tabs">
			<ul id="mapAccordion" class="ui-accordion">
			<li>
				<div class="ui-accordion-link">Поиск</div>
				<div class="ui-accordion-cont">
					<div id="map_search">
						<div class="p">
							<form onsubmit="return false">
								<div class="row">
									<div style="width: 140px;" class="cell">
										<input type="text" value="{if !is_array($page.placeMarksList) || !sizeof($page.placeMarksList)}{$page.Query}{/if}" style="width: 130px;" id="geoSearchTxt"/>
									</div>
									<div class="cell">
										<input type="submit" value="Искать!" style="width: 60px;" id="geoSearchBnt"/>
									</div>
								</div>
							</form>
							<div>
								<table class="hint" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<input type="checkbox" value="{$CURRENT_ENV.site.name}" id="geoCityName" {if $page.cQuery}checked="checked"{/if}/>
										</td>
										<td width="100%">
											 <label for="geoCityName">в {$CURRENT_ENV.site.name_where}</label>
										</td>
									</tr>
									<tr>
										<td colspan="2">например: <span onclick=" $('#geoSearchTxt').val($(this).html()); $('#geoSearchBnt').click();" style="cursor: pointer;">Энтузиастов ул.</span></td>
									</tr>
									{*<tr>
										<td colspan="2"></td>
									</tr>*}
								</table>
							</div>
						</div>
					</div>
					<ul id="gmList"></ul>
				</div>
			</li>
			{if $smarty.get.co >= 12}
			<li>
				<div class="ui-accordion-link" id="pointOnlineCancel">Улицы онлайн</div>
				<div class="ui-accordion-cont">
					<ul class="pList" id="CityOnLine"></ul>
				</div>
			</li>
			{/if}
			{if is_array($page.pointTypeList) && sizeof($page.pointTypeList)}
			<li>
				<div class="ui-accordion-link" id="pointTypeCancel">Справочник фирм</div>
				<div class="ui-accordion-cont">
					<div id="pointTypeList">
						<ul id="ptList">
					{foreach from=$page.pointTypeList item=l key=k}
						{if $l.count > 0}
							<li><a id="pointType{$k}" href="javascript:;">{$l.title}</a></li>
						{/if}
					{/foreach}
						</ul>
						<div id="ptListResult">
							
						</div>
					</div>
				</div>
			</li>
			{/if}
			<li>
				<div class="ui-accordion-link">Мои метки</div>
				<div class="ui-accordion-cont">
					<div>
						<ul id="pmList"></ul>
						<div id="pmListCmd">
							<input type="button" id="cmdStartPutting" value="Поставить метку" />
							<input type="button" id="cmdStopPutting" value="Не ставить метки" />
							<input type="button" id="cmdSaveMarks" value="Сохранить метки" />
							<input type="button" id="cmdShowMarks" value="Показать все метки" />
						</div>
						<div id="pmListHelp">
							Вы можете отметить метки на карте. Для этого:<br/>
							<ul>
							<li>нажмите на кнопку "Поставить метку",</li>
							<li>нажмите левую кнопку мыши в нужном месте карты,</li>
							<li>дайте название и описание точке,</li>
							<li>при необходимости повторите пункты 2-3,</li>
							<li>нажмите на кнопку "Сохранить метки",</li>
							<li>теперь Вы можете передать кому-нибудь ссылку на эту карту с точками.</li>
							</ul>
						</div>
					</div>
				</div>
			</li>
			{if in_array($CURRENT_ENV.regid,array(2,16,24,26,29,34,48,56,59,61,62,63,72,74,76,93,193,64,66))}
			<li>
				<div class="ui-accordion-link">О проекте</div>
				<div class="ui-accordion-cont">{include file="design/200608_title/common/block_map_under_footer.tpl"}</div>
			</li>
			{/if}
			</ul>
		</td>
		<td id="map_box">
			<span id="console"></span>
			<div id="map_cont">
				<div id="map_area"> </div>
			</div>
		</td>
	</tr>
</table>