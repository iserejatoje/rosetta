<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?=App::$Title->Head?>
</head>
<body>
<style>
	.label-alert {
		background-color: #d9534f;
	    font-size: 18px;
	    line-height: 30px;
	    color: #fff;
	    text-align: center;
	    width: 100%;
	    height: 30px;
	}

	.close-alert {
		width: 40px;
	    height: 30px;
	  /*  background-color: #380000;*/
	    color: #fff;
	    display: inline-block;
	    margin-left: 20px;
	    float: right;
	}

	.close-alert:hover {
		cursor: pointer;
		background-color: #380000;
    	transition: background-color 500ms linear;
	}
</style>

<script type="text/javascript" language="javascript">
	function configList(obj,sectionid)
	{
		$.ajax({
			url: '.config_list/?sectionid='+sectionid,
			type: 'get',
			dataType: 'html',
			success: function (data) {
				$('#config_list_container').remove();

				if ( data.length > 0 )
				{
					$(obj).after($('<div id="config_list_container"></div>').html(data));

					var timeout;
					$('#config_list').dropDownMenu({timer: 500, parentMO: 'parent-hover', childMO: 'child-hover1'});
					$('#config_list').bind("mouseleave", function() {
						timeout = setTimeout(function(){
							$('#config_list_container').remove();
						}, 500);
					}).bind("mouseenter", function() {
						clearTimeout(timeout);
					});
				}
				else
					alert("Раздел не имеет конфигов");
			},
			failed: function()
			{
				alert('Не удалось получить список конфигов');
			}
		});
	}

	(function connection() {
		$.ajax({
	        type: "POST",
            // url:  "<?= App::$Protocol ?>" + "rosetta.florist/admin/site/rosetta.florist/service/.module/service/",
	        url:  "/admin/site/rosetta.florist/service/.module/service/",
	        data: {'action': 'ajax_check_news'},
	        async: true,
	        success: function(data) {

	        	if(data.is_exist == 1) {
	        		for(i = 0; i < data.alerts.length; i++) {
	        			if(!$('.label-alert').is("#alert"+data.alerts[i].AlertID)) {
	        				$('#alerts').append('<div id="alert'+data.alerts[i].AlertID+'" class="label-alert" style="background-color: '+data.alerts[i].Color+'">'+data.alerts[i].Name+'<div class="close-alert" onclick="closeAlert('+data.alerts[i].AlertID+')">X</div></div>');
	        			}
	        		}
	        	}
	        },

    	});
    	setTimeout(connection,10000);
	})();

	function closeAlert(id) {
		$.ajax({
	        type: "POST",
            // url:  "<?= App::$Protocol ?>" + "rosetta.florist/admin/site/rosetta.florist/service/.module/service/",
	        url:  "/admin/site/rosetta.florist/service/.module/service/",
	        data: {'action': 'ajax_close_alert', 'id': id},
	        async: true,
	        success: function(data) {
	        	if(data.status == 'ok')
	        		$('#alert'+data.id).remove();
	        },

    	});
	}

</script>
<div id="alerts" style="position: fixed; width: 600px; bottom:0; right: 0; z-index: 2"></div>
<div id="content">
<? if(!App::$User->IsInRole('e_adm_execute_users') && !App::$User->IsInRole('e_adm_execute_section')) { ?>
<? } ?>

<? if((App::$User->IsInRole('e_adm_execute_users') && App::$User->IsInRole('e_adm_execute_section')) == false ) { ?>
<div id="treepath" class="ctrl_extend_path"><a href="/admin/">разделы</a></div>
<? } else { ?>
<? echo $vars['path']->Render();?>
<? } ?>

<div style="float:left">
    <? $vars['path']->Render();?>
</div>

<div style="float:right">
	<a href="/account/logout.php" class="link">Выход</a></br>
	<a href="/account/logout.php?ALL=TRUE" class="link">Выкинуть всех</a>
</div>

<br clear="both"/><br>
<div class="title"><?=$vars['title']?></div>

<?if(isset($vars['menu'])):?><br><?=$vars['menu']->Render();?><br><br><?endif;?>

<?if(isset($vars['list'])):?><?=$vars['list']->Render();?><br><?endif;?>

<?=$vars['html']?>
</div>
</body>
</html>
