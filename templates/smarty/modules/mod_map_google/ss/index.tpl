{*<div style="display:block;position:absolute; z-index:99; width:300px; height:150px; overflow: auto;" id="log"></div>*}
 		<div id="map_cont">

			<div id="map_cmw">
				<div class="title">
					<div class="close"><img id="map_cmw_close" src="/_img/modules/map_google/krest.gif" width="14" height="14" border="0" alt="Закрыть" style="cursor: pointer; cursor: hand;" /></div>
					<div class="text">Ссылка на эту карту</div>
				</div>
				<div class="body">
					<input type="text" id="map_cmw_link" value="" />
					<br/>
					Вы можете передать ссылку через эл. почту
				</div>
			</div>

	 		<div id="map_tabs">
				<ul id="tabs_accord">
				<li>
					<div class="ui-accordion-link">Мои точки</div>
					<div class="ui-accordion-cont">
						<div style="overflow: auto; height:100%;">
							<ul id="points_list"></ul>
							<div id="points_list_command">
								<input type="button" id="pcmd_start_putting" value="Поставить точку" />
								<input type="button" id="pcmd_stop_putting" value="Не ставить точки" />
								<input type="button" id="pcmd_save" value="Сохранить точки" />
								<input type="button" id="pcmd_show_all" value="Показать все точки" />
							</div>
							<div id="points_list_help">
								Вы можете отметить точки на карте. Для этого:<br/>
								<ul>
								<li>нажмите на кнопку "Поставить точку",</li>
								<li>нажмите левую кнопку мыши в нужном месте карты,</li>
								<li>дайте название и описание точке,</li>
								<li>при необходимости повторите пункты 2-3,</li>
								<li>нажмите на кнопку "Сохранить точки",</li>
								<li>теперь Вы можете передать кому-нибудь ссылку на эту карту с точками.</li>
								</ul>
							</div>
							{if $CURRENT_ENV.regid==16}{banner_v2 id=1855}{/if}
						</div>
					</div>
				</li>
				{if in_array($CURRENT_ENV.regid,array(2,16,34,59,61,63,72,74))}
				<li>
					<div class="ui-accordion-link">О проекте</div>
					<div class="ui-accordion-cont">{include file="design/200608_title/common/block_map_under_footer.tpl"}</div>
				</li>
				{/if}
 {*
				<li>
					<div class="ui-accordion-link">Помощь</div>
					<div class="ui-accordion-cont">
					гы... это хелп
					</div>
				</li>
*}
				</ul>
	 		</div>

	 		<div id="map_box">
		 		<div id="map_area"></div>
	 		</div>

 		</div>

<script type="text/javascript" language="javascript" charset="utf-8" src="http://maps.google.com/maps?file=api&v=2&key={$page.key}"></script>
<script type="text/javascript" language="javascript">
{literal}
$(document).ready(function(){
	if(typeof(NMapGoogle) != "undefined"){
{/literal}
		var oNMap = new NMapGoogle('oNMap');
		oNMap.baseUrl = 'http://{$ENV.site.domain}/{$ENV.section}/';
		oNMap.setMapCont('map_cont');
		oNMap.setDefaultPosition({$page.default.sw_lat}, {$page.default.sw_lng}, {$page.default.ne_lat}, {$page.default.ne_lng});
		oNMap.setCurPosition({$page.current.sw_lat}, {$page.current.sw_lng}, {$page.current.ne_lat}, {$page.current.ne_lng});
		oNMap.setMapType('{$page.mt}');
		oNMap.init();
		{if $page.points != ''}
		oNMap.loadPoints('{$page.points}');
		{/if}
{literal}
	}
});
{/literal}
</script>
