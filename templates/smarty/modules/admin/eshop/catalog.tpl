
<div id="node_window" style="z-index:1001;display:none">
	<div class="title">Добавить раздел</div>
	<div class="body">
		<input type="hidden" id="NodeID" name="NodeID" value=""/>
		<table width="100%" cellspacing="1" class="dTable">
			<tr>
				<td bgcolor="#F0F0F0">Название</td>
				<td width="100%" colspan="2">
					<input type="text" id="Title" name="Title" value="" class="input_100">
				</td>
			</tr>
			<tr>
				<td bgcolor="#F0F0F0">Имя (для ссылки)</td>
				<td width="100%" colspan="2">
					<input type="text" id="NameID" name="NameID" value="" class="input_100"><br/>
					<small>Доступные символы: цифры, буквы латинского алфавита и знак "_" </small>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F0F0F0">&nbsp;</td>
				<td>
					<input type="checkbox" id="isVisible" name="isVisible" value="1">
				</td>
				<td width="100%">
					<label for="isVisible">&nbsp;показывать</label>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F0F0F0">&nbsp;</td>
				<td>
					<input type="checkbox" id="isAnnounce" name="isAnnounce" value="1">
				</td>
				<td width="100%">
					<label for="isAnnounce">&nbsp;анонсировать в меню</label>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F0F0F0" colspan="3" align="center">
					<input type="button" value="Сохранить" id="btn_save"/> <input type="button" value="Закрыть" id="btn_close"/>
				</td>
			</tr>
		</table>
	</div>
</div>

<p><b>
	{foreach from=$path item=p name=path}
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
		{if !$smarty.foreach.path.last}&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp; {/if}
	{/foreach}</b>
</p>

{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div><br/>
{else}
	<p><a href="?{$SECTION_ID_URL}&action=new_node&parent={$node->id}&treeid={$node->treeid}">Добавить раздел</a></p>
{/if}

<script>{literal}
function checkaction()
{
	obj = document.getElementById("action");
	if(obj.options[obj.selectedIndex].value=='')
		return false;
	return true;
}
{/literal}</script>

<form name="tree" action="" method="post" onsubmit="return checkaction();">

<table width="100%" border="0" cellspacing="1" class="dTable" id="tree">
	<tr>
		<th width="100%">Название</th>
		<th>Имя ссылки</th>
		<th>Сорт.</th>
		<th>Видимость</th>
		<th>  Анонс  </th>
		<th>Япония</th>
		<th></th>	
		<th></th>
	</tr>
	{if $childs !== null}
	{foreach from=$childs item=node}
		{include file="eshop/node.tpl" node=$node}
	{/foreach}
	{/if}
</table>

<br/>
<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="save_node">Обновить раздел</option>
		<option value="show_node">Показать раздел</option>
		<option value="hide_node">Скрыть раздел</option>
		<option value="anon_node">Анонсировать раздел</option>
		<option value="notanon_node">Не анонсировать раздел</option>
		<option value="delete_node">Удалить раздел</option>
	</select>
	<input type="submit" value="Ок" />
</nobr></div>

</form>

{literal}
<script>
	function showNodeWindow() {
		$('#node_window').show();
		upRegActions();
		disableButtons(false);

		$('#node_window').css({
			top: Math.round(($(window).height()/2)-($('#node_window').height()/2))+'px',
			left: Math.round(($(window).width()/2)-($('#node_window').width()/2))+'px'
		});

		progressLayer = $('<div id="progressLayer"></div>').css({
			'opacity': 0,
			'backgroundColor': '#FFFFFF',
			'zIndex': 1000,
			'position': 'absolute',
			'top': 0,
			'left': 0
		});

		$(document.body).append(progressLayer);

		progressLayer.css({
			height: $(document).height()+'px',
			width: $(document).width()+'px'
		});

		progressLayer.fadeTo("slow", 0.5);
	}

	function hideNodeWindow() {
		$('#progressLayer').remove();
		$('#node_window').hide();
	}

	function markRowNodes() {
		$('tr', '#tree').css("background-color", "transparent");
		$('tr:odd', '#tree').css("background-color", "#F0F0F0");
	}

	function upRegActions() {
		$('#btn_close').unbind('click');
		$('#btn_save').unbind('click');
	}

	function disableButtons(disabled) {
		if (disabled !== false)
			disabled = true;
			
		$('#btn_save').attr('disabled', disabled);
		$('#btn_close').attr('disabled', disabled);
	}
	
	function regCreateActions() {

		$('.title', '#node_window').html('Добавить раздел');

		$('#btn_close').bind('click', function(){
			hideNodeWindow();
		});

		$('#btn_save').bind('click', function(){
			var NodeID = $('#NodeID').val();

			disableButtons(true);
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: window.location.href,
				data: {
					action: 'append_child',
					id: NodeID,
					Title: $('#Title').val(),
					NameID: $('#NameID').val(),
					isVisible: ($('#isVisible:checked').size() ? 1 : 0),
					isAnnounce: ($('#isAnnounce:checked').size() ? 1 : 0)
				},
				cache: false,
				success: function(data) {
					if (data && data.status == 'error') {
						alert(data.message);
						disableButtons(false);
						return ;
					}

					alert('Раздел успешно добавлен');

					if (data.html) {
						if (data.level == 1)
							$('#tree').append(data.html);
						else
							$('#nc'+NodeID).after(data.html);

						markRowNodes();
						document.location.hash = 'node'+data.id;
					}
					$('#btn_close').click();
				},
				error: function() {
					disableButtons(false);
				}
			});
		});
	}

	function regUpdateActions() {
		$('.title', '#node_window').html('Редактировать раздел');

		$('#btn_close').one('click', function(){
			hideNodeWindow();
		});

		$('#btn_save').bind('click', function(){
			var NodeID = $('#NodeID').val();

			disableButtons(true);
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: window.location.href,
				data: {
					action: 'update_node',
					NodeID: NodeID,
					Title: $('#Title').val(),
					NameID: $('#NameID').val(),
					isVisible: ($('#isVisible:checked').size() ? 1 : 0),
					isAnnounce: ($('#isAnnounce:checked').size() ? 1 : 0)
				},
				cache: false,
				success: function(data) {
					if (data && data.status == 'error') {
						alert(data.message);
						disableButtons(false);
						return ;
					}

					alert('Раздел успешно обновлен');

					if (data.html) {
						$('#nc'+NodeID).after(data.html);
						$('#nc'+NodeID).remove();

						markRowNodes();
						document.location.hash = 'node'+data.id;
					}
					$('#btn_close').click();
				},
				error: function() {
					disableButtons(false);
				}
			});
		});
	}

	function createNode(nodeId) {
		showNodeWindow();

		$('#NodeID').val(nodeId);
		$('#Title').val('');
		$('#NameID').val('');
		$('#isVisible').attr('checked', false);
		$('#isAnnounce').attr('checked', false);

		regCreateActions();
	}

	function editNode(nodeId) {
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: window.location.href,
			data: {
				action: 'edit_node',
				id: nodeId
			},
			cache: false,
			success: function(data) {
				if (data && data.status == 'error') {
					alert(data.message);
					return ;
				}

				showNodeWindow();
				regUpdateActions();

				$('#NodeID').val(data.id);
				$('#Title').val(data.title);
				$('#NameID').val(data.nameid);

				if (data.isvisible > 0)
					$('#isVisible').attr('checked', true);

				if (data.isannounce > 0)
					$('#isAnnounce').attr('checked', true);
			}
		});
	}

	$(document).ready(markRowNodes);

	$('#appendChild').bind('click', function() {
		createNode({/literal}{$root->id}{literal});
	});

</script>
{/literal}

{literal}
<style>
#node_window {
	display: none;
	position: absolute;
	width: 500px;
	background-color: #005A52;
	padding: 1px;
	z-index: 2020;
}

#node_window .title {
	position: relative;
	height: 16px;
	background-color: #E0F3F3;
	padding: 2px;
	font-weight: bold;
	font-size: 12px;
	color: #005A52;
	_margin-right: -4px;
}

#node_window .body {
	position: relative;
	margin-top: 1px;
	padding: 2px;
	background-color: #FFFFFF;
}


</style>
{/literal}