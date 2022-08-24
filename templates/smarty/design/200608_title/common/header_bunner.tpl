{if !in_array($CURRENT_ENV.sectioninfo.module, array('forum_magic','forum_index','themes','mail_v2','map_yandex','map_google','help')) && !in_array($CURRENT_ENV.section, array('claim', 'price', 'passport')) && strpos($CURRENT_ENV.section, 'social')!==0  && strpos($CURRENT_ENV.section, 'passport') === false}

{if in_array($CURRENT_ENV.section, array('newsline_dom','articles','realty','hints','design','expert'))}
	{banner_v2 id="4028"}

{elseif in_array($CURRENT_ENV.section, array('newsline_auto','autostop','pdd','accident','car','opinion','poputchik'))}
	{banner_v2 id="2484"}

{elseif in_array($CURRENT_ENV.section, array('exchange','newsline_fin','tech','skills','credit','news_fin','predict','poll_fin'))}
	{banner_v2 id="551"}

{elseif in_array($CURRENT_ENV.section, array('afisha','weekfilm','wedding','starspeak','travel','inspect','love','horoscope','dream'))}
	{banner_v2 id="1508"}

{elseif in_array($CURRENT_ENV.section, array('job'))}
	{banner_v2 id="1385"}

{elseif in_array($CURRENT_ENV.section, array('weather'))}
	{banner_v2 id="2009"}
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td>{banner_v2 id="3777"}</td>
		<td>{banner_v2 id="3778"}</td>
	</tr>
	</table>
{elseif in_array($CURRENT_ENV.sectioninfo.module, array('board','video','firms','shedule','poll_v2','search_sphinx_v2','contest','consult_v2','conference','site_map','info_page','gallery','lostfound')) || in_array($CURRENT_ENV.section, array('radio','competition'))}
	{banner_v2 id="3852"}
{else}
	{banner_v2 id="1520"}
{/if}

{/if}