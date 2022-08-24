<script type="text/javascript" language="javascript">{literal}
	$(document).ready(function(){
		var word = '{/literal}{$word.Word}{literal}';
		var query = '{/literal}{$query}{literal}';
		var form = $($("#{/literal}{$query_field}{literal}").attr('form'));
		var el = $("#{/literal}{$query_field}{literal}");
		
		if (!word || query.length != 0)
			el.focus();
		else {
			el.css('color', '#CCCCCC').val(word);
			var change = function() {
				if (word && el.attr('_clear') !== true)
					el.val('');

				el.attr('_clear', true);
				el.css('color', '');
			}

			el.one(($.browser.opera ? "keypress" : "keydown")+' click', change);
			//el.one('click', change);
			form.one('submit', function() {
				if (word && el.attr('_clear') !== true)
					this.wordid.value = {/literal}{$word.WordID}{literal};
			});
		}

	});{/literal}
</script>