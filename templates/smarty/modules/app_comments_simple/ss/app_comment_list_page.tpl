{capture name=pageslink}
	{if !empty($res.pages.btn)}
		<ul class="pages" style="height: 18px">
			<li class="loading js-comments-pages-loading"><img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" /> Пожалуйста, подождите...</li>
		
			<li class="ppageslink js-comments-pages-link">
			<span class="title">Страницы: </span>
			{if $res.pages.first!="" }<a href="?p={$res.pages.first}" class="ppageslink">первая</a>{/if
			}{if $res.pages.back!="" }<a href="?p={$res.pages.back}" class="ppageslink">&lt;&lt;</a>{/if
			}{foreach from=$res.pages.btn item=l}{
				if !$l.active
					}<a href="?p={$l.link}" class="ppageslink">{$l.text}</a>{
				else
					}<span class="ppageslink_active">{$l.text}</span>{
				/if
			}{/foreach
			}{if $res.pages.next!="" }<a href="?p={$res.pages.next}" class="ppageslink">&gt;&gt;</a>{/if
			}{if $res.pages.last!="" }<a href="?p={$res.pages.last}" class="ppageslink">последняя</a>{/if
			}</li>
		</ul><div style="clear: both;"> </div>
	{/if}
{/capture}

<a name="js-comment"></a>
<div class="title add-comment">Комментарии (<span class="js-comments-count">{$res.CountAll}</span>)</div>

{$smarty.capture.pageslink}

<div class="js-comment-childs-holder-0">
	{if is_array($res.data) && sizeof($res.data) > 0}
		{include file="`$TEMPLATE.ssections.list_list`" Level="0" Parent="0"}
	{/if}
</div>
{$smarty.capture.pageslink}<div style="clear: both;"> </div>