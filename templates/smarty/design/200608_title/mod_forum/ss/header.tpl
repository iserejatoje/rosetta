{if $CURRENT_ENV.regid == '02'}
	{banner_v2 id="1424"}
{/if}
<table border="0" width="100%" cellpadding="2" cellspacing="0" class="fheader_table">
<tr>
	<td width="1"><img src="/_img/x.gif" height="40" width="1"></td>
	<td>
		{if strpos($CURRENT_ENV.section, 'social')!==0}
		<table width="100%"{if $smarty.get.tst > 12} border="1"{/if}>
			<tr><td class="fheader_spath">{if !empty($res.path) || $res.rflink}<a href="/{$ENV.section}/">{/if}форумы{if !empty($res.path) || $res.rflink}</a>{/if}
{foreach from=$res.path item=l name=f}
{if !$smarty.foreach.f.last}
 / {if $l.data.type=='section'}<a href="/{$ENV.section}/{$CONFIG.files.get.view.string}?id={$l.id}">{elseif $l.data.type=='theme'}<a href="theme.php?id={$l.id}">{/if}{$l.data.title}{if $l.data.type=='section' || $l.data.type=='theme'}</a>{/if}
{else}
{assign var="title" value=$l.data.title}
{/if}
{/foreach}

			</td>
			</tr>
			<tr><td class="fheader_stitle">
				{$title}
				{if $theme.moderate==1}<div style="color:red;font-size:10px;">Тема на предмодерации</div>{/if}
			</td></tr>
		</table>
		
		{else}
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			{if sizeof($TITLE->Path) > 1}
				<tr>
					<td style="padding-left:20px">
					{foreach from=$TITLE->Path item=url name=path}
						{if !$smarty.foreach.path.last}
						{if $url.link != ''}
							<a href="{$url.link}">{$url.name}</a>
						{else}
							{$url.name}
						{/if}
						{if $smarty.foreach.path.iteration+1 < sizeof($TITLE->Path)} / {/if}
						{/if}
					{/foreach}
					</td>
				</tr>
			{/if}
				<tr>
					<td style="padding-left:20px" class="title">{php}echo $this->_tpl_vars['TITLE']->Path[sizeof($this->_tpl_vars['TITLE']->Path)-1]['name'];{/php}</td>
				</tr>
		</table>
		{/if}
	</td>
	<td width="350" valign="top">
{if $GLOBAL.region==74}
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<form name="frm_search" enctype="application/x-www-form-urlencoded" target="_blank" method="get" action="http://www.74.ru/search/search.php" onsubmit="return _search_submit(this);">
		<input type="hidden" name="action" value="search" />
		<input type="hidden" name="a_c" value="01" />
		<tr valign="middle" align="left">
		<td>
			&nbsp;&nbsp;
			Поиск:
			<input type="text" name="text" value="" style="width:200px; font-size:10px;" />
			&nbsp;
			<input type="submit" value="Искать" />
		</td>
		</tr>
		</form>
		</table>
{/if}
	</tr>
</table><br>