<table class="social-form">
<tr>
	<td>
		<noindex><a rel="nofollow" href="javascript:void(0);" onclick="$('.code_for_blogs').show()" title="LiveJournal"><img border="0" src="/resources/img/themes/misc/logos/social/livejournal.gif" alt="LiveJournal" /></a></noindex>
	</td>
	<td>
		<noindex><a rel="nofollow" href="javascript:void(0);" onclick="$('.code_for_blogs').show()" title="Я.ру"><img border="0" src="/resources/img/themes/misc/logos/social/ya.gif" alt="Я.ру" /></a></noindex>
	</td>
	<td>
		<noindex><a rel="nofollow" href="javascript:void(0);" onclick="$('.code_for_blogs').show()" title="Liveinternet"><img border="0" src="/resources/img/themes/misc/logos/social/liveinternet2.gif" alt="Liveinternet" /></a></noindex>
	</td>
	<td>
	<script type="text/javascript">
	<!--{literal}

    function fbs_click() {u='{/literal}{$url}{literal}';window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
    function vks_click() {window.open('http://vkontakte.ru/share.php?url='+encodeURIComponent('{/literal}{$url}{literal}')+'&image={/literal}{$thumb.file}{literal}','sharer','toolbar=0,status=0,width=626,height=436');return false;}
	function odno_click() {window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1000&st._surl='+encodeURIComponent('{/literal}{$url}{literal}'),'odkl_share','toolbar=0,status=0,width=626,height=436');return false;}

	-->{/literal}
	</script>
		<noindex><a rel="nofollow" target="_blank" onclick="return vks_click()" href="http://vkontakte.ru/share.php?url={$url}&image={$thumb.file}" title="Вконтакте"><img border="0" title="Вконтакте" src="/resources/img/themes/misc/logos/social/vkontakte.gif"></a></noindex>
	</td>
	<td>
		<noindex><a rel="nofollow" target="_blank" href="http://twitter.com/home/?status={$utitle}%20{$url}" title="Twitter"><img border="0" src="/resources/img/themes/misc/logos/social/twitter.gif" alt="Twitter"/></a></noindex>	
	</td>
	<td>
		<noindex><a rel="nofollow" target="_blank" onclick="return fbs_click()" href="http://www.facebook.com/sharer.php?u={$url}" title="Facebook"><img border="0" src="/resources/img/themes/misc/logos/social/facebook.gif" alt="Facebook"/></a></noindex>
	</td>
	<td>
		<noindex><a rel="nofollow" target="_blank" href="http://connect.mail.ru/share?share_url={$url}" title="Мой мир на mail.ru"><img border="0" src="/resources/img/themes/misc/logos/social/mailru.gif" alt="Мой мир на mail.ru"/></a></noindex>
	</td>
	
	<td>
		<noindex><a rel="nofollow" target="_blank" class="odkl-klass-stat" onclick="return odno_click()" href="{$url}" title="Odnoklassniki"><img border="0" src="/resources/img/themes/misc/logos/social/odnoklassniki.gif" alt="Odnoklassniki" /></a></noindex>		
	</td>
	
</tr>
</table>

<div class="code_for_blogs" style="display: none;">
<span style="font-family:Tahoma,Verdana; font-size: 12; color:#444444">Код для вставки в блог:</span><br/>
<textarea style="width: 283px; height: 35px; border: solid 1px #000000;font-family:Tahoma,Verdana; font-size: 12; color:#444444">&lt;div style="padding:12px 15px; background:#ffffff !important"&gt;{if $thumb != null}&lt;a href="{$url}" target="_blank"&gt;&lt;img border="0" vspace="10" hspace="10" src="{$thumb.file}" align="left" width="{$thumb.w}" height="{$thumb.h}" style="padding: 7px;" title="{$title|escape}"/&gt;&lt;/a&gt;{/if}&lt;div style="font-family: 14px; color: #005A52; font-weight: bold; margin: 0px; padding: 0px;"&gt;{$title}&lt;/div&gt;&lt;br/&gt;&lt;span style="color: #999999"&gt;{$date|date_format:"%e"} {$date|month_to_string:2} {$date|date_format:"%Y"}&lt;/span&gt;{$descr} &lt;a style="color:#005A52;" href="{$url}"&gt;далее&lt;/a&gt;<br/><br/>&lt;/div&gt;</textarea>
</div>
