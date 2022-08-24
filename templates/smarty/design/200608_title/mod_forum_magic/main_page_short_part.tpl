<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>{*<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a16b"><img src="/img/icon_firms.gif" width="16" height="16" border="0"></a> *}<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a12b">{$ENV.site.title[$ENV.section]}:</a></td></tr>
</table>
<table style="padding-left: 3px;" width="100%" cellspacing="0" cellpadding="2" border="0">
      {foreach from=$res.themes item=l name=msg}
      	<TR>
        	<TD valign="top" style="padding-left: 5px;">
		{foreach from=$l.path item=l2 name=sections}
		{if $smarty.foreach.sections.last}
			{if $l2.data.type=='section'}<a class="a11" href="/service/go/?url={"`$l2.url`"|escape:"url"}" target="_blank">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if}
		{/if}
		{/foreach}
	</TD>
      </TR>
      {/foreach}
	<tr><td style="padding-left: 5px;">
		<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a11">Все рубрики</a>
	</td></tr>
</TABLE>