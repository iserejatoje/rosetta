{if !isset($best) || $best!==true}
<ul class="js-comment-holder-{$comment.CommentID}">

	<li class="comment {if $comment.Level > 0}sub{/if}">
		<ul class="author">
			<li class="name">{if !$comment.Level && $iteration}{$iteration+$res.start}. {/if}
			{if $comment.UserID > 0}
				{$comment.User.Name|truncate:30}
			{elseif trim($comment.Name) != ''}
				{$comment.Name|truncate:30}{else}Гость
			{/if}</li>
			<li class="date">{$comment.Created|simply_date}</li>
			
		</ul>
		<div style="clear:both;"></div>
		<ul class="content">
			<li>{$comment.Text|strip_tags|with_href|nl2br}</li>
		</ul>		
	</li>	

	{assign var=_level value=$comment.Level+1}
	{assign var=_parent value=$comment.CommentID}
	
	{if isset($res.data.index[$_level][$_parent])}
		<li class="js-comment-childs-link-{$comment.CommentID}">Ответы:</li>
		<li>
		
			{include file="`$TEMPLATE.ssections.list_list`" Level=$_level Parent=$_parent}
			<br/>
		</li>
	{else}
		<li style="display: none" class="js-comment-childs-holder-{$comment.CommentID}"> </li>
	{/if}
</ul>{if !isset($res.data.index[$_level][$_parent]) && $_level == 1}<br/>{/if}


{else}

<ul class="best">
	<li class="title">Лучший комментарий</li>

	<li class="comment">
		<ul class="author">			
			<li class="name">{if $comment.UserID > 0}{$comment.User.Name|truncate:30}{elseif trim($comment.Name) != ''}{$comment.Name|truncate:30}{else}Гость{/if}</li>
			<li class="date">{$comment.Created|simply_date}</li>
		</ul>
		{if $comment.Rating == 1 || $comment.Rating == 2}
		<ul class="rating">
			{if $comment.CanVoted}
			<li class="buttons">
				<div class="js-comments-best-vote-{$comment.CommentID}"><a
					href="javascript:void(0);" onClick="return commentForm.Vote({$comment.CommentID}, 1)" title="поддерживаю"><img src="/_img/modules/svoi/buttons/plus1.gif" width="12" height="12" alt="поддерживаю" /></a>
				<a
					href="javascript:void(0);" onClick="return commentForm.Vote({$comment.CommentID}, -1)"  title="не поддерживаю"><img src="/_img/modules/svoi/buttons/minus1.gif" width="12" height="12" alt="не поддерживаю" /></a>
				</div>
			</li>
			{/if}
			<li class="votes"><span class="{if $comment.VoteCount < 0}ns {elseif $comment.VoteCount > 0}s {/if}js-comments-vote-best-count-{$comment.CommentID}">{if $comment.VoteCount > 0}+{/if}{$comment.VoteCount}</span></li>
		</ul>
		{/if}
		<br/><br/>
		<ul class="content">
			<li>{$comment.Text|strip_tags|with_href|nl2br}</li>
		</ul>
	</li>
</ul>

{/if}