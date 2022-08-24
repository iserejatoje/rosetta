{foreach from=$res.data.index[$Level][$Parent] item=comment}

<div {if $Level && $Level <= 10}style="padding-left: 20px"{/if}>
	{php}
		$this->_tpl_vars['iteration'] = $this->_tpl_vars['key']+1;
	{/php}
	{include 
		file="modules/app_comments3/ss/app_comment_details_index.tpl" 
		best=false 
		comment=$res.data.data[$comment] 
	}
</div>

{/foreach}