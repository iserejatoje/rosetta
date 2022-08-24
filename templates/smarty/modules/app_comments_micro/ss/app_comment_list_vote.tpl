{if sizeof($res.data) || $res.a_comment_add}
<br/><br/>
<style>
{literal}
#system_message {
	background-color:#ff8796;
	color:#FFFFFF;
	font-size:12px;
	text-align:center;
	position:fixed;
	_position:absolute;
	right:0px;
	top:0px;
	_top: eval(document.body.scrollTop) + "px";
	width:200px;
	z-index:2000;
	padding:10px;
}
</style>

{/literal}

<div id="system_message" style="display:none;"></div>

<div class="js-comment">
	{if sizeof($res.best) > 0 && sizeof($res.data) > 1}
		{include file="`$CONFIG.templates.ssections.details`" best=true comment=$res.best}<br/><br/>
	{/if}

	<script>
		var commentForm = new commentFormClass({literal}{{/literal}
			url: '{$res.url}'
		{literal}}{/literal});
		
		{literal}
		
		$(document).ready (function() {
			$('.js-comments-field-text').jGrow({rows: 25}); 
		});
		{/literal}
	</script>
	
	<div class="js-comment-list">
		{include file="`$TEMPLATE.ssections.list_page`"}
	</div>
</div><br/>{/if}