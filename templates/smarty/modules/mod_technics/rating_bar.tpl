<script language="javascript">
{literal}
$(window).ready(function(){
	$('#rating_{/literal}{$res.id}{literal}').rater(
	{
		curvalue:{/literal}{$res.rating}{literal},
		id:{/literal}{$res.id}{literal},
		can_vote: {/literal}{if $res.can_vote === true} true{else} false{/if}{literal}
	});
});
{/literal}
</script>


<div id="rating_{$res.id}"></div>