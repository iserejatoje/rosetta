{if $CONFIG.indexed !== true}
	{foreach from=$comments item=comment key=key}

	<div {if $comment.data.Level && $comment.data.Level <= 10}style="padding-left: 20px"{/if}>
		{php}
			$this->_tpl_vars['iteration'] = $this->_tpl_vars['key']+1;
		{/php}
		{include file="`$CONFIG.templates.ssections.details`" best=false comment=$comment.data nodes=$comment.nodes}

	</div>

	{/foreach}
{elseif $smarty.get.indexed == 15}

	{if $Level == 1}
		<div style="padding: 0px 0px 10px 30px" class="js-comments-announce-{$Parent}">
		{foreach from=$res.data.index[$Level][$Parent] item=comment}
			{assign var=comment value=$res.data.data[$comment]}
			<span class="author">
				<span class="name">{if !$comment.Level && $iteration}{$iteration+$res.start}. {/if}{if $comment.UserID > 0}<a href="{$comment.User.InfoUrl}" target="_blank" title="{$comment.User.Name|escape}">{$comment.User.Name|truncate:30}</a>{elseif trim($comment.Name) != ''}{$comment.Name|truncate:30}{else}Гость{/if},</span>
				<span class="date">{$comment.Created|simply_date}</span>
				<span class="announce">
					<a name="comment{$comment.CommentID}"></a>
					<a href="javascript:void(0);" onclick="commentForm.expandAll({$Parent});window.location.href='#comment{$comment.CommentID}'">{$comment.Text|truncate:35}</a>
				</span>
			</span>
		{/foreach}
		</div>
	{/if}

	{foreach from=$res.data.index[$Level][$Parent] item=comment}

	<div style="padding: 10px 0px 0px {if $Level && $Level <= 10}3{/if}0px;{if $Level == 1}display:none;{/if}"{if $Parent} class="js-comments-tree-{$Parent}"{/if}>
		{php}
			if (!isset($this->_tpl_vars['iteration']))
				$this->_tpl_vars['iteration'] = 0;
			
			//$this->_tpl_vars['iteration']++;
		{/php}
		
		{include 
			file="`$CONFIG.templates.ssections.details`" 
			best=false 
			comment=$res.data.data[$comment] 
		}
	</div>

	{/foreach}
{else}

	{foreach from=$res.data.index[$Level][$Parent] item=comment}

	<div {if $Level && $Level <= 10}style="padding-left: 20px"{/if}>
		{php}
			if (!isset($this->_tpl_vars['iteration']))
				$this->_tpl_vars['iteration'] = 0;
			
			//$this->_tpl_vars['iteration']++;
		{/php}
		
		{include 
			file="`$CONFIG.templates.ssections.details`" 
			best=false 
			comment=$res.data.data[$comment] 
		}
	</div>

	{/foreach}

{/if}