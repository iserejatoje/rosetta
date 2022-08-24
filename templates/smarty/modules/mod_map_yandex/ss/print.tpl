{literal}

<script type="text/javascript">
	
	$(document).ready(function () {
	
		$('#map_area_print').yandexmap({
			controlsList: {
				SmallZoom: {
					enable: true
				}
			},
			enableScrollZoom: false,
			enableDragging: false,
			enableDblClickZoom: false,
			placeMarksList: {/literal}{if !empty($page.placeMarksListJS)}{$page.placeMarksListJS}{else}'[]'{/if}{literal},
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
			},
			placeMark: {
				draggable: false,
				hasBalloon: false
			}
		});
	});

</script>
{/literal}


<div id="map_area_print">
</div>

{if is_array($page.placeMarksList) && sizeof($page.placeMarksList)}
<div id="print_pmListArea">
	<div><b>Список точек:</b></div>
	<ul id="print_pmList">
		{foreach from=$page.placeMarksList item=pm}
		<li>
			<span class="name">{$pm.name}</span><br/>
			<span class="text">{$pm.text}</span><br/>
		</li>
		{/foreach}
	</ul>
</div>
{/if}

<div id="print_Comment">
	<div><b>Комментарий:</b></div>
	<div id="print_CommentReady"></div>
	<div id="print_CommentEdit">
		<div>
			<textarea id="print_CommentText"></textarea>
		</div>
		<div>
			<input type="button" value="Печать" id="print_CommentButton" onclick="$('#print_CommentReady').show().html($('#print_CommentText').val());$('#print_CommentEdit').remove();window.print();"/>
		</div>
	</div>
</div>
