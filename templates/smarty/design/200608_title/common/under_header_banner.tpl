{if !in_array($CURRENT_ENV.sectioninfo.module, array('forum_magic','forum_index','themes','mail_v2','map_yandex','map_google','help')) && !in_array($CURRENT_ENV.section, array('claim', 'price', 'passport')) && strpos($CURRENT_ENV.section, 'social')!==0  && strpos($CURRENT_ENV.section, 'passport') === false}
<div style="padding: 2px 0px 2px 0px;"><noindex>
{if in_array($CURRENT_ENV.section, array('newsline_dom','articles','realty','hints','design','expert'))}

        {banner_v2 id="3816"}
	<table width="100%" cellpadding="0" cellspacing="2">
	<tr>
		<td>{banner_v2 id="3817"}</td>
		<td>{banner_v2 id="3818"}</td>
	</tr>
	</table>
	<table width="100%" cellpadding="0" cellspacing="2">
	<tr>
		<td colspan="3">{banner_v2 id="3819"}</td>
		<td colspan="3">{banner_v2 id="1669"}</td>
		<td colspan="3">{banner_v2 id="3820"}</td>
	</tr>
	<tr>
		<td>{banner_v2 id="3821"}</td>
		<td>{banner_v2 id="3822"}</td>
		<td>{banner_v2 id="3823"}</td>
		<td>{banner_v2 id="3824"}</td>
		<td>{banner_v2 id="3825"}</td>
		<td>{banner_v2 id="3826"}</td>
		<td>{banner_v2 id="3827"}</td>
		<td>{banner_v2 id="3828"}</td>
		<td>{banner_v2 id="3829"}</td>
	</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('newsline_auto','autostop','pdd','accident','car','opinion','poputchik','photoreport','advice','instructor','news_auto'))}

		<table width="100%" cellpadding="0" cellspacing="1" border="0">
		<tr align="center">
			<td style="width:8%">{banner_v2 id="3240"}</td>
			<td style="width:8%">{banner_v2 id="3481"}</td>
			<td style="width:8%">{banner_v2 id="3482"}</td>
			<td style="width:8%">{banner_v2 id="2476"}</td>
			<td style="width:8%">{banner_v2 id="3096"}</td>
			<td style="width:8%">{banner_v2 id="3239"}</td>
			<td style="width:8%">{banner_v2 id="2477"}</td>
			<td style="width:8%">{banner_v2 id="2478"}</td>
			<td style="width:8%">{banner_v2 id="2547"}</td>
			<td style="width:8%">{banner_v2 id="2548"}</td>
			<td style="width:8%">{banner_v2 id="2719"}</td>
			<td style="width:8%">{banner_v2 id="2720"}</td>
		</tr>		
		<tr align="center">
			<td style="width:8%">{banner_v2 id="3905"}</td>
			<td style="width:8%">{banner_v2 id="3906"}</td>
			<td style="width:8%">{banner_v2 id="3907"}</td>
			<td style="width:8%">{banner_v2 id="4029"}</td>
			<td style="width:8%">{banner_v2 id="4030"}</td>
			<td style="width:8%">{banner_v2 id="4031"}</td>
			<td style="width:8%">{banner_v2 id="4032"}</td>
			<td style="width:8%">{banner_v2 id="4033"}</td>
			<td style="width:8%">{banner_v2 id="4034"}</td>
			<td style="width:8%">{banner_v2 id="4035"}</td>
			<td style="width:8%">{banner_v2 id="4036"}</td>
			<td style="width:8%">{banner_v2 id="4037"}</td>
		</tr></table>
		<table width="100%" cellpadding="0" cellspacing="1" border="0">
		<tr align="center">
			<td>{banner_v2 id="1942"}</td>
			<td>{banner_v2 id="3745"}</td>
		</tr>
		<tr align="center">
			<td colspan="2">{banner_v2 id="3878"}</td>
		</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="1" border="0">
		<tr align="center">
			<td>{banner_v2 id="3879"}</td>
			<td>{banner_v2 id="3881"}</td>
			<td>{banner_v2 id="3880"}</td>
		</tr>
		</table>

{elseif in_array($CURRENT_ENV.section, array('exchange','newsline_fin','tech','skills','credit','news_fin','predict','poll_fin'))}
	{banner_v2 id="3943"}
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=3944}</td>
		<td>{banner_v2 id=3945}</td>
	</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=3946}</td>
		<td>{banner_v2 id=3948}</td>
		<td>{banner_v2 id=3947}</td>
	</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=3949}</td>
		<td>{banner_v2 id=3950}</td>
		<td>{banner_v2 id=3951}</td>
		<td>{banner_v2 id=3952}</td>
		<td>{banner_v2 id=3953}</td>
		<td>{banner_v2 id=3954}</td>
		<td>{banner_v2 id=3955}</td>
		<td>{banner_v2 id=3956}</td>
		<td>{banner_v2 id=3957}</td>
	</tr>
	</table>

{elseif in_array($CURRENT_ENV.section, array('afisha','weekfilm','wedding','starspeak','travel','inspect','love','horoscope','dream'))}
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=124}</td>
		<td>{banner_v2 id=3914}</td>
	</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=1637}</td>
		<td>{banner_v2 id=2715}</td>
		<td>{banner_v2 id=2648}</td>
	</tr>
	</table>
	{banner_v2 id="1509"}
	<table border="0" cellspacing="0" cellpadding="1" width="100%">
	<tr align="center">
		<td>{banner_v2 id=3915}</td>
		<td>{banner_v2 id=3916}</td>
		<td>{banner_v2 id=3917}</td>
		<td>{banner_v2 id=3918}</td>
		<td>{banner_v2 id=3919}</td>
		<td>{banner_v2 id=3920}</td>
		<td>{banner_v2 id=3921}</td>
		<td>{banner_v2 id=3922}</td>
		<td>{banner_v2 id=3923}</td>
	</tr>
	</table>


{elseif in_array($CURRENT_ENV.section, array('job'))}
	{banner_v2 id="3386"}
	<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr align="center">
		<td>{banner_v2 id="3764"}</td>
		<td>{banner_v2 id="3765"}</td>
	</tr></table>
	<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr align="center">
		<td>{banner_v2 id="3766"}</td>
		<td>{banner_v2 id="3768"}</td>
		<td>{banner_v2 id="3767"}</td>
	</tr></table>

{elseif in_array($CURRENT_ENV.section, array('weather'))}
	{banner_v2 id="1823"}
	<table border="0" cellspacing="0" cellpadding="2" width="100%"><tr align="center">
		<td>{banner_v2 id="3779"}</td>
		<td>{banner_v2 id="3780"}</td>
	</tr></table>			
	<table border="0" cellspacing="0" cellpadding="2" width="100%"><tr align="center">
	<td>{banner_v2 id="3781"}</td>
		<td>{banner_v2 id="3782"}</td>
		<td>{banner_v2 id="3783"}</td>
	</tr></table>			
{elseif in_array($CURRENT_ENV.sectioninfo.module, array('board','video','firms','shedule','poll_v2','search_sphinx_v2','contest','consult_v2','conference','site_map','info_page','gallery','lostfound')) || in_array($CURRENT_ENV.section, array('radio','competition'))}
	<table border="0" cellspacing="0" cellpadding="2" width="100%"><tr align="center">
		<td>{banner_v2 id="3507"}</td>
		<td>{banner_v2 id="3508"}</td>
	</tr></table>
	<table border="0" cellspacing="0" cellpadding="2" width="100%"><tr align="center">
		<td>{banner_v2 id="3853"}</td>
		<td>{banner_v2 id="3855"}</td>
		<td>{banner_v2 id="3854"}</td>
	</tr></table>	
	{banner_v2 id="3856"}		
{else}

	{banner_v2 id="1206"}
	<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr align="center">
		<td>{banner_v2 id="645"}</td>
		<td>{banner_v2 id="1241"}</td>
		<td>{banner_v2 id="646"}</td>
	</tr></table>
	<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr align="center">
		<td>{banner_v2 id="2346"}</td>
		<td>{banner_v2 id="3793"}</td>				
	</tr></table>

{/if}
</noindex></div>
{/if}
{if $CURRENT_ENV.regid == 71}
	{if $CURRENT_ENV.section == 'car'}
		{banner_v2 id="3977"}
	{/if}
{/if}