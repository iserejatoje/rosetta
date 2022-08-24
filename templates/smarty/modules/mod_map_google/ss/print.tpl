 		<div id="map_cont">

	 		<div id="map_box">
		 		<div id="map_area"></div>
	 		</div>

 		</div>

		<div id="print_points_area">
			<div><b>Список точек</b></div>
			<ul id="print_points_list"></ul>
		</div>

		<div id="print_comments">
			<div><b>Комментарий</b></div>
			<div id="print_comments_ready"></div>
			<div id="print_comments_edit">
				<div>
					<textarea id="print_comment_text"></textarea>
				</div>
				<div>
					<input type="button" id="print_comment_button" value="Печатать" />
				</div>
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
		oNMap.setMapCont_print('map_cont');
		oNMap.setDefaultPosition({$page.default.sw_lat}, {$page.default.sw_lng}, {$page.default.ne_lat}, {$page.default.ne_lng});
		oNMap.setCurPosition({$page.current.sw_lat}, {$page.current.sw_lng}, {$page.current.ne_lat}, {$page.current.ne_lng});
		oNMap.setMapType('{$page.mt}');
		oNMap.init_print();
		{if $page.points != ''}
		oNMap.loadPoints('{$page.points}');
		{/if}
{literal}
	}
});
{/literal}
</script>
