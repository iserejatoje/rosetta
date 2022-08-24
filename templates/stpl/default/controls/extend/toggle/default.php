<div class="ctrl_extend_toggle"><div style="padding-top:2px;padding-bottom:2px;" class="<? if ( $vars['this']->GetState() === true ): ?>on<? else: ?>off<? endif; ?>" id="<?=$vars['this']->GetID()?>_toggle">
	<?=$vars['this']->GetTitle()?>
</div></div>

<script type="text/javascript" language="javascript">
	$('#<?=$vars['this']->GetID()?>_toggle').click(function() {
		//$('#<?=$vars['this']->GetID()?>_toggle').html('<img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" border="0" />');
		if ( $('#<?=$vars['this']->GetID()?>_toggle').hasClass('on') )
		{
			$.ajax({
				url: '<?=$vars['this']->GetAction(false)?>',
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					if (data.success == true) {
						$('#<?=$vars['this']->GetID()?>_toggle')
							.html('<?=$vars['this']->GetTitle(false)?>')
							.removeClass('on')
							.addClass('off');
					} else {
						$('#<?=$vars['this']->GetID()?>_toggle').html('<?=$vars['this']->GetTitle(true)?>');
					}
				},
				failed: function () {
					$('#<?=$vars['this']->GetID()?>_toggle').html('<?=$vars['this']->GetTitle(true)?>');
				}
			});
		} else {
			$.ajax({
				url: '<?=$vars['this']->GetAction(true)?>',
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					if (data.success == true) {
						$('#<?=$vars['this']->GetID()?>_toggle')
							.html('<?=$vars['this']->GetTitle(true)?>')
							.removeClass('off')
							.addClass('on');
					} else {
						$('#<?=$vars['this']->GetID()?>_toggle').html('<?=$vars['this']->GetTitle(false)?>');
					}
				},
				failed: function () {
					$('#<?=$vars['this']->GetID()?>_toggle').html('<?=$vars['this']->GetTitle(false)?>');
				}
			});
		}
	});
</script>