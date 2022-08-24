{capture name=pageslink}
	{if $smarty.get.indexed == 15}
	{if !empty($res.pages.btn)}
		<ul class="pages">
			<li class="loading js-comments-pages-loading"><img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" /> Пожалуйста, подождите...</li>
		
			<li class="ppageslink js-comments-pages-link">
			<span class="title">Страницы:</span>
			{if $res.pages.first!="" }<a href="?p={$res.pages.first}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.first}');">первая</a>{/if
			}{if $res.pages.back!="" }<a href="?p={$res.pages.back}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.back}');">&lt;&lt;</a>{/if
			}{foreach from=$res.pages.btn item=l}{
				if !$l.active
					}<a href="?p={$l.link}" class="ppageslink" onClick="return commentForm.getPage('{$l.link}');">{$l.text}</a>{
				else
					}<span class="ppageslink_active">{$l.text}</span>{
				/if
			}{/foreach
			}{if $res.pages.next!="" }<a href="?p={$res.pages.next}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.next}');">&gt;&gt;</a>{/if
			}{if $res.pages.last!="" }<a href="?p={$res.pages.last}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.last}');">последняя</a>{/if
			}</li>
		</ul>
	{/if}
	{else}
	{if !empty($res.pages.btn)}
		<ul class="pages">
			<li class="loading js-comments-pages-loading"><img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" /> Пожалуйста, подождите...</li>
		
			<li class="ppageslink js-comments-pages-link">
			Страницы: 
			{if $res.pages.first!="" }<a style="float: none;padding:0px;display:inline" href="?p={$res.pages.first}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.first}');">первая</a> {/if
			}{if $res.pages.back!="" }<a style="float: none;padding:0px;display:inline" href="?p={$res.pages.back}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.back}');">&lt;&lt;</a> {/if
			}{foreach from=$res.pages.btn item=l}{
				if !$l.active
					} <a style="float: none;padding:0px;display:inline" href="?p={$l.link}" class="ppageslink" onClick="return commentForm.getPage('{$l.link}');">{$l.text}</a>{
				else
					} <span style="float: none;padding:0px;display:inline;background: none" class="ppageslink_active">{$l.text}</span>{
				/if
			}{/foreach
			}{if $res.pages.next!="" } <a style="float: none;padding:0px;display:inline" href="?p={$res.pages.next}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.next}');">&gt;&gt;</a>{/if
			}{if $res.pages.last!="" } <a style="float: none;padding:0px;display:inline" href="?p={$res.pages.last}" class="ppageslink" onClick="return commentForm.getPage('{$res.pages.last}');">последняя</a>{/if
			}</li>
		</ul>
	{/if}
	{/if}
{/capture}

<a name="js-comment"></a>
<div class="title">Комментарии (<span class="js-comments-count">{$res.CountAll}</span>)</div>

{$smarty.capture.pageslink}

<div class="js-comment-childs-holder-0{if $smarty.get.indexed == 15} holder{/if}">
	{if is_array($res.data) && sizeof($res.data) > 0}
		{if isset($res.data.index) && isset($res.data.data)}
			{include file="`$TEMPLATE.ssections.list_list`" Level="0" Parent="0"}
		{else}
			{include file="`$TEMPLATE.ssections.list_list`" comments=$res.data}
		{/if}
	{/if}
</div>
<br/>
{$smarty.capture.pageslink}