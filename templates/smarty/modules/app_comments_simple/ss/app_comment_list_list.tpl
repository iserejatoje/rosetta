	{foreach from=$res.data.index[$Level][$Parent] name=fec item=comment}

	<div style="padding: 0px 0px 0px 0px;">
		{php}
			if (!isset($this->_tpl_vars['iteration']))
				$this->_tpl_vars['iteration'] = 0;			
		{/php}
		
		<a name="comment{$res.data.data[$comment].CommentID}"></a>
		{include 
			file="`$CONFIG.templates.ssections.details`" 
			best=false 
			comment=$res.data.data[$comment] 
		}
	</div>

	{/foreach}