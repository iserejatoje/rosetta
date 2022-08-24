	{if $Level == 1}
		<div style="padding: 0px 0px 10px 30px" class="js-comments-announce-{$Parent}">
		{foreach from=$res.data.index[$Level][$Parent] item=comment}
			{assign var=comment value=$res.data.data[$comment]}
			<a name="comment{$comment.CommentID}"></a>
			<span class="author">
				<span class="name">{if $comment.UserID > 0}<a href="{$comment.User.InfoUrl}" target="_blank" title="{$comment.User.Name|escape}">{$comment.User.Name|truncate:30},</a>{elseif trim($comment.Name) != ''}{$comment.Name|truncate:30}{else}Гость,{/if}</span>
				<span class="date">{$comment.Created|simply_date}</span>
				<span class="announce">
					<a href="javascript:void(0);" onclick="commentForm.expandAll({$Parent});window.location.href='#comment{$comment.CommentID}'">{$comment.Text|truncate:35}</a>
				</span>
			</span>
		{/foreach}
		</div>
	{/if}

	{foreach from=$res.data.index[$Level][$Parent] name=fec item=comment}

	<div style="padding: 0px 0px 0px {if $Level && $Level <= 10}3{/if}0px;{if $Level == 1}display:none;{/if}"{if $Parent} class="js-comments-tree-{$Parent}"{/if}>
		{php}
			if (!isset($this->_tpl_vars['iteration']))
				$this->_tpl_vars['iteration'] = 0;
			
			//$this->_tpl_vars['iteration']++;
		{/php}
		
		<a name="comment{$res.data.data[$comment].CommentID}"></a>
		{include 
			file="`$CONFIG.templates.ssections.details`" 
			best=false 
			comment=$res.data.data[$comment] 
		}
	</div>

	{/foreach}