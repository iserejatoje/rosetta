<TABLE cellSpacing=0 cellPadding=0 style="margin-bottom: 8px;">
        <TR>
          <TD class="block_caption_main"><a href="/service/go/?url={"http://`$ENV.site.domain`/forum/"|escape:"url"}" target="_blank">Активные дискуссии</a></TD>
        </TR>
{*        <TR>
          <TD class=t13_grey2>&nbsp;&nbsp;Активные дискуссии&nbsp;&nbsp;</TD>
        </TR>
        <TR>
          <TD align=left bgColor=#666666><IMG height=1 alt="" src="/_img/x.gif" width=1 border=0></TD>
        </TR>*}
</TABLE>
<TABLE width="100%" border="0" cellpadding="3" cellspacing="2">
      {foreach from=$res.themes item=l name=msg}
      	<TR {if $smarty.foreach.msg.iteration % 2 == 0}bgcolor="#F0F4F4"{/if}>
        	<TD valign="top"><span class="a10">{foreach from=$l.path item=l2 name=sections}
		{if $l2.data.type=='section'}<a href="/service/go/?url={"`$l2.url`"|escape:"url"}" target="_blank" class="a10">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if}{if !$smarty.foreach.sections.last} &gt;{/if}
		{/foreach}</span><br/>
		<a href="/service/go/?url={"`$l.url_last`"|escape:"url"}" target="_blank"><b>{$l.name|strip_tags|truncate:60:"...":false}</b></a></TD>
        <TD vAlign="top" class="otzyv" width="30%">{$l.last_date|simply_date}<br/>
          Ответил: {if $l.last_user}<a href="/service/go/?url={"`$l.last_user_info.infourl`"|escape:"url"}" target="_blank" class="otziv">{/if}{$l.last_login}{if $l.last_user|truncate:20:"...":false}</a>{/if}
          </TD>
      </TR>
      {/foreach}
</TABLE>