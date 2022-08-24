<TABLE cellSpacing=0 cellPadding=0 style="margin-bottom: 8px;">
        <TR>
          <TD class="block_caption_main"><a href="/forum/active.php" target="_blank">Активные дискуссии</a></TD>
        </TR>
{*
        <TR>
          <TD class=t13_grey2>&nbsp;&nbsp;Активные дискуссии&nbsp;&nbsp;</TD>
        </TR>
        <TR>
          <TD align=left bgColor=#666666><IMG height=1 alt="" src="/_img/x.gif" width=1 border=0></TD>
        </TR>
*}
</TABLE>
<TABLE width="100%" border="0" cellpadding="3" cellspacing="2">
      <tr class="forum_list">
      <th style="text-align:left;padding-left: 5px;">Тема</th>
      <th>Автор</th>
      <th>Ответов</th>
      <th>Просмотров</th>
      <th nowrap="nowrap">Последний ответ</th>
      </tr>
      {foreach from=$res.themes item=l name=msg}
      	<TR {if $smarty.foreach.msg.iteration % 2 == 0}bgcolor="#F0F4F4"{/if}>
        	<TD width="100%"><span class="a10">{foreach from=$l.path item=l2 name=sections}
		{if $l2.data.type=='section'}<a href="{$l2.url}" class="a10">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if}{if !$smarty.foreach.sections.last} &gt;{/if} 
		{/foreach}</span><br>
		<a href="{$l.url_last}"><b>{$l.name|strip_tags|truncate:100:"...":false}</b></a></TD>
        <td align="center" style="padding: 0px 20px 0px 20px;">{if $l.user}<a href="{$l.user_info.infourl}" target="_blank">{/if}{if $l.login!=''}{$l.login}{else}Гость{/if}{if $l.user}</a>{/if}</td>
        <td align="center">{$l.messages|number_format:0:" ":" "}</td>
        <td align="center">{$l.views|number_format:0:" ":" "}</td>
        <TD vAlign="top" class="otzyv">{$l.last_date|simply_date}<BR>
          Ответил: {if $l.last_user}<a href="{$l.last_user_info.infourl}" target="_blank" class="otziv">{/if}{$l.last_login}{if $l.last_user}</a>{/if}
          </TD>
      </TR>
      {/foreach}
</TABLE>
