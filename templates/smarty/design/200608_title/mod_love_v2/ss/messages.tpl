<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Сообщение - {$res.userTo.user.name} - {$ENV.site.domain}</title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" type="text/css" href="/_styles/design/200710_afisha/afisha.css" />
<script language="javascript" src="/_scripts/modules/love/ajax.js"></script>
<script language="javascript" type="text/javascript">
{literal}
var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
var isOpera = (navigator.userAgent.indexOf("Opera") != -1);
var isNetscape = (navigator.appName == "Netscape");


function getDoc(obj) {
    if(isMSIE){
         return obj.Document;
    }
    if(isOpera || isNetscape){
         return obj.contentDocument;
    }
}

var serverSideURL = "{/literal}/{$ENV.section}/ajax.html?nocache=346&{literal}";
function getMessages()
{
	getData("ajax=getmessages&uidto="+{/literal}{$res.userTo.user.id}{literal}, 'addMessages', 'POST');
}

function putMessage()
{
	data = document.getElementById('new_msg').value;
	if(data != '')
		getData("ajax=putmessage&uidto="+{/literal}{$res.userTo.user.id}{literal}+"&message="+encodeURI(data), 'addMessages', 'POST');
	clearTextArea();
}

function clearTextArea()
{
	document.getElementById('new_msg').value = '';
}

function scrollFrame()
{
	obj = document.getElementById('iframemsg');
	obj.contentWindow.scrollBy(0, 100000);
}

function addMessages(val) {

	if (val != '') {
		doc = getDoc(document.getElementById('iframemsg'));
		doc.body.innerHTML += val;
		scrollFrame();
	}
}

function startUpdater()
{
	setInterval(getMessages, 5000);
}

{/literal}
</script>
</head>
<body onload="startUpdater()"><br />
	<table cellpadding=5 cellspacing=0 border=0 width=100%>
		<tr><td valign=middle align=left style="padding: 0px 5px 0px 5px">
			<table cellpadding=0 cellspacing=0 border=0>
				<tr><td rowspan=2>
					<a href="/{$SITE_SECTION}/user/{$res.userTo.user.id}.html"><img border=0 src="{if !empty($res.userTo.user.photos[0].img)}{$res.userTo.user.photos[0].img}{else}/img/love/nofoto.gif{/if}"></a> &#160;
				</td><td>
					<a href="/{$SITE_SECTION}/user/{$res.userTo.user.id}.html" title="Посмотреть анкету" target="_blank"><b><font color="#2297C6">{$res.userTo.user.name}</font></b></a>,&#160;</td><td><img valign=middle src={if $res.userTo.user.gender ==2}"/img/love/women.gif" alt="Девушка"{else}"/img/love/men.gif" alt="Парень"{/if}></td><td>&#160;<b>{$res.userTo.user.age}</b>&#160;</td><td><img src="/img/love/{$res.userTo.user.zodiak.img}" alt="{$res.userTo.user.zodiak.alt}" width=16 height=16></td><td>, {$res.userTo.user.city}

<!--LiveInternet counter--><script language="JavaScript"><!--
document.write('<img src="http://counter.yadro.ru/hit?r'+
escape(document.referrer)+((typeof(screen)=='undefined')?'':
';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+';'+Math.random()+
'" width=1 height=1 alt="">')//--></script><!--/LiveInternet--><a href="http://top100.rambler.ru/top100/"><img src="http://counter.rambler.ru/top100.cnt?{$GLOBAL.rambid}" alt="Rambler's Top100" width=1 height=1 border=0></a>		

				</td></tr>
			<tr><td colspan=5><font class=lit1>{*Был{if $res.to.gender==2}a{/if} {$res.to.what_lasttime*}&nbsp;</font></td></tr></table>
		</td></tr>
		<tr><td bgcolor="#2297C6" heigth=1></td></tr>
		<tr><td>
		<table width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td class=lit1>Сообщения:</td>
				<td class=lit1 align="right"><a href="/{$SITE_SECTION}/history/{$res.userTo.user.id}.html" target="_blank">История&nbsp;сообщений</a></td>
			</tr>
		</table>
		<IFRAME name=iframemsg id=iframemsg style="width:100%;height:240px" src="/{$ENV.section}/viewmessages/{$res.userTo.user.id}.html?type=list" scrolling="auto" frameborder="1"></IFRAME>
		<img src="/_img/x.gif" width="1" height="7" alt="" />
		<form name="formaddmsg" method="post" _onSubmit="javascript:return checkfrm(this)" _action="/{$ENV.section}/paddmessage/{$res.uidto}.html">
		
		<br/><div class=lit1 style="padding-bottom:2px">Новое сообщение:</div>
		<TEXTAREA class="txt" name="new_msg" id="new_msg" style="width:100%;height:120px"></TEXTAREA><br/>
		<br/>
		<input type="button" value="Отправить" style="width:150px" name="mbut" onclick="putMessage()"><br />
		
		</form></td>
		</tr>
		</table>
<center><!--begin of Top100 logo--><a href="http://top100.rambler.ru/top100/"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-gray2.gif" alt="Rambler's Top100" width=88 height=31 border=0></a><!--end of Top100 logo -->&nbsp;<!--LiveInternet logo--><a href="http://www.liveinternet.ru/click" target=_blank><img src="http://counter.yadro.ru/logo?44.1" border=0 width=31 height=31 alt="liveinternet.ru"></a><!--/LiveInternet--></center>
</body>
</html>