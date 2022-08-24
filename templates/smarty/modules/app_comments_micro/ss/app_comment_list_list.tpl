
{if $CONFIG.indexed !== true}
	{foreach from=$comments item=comment key=key}

	<div {if $comment.data.Level && $comment.data.Level <= 10}style="padding-left: 20px"{/if}>
		{php}
			$this->_tpl_vars['iteration'] = $this->_tpl_vars['key']+1;
		{/php}
		{include file="`$CONFIG.templates.ssections.details`" best=false comment=$comment.data nodes=$comment.nodes}

	</div>

	{/foreach}
{else}
dsfh
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