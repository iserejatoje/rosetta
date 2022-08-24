{*
{if strpos($smarty.server.HTTP_USER_AGENT, 'Opera') === false}
{assign var="ch_link" value=""}
{if $smarty.server.HTTP_HOST=="74.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/passport/') === 0}
	{assign var="ch_link" value="/passport/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/weather/') === 0}
	{assign var="ch_link" value="/weather/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="ufa1.ru"}
	{if preg_match("@^/svoi/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/"}
	{elseif preg_match("@^/svoi/communities/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/communities/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}

	{elseif strpos($smarty.server.REQUEST_URI, '/forum/active.php') === 0}
	{assign var="ch_link" value="/forum/active.php"}
	{elseif strpos($smarty.server.REQUEST_URI, '/svoi/community/group/') === 0}
	{assign var="ch_link" value="/svoi/community/group/"}
	{elseif preg_match("@^/svoi/community/\d+/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/community/CommunityID/"}
	{elseif preg_match("@^/community/\d+/forum/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/community/CommunityID/forum/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="102banka.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/forum/active.php') === 0}
	{assign var="ch_link" value="/forum/active.php"}
	{elseif strpos($smarty.server.REQUEST_URI, '/svoi/community/group/') === 0}
	{assign var="ch_link" value="/svoi/community/group/"}
	{elseif preg_match("@^/svoi/community/\d+/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/community/CommunityID/"}
	{elseif preg_match("@^/community/\d+/forum/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/community/CommunityID/forum/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="102metra.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/forum/active.php') === 0}
	{assign var="ch_link" value="/forum/active.php"}
	{elseif strpos($smarty.server.REQUEST_URI, '/svoi/community/group/') === 0}
	{assign var="ch_link" value="/svoi/community/group/"}
	{elseif preg_match("@^/svoi/community/\d+/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/community/CommunityID/"}
	{elseif preg_match("@^/community/\d+/forum/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/community/CommunityID/forum/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="102vechera.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/forum/active.php') === 0}
	{assign var="ch_link" value="/forum/active.php"}
	{elseif strpos($smarty.server.REQUEST_URI, '/svoi/community/group/') === 0}
	{assign var="ch_link" value="/svoi/community/group/"}
	{elseif preg_match("@^/svoi/community/\d+/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/community/CommunityID/"}
	{elseif preg_match("@^/community/\d+/forum/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/community/CommunityID/forum/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="102km.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/forum/active.php') === 0}
	{assign var="ch_link" value="/forum/active.php"}
	{elseif strpos($smarty.server.REQUEST_URI, '/svoi/community/group/') === 0}
	{assign var="ch_link" value="/svoi/community/group/"}
	{elseif preg_match("@^/svoi/community/\d+/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/svoi/community/CommunityID/"}
	{elseif preg_match("@^/community/\d+/forum/?$@", $smarty.server.REQUEST_URI)}
	{assign var="ch_link" value="/community/CommunityID/forum/"}
	{/if}
{/if}
{if $ch_link!=""}
<script type="text/javascript" src="http://clickheat.cube-club.ru/clickheat/js/clickheat.js"></script><script type="text/javascript"><!--
clickHeatSite = '{$smarty.server.HTTP_HOST}';clickHeatGroup = '{$ch_link}';clickHeatServer = 'http://clickheat.cube-club.ru/clickheat/click.php';initClickHeat(); //-->
</script>
{/if}
{/if}
*}

{*
old stuff
{elseif $smarty.server.HTTP_HOST=="domchel.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/newsline/') === 0}
	{assign var="ch_link" value="/newsline/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/consult/') === 0}
	{assign var="ch_link" value="/consult/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/firms/') === 0}
	{assign var="ch_link" value="/firms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/realty/') === 0}
		{if preg_match("@^/realty/.*/detail/\d+\.php@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/detail/"}
		{elseif preg_match("@^/realty/.*/my\.php@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/my.php"}
		{elseif preg_match("@^/realty/.*/my/@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/my/"}
		{elseif preg_match("@^/realty/$@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/"}
		{elseif preg_match("@^/realty/.*\.php\?.*expand=1@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/list/expand/"}
		{elseif preg_match("@^/realty/msg\.@", $smarty.server.REQUEST_URI)}
		{elseif preg_match("@^/realty/@", $smarty.server.REQUEST_URI)}
		{assign var="ch_link" value="/realty/list/"}
		{/if}
	{/if}
{elseif $smarty.server.HTTP_HOST=="chelfin.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/newsline/') === 0}
	{assign var="ch_link" value="/newsline/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/exchange/') === 0}
	{assign var="ch_link" value="/exchange/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/bankpaper/') === 0}
	{assign var="ch_link" value="/bankpaper/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/firms/') === 0}
	{assign var="ch_link" value="/firms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="vipautochel.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/catalog/') === 0}
	{assign var="ch_link" value="/catalog/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="chel.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/lider/') === 0}
	{assign var="ch_link" value="/lider/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/partner/') === 0}
	{assign var="ch_link" value="/partner/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/job/') === 0}
	{assign var="ch_link" value="/job/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="mychel.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/firms/') === 0}
	{assign var="ch_link" value="/firms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/afisha/') === 0}
	{assign var="ch_link" value="/afisha/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/weekfilm/') === 0}
	{assign var="ch_link" value="/weekfilm/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/report/') === 0}
	{assign var="ch_link" value="/report/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="cheldoctor.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/newsline/') === 0}
	{assign var="ch_link" value="/newsline/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/firms/') === 0}
	{assign var="ch_link" value="/firms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/iview/') === 0}
	{assign var="ch_link" value="/iview/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/childfirms/') === 0}
	{assign var="ch_link" value="/childfirms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/advertise/') === 0}
	{assign var="ch_link" value="/advertise/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="2074.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/newsline/') === 0}
	{assign var="ch_link" value="/newsline/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/news/') === 0}
	{assign var="ch_link" value="/news/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sale/') === 0}
	{assign var="ch_link" value="/sale/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/catalog/') === 0}
	{assign var="ch_link" value="/catalog/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/hits/') === 0}
	{assign var="ch_link" value="/hits/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="cheldiplom.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/newsline/') === 0}
	{assign var="ch_link" value="/newsline/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/firms/') === 0}
	{assign var="ch_link" value="/firms/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/advertise/') === 0}
	{assign var="ch_link" value="/advertise/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/tendencies/') === 0}
	{assign var="ch_link" value="/tendencies/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/consult/') === 0}
	{assign var="ch_link" value="/consult/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/sitehome/') === 0}
	{assign var="ch_link" value="/"}
	{/if}
{elseif $smarty.server.HTTP_HOST=="72.ru"}
	{if strpos($smarty.server.REQUEST_URI, '/svoi/') === 0}
	{assign var="ch_link" value="/ss/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/passport/') === 0}
	{assign var="ch_link" value="/ss/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/forum/') === 0}
	{assign var="ch_link" value="/ss/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/community/') === 0}
	{assign var="ch_link" value="/ss/"}
	{elseif strpos($smarty.server.REQUEST_URI, '/user/') === 0}
	{assign var="ch_link" value="/ss/"}
	{/if}
*}