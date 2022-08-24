{if !isset($best) || $best!==true} 
<a 1 name="comment{$comment.CommentID}"></a>
<ul class="js-comment-holder-{$comment.CommentID}">

	<li class="comment {if $comment.Level > 0}sub{/if}">
		<ul class="author">
			{*<li class="avatar">
				<div style="background-image: url('{if $comment.User.Avatar.avatarurl != ''}{$comment.User.Avatar.avatarurl}{else}/_img/modules/passport/user_unknown_small.gif{/if}');">
					<img src="/_img/x.gif" border="0" width="50" height="50" />
				</div>
			</li> *}
			<li class="name">{if !$comment.Level}{$iteration+$res.start}. {/if}{if $comment.UserID > 0}<a href="{$comment.User.InfoUrl}" target="_blank" title="{$comment.User.Name|escape}">{$comment.User.Name|truncate:30}</a>{elseif trim($comment.Name) != ''}{$comment.Name|truncate:30}{else}Гость{/if}</li>
			<li class="date">{$comment.Created|simply_date}</li>
		</ul>
		{if $comment.CanDelete === true}
		<ul class="action">
			<li class="buttons">
				<a href="javascript:void(0);" onClick="commentForm.Delete({$comment.CommentID})" title="Удалить комментарий">удалить</a>
			</li>
		</ul>
		{/if}
		{if $comment.Rating == 1 || $comment.Rating == 2}
		<ul class="rating">
			<li class="buttons">	
				<div class="js-comments-vote-{$comment.CommentID}"><a
					href="javascript:void(0);" onClick="return commentForm.Vote({$comment.CommentID}, 1)" title="поддерживаю"><img src="/_img/modules/svoi/buttons/plus1.gif" width="12" height="12" alt="поддерживаю" /></a>
				<a
					href="javascript:void(0);" onClick="return commentForm.Vote({$comment.CommentID}, -1)"  title="не поддерживаю"><img src="/_img/modules/svoi/buttons/minus1.gif" width="12" height="12" alt="не поддерживаю" /><br /></a>
				</div>
			</li>
			<li class="votes"><span class="{if $comment.VoteCount < 0}ns {elseif $comment.VoteCount > 0}s {/if}js-comments-vote-best-count-{$comment.CommentID}">{if $comment.VoteCount > 0}+{/if}{$comment.VoteCount}</span></li>
		</ul>
		{/if}
		<br/><br/>
		<ul class="content">
			{*<li>{$comment.Text|strip_tags|with_href|wordwrap:40:' ':true|nl2br}</li>*}
			<li>{$comment.Text|strip_tags|with_href|nl2br}</li>
		</ul>
	</li>

	<li>
		<ul class="replies">
			<li class="loading js-comments-loading-{$comment.CommentID}"><img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" /></li>
			
			<li class="reply">
				<a href="javascript:;" onclick="commentForm.moveForm({$comment.CommentID});">Ответить</a>    
				{assign var=_level value=$comment.Level+1}
				{assign var=_parent value=$comment.CommentID}

				{if isset($res.data.index[$_level][$_parent]) || !$comment.ChildsCount}
					Ответов: <span class="js-comment-childs-count-{$comment.CommentID}">{$comment.ChildsCount}</span>
				{else}
					<a href="javascript:;" onclick="commentForm.showChilds({$comment.CommentID}, this)">Ответов: <span class="js-comment-childs-count-{$comment.CommentID}">{$comment.ChildsCount}</span></a>
				{/if}
			</li>
		</ul>
	</li>

	<li style="display: none" class="js-comments-form-holder-{$comment.CommentID}"></li>	
	
	<li class="js-comment-childs-holder-{$comment.CommentID}">
		
		{if isset($res.data.index[$_level][$_parent])}
			{include file="modules/app_comments3/ss/app_comment_list_list_index.tpl" Level=$_level Parent=$_parent}
		{/if}
	</li>
</ul>


{else}

<ul class="best">
	<li class="title">Лучший комментарий</li>

	<li class="comment">
		<ul class="author">
			{* <li class="avatar">
				<div style="background-image: url('{if $comment.User.Avatar.avatarurl != ''}{$comment.User.Avatar.avatarurl}{else}/_img/modules/passport/user_unknown_small.gif{/if}');">
					<img src="/_img/x.gif" border="0" width="50" height="50" />
				</div>
			</li> *}
			<li class="name">{if $comment.UserID > 0}<a href="{$comment.User.InfoUrl}" target="_blank">{$comment.User.Name|truncate:30}</a>{elseif trim($comment.Name) != ''}{$comment.Name|truncate:30}{else}Гость{/if}</li>
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