<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" type="text/css" href="/site.css">
<title>{$SITE_NAME}{if !empty($SITE_NAME)}. {/if}User: {$USER_NAME}</title>
<style>
{literal}BODY{overflow:hidden;}{/literal}
</style>
<script language="javascript" type="text/javascript">{literal}
var selected = null;
function Init()
{
	img1 = new Image();
	img1.src = "/_img/themes/frameworks/jquery/treeview/bullet_add.gif";
	img2 = new Image();
	img2.src = "/_img/themes/frameworks/jquery/treeview/bullet_delete.gif";
	img3 = new Image();
	img3.src = "/_img/x.gif";
}
function Select(obj)
{
	if(selected != null)
		selected.className="simple";
	obj.className="selected";
	selected=obj;
}
function SelectById(id)
{
	var obj = document.getElementById(id);
	if(selected != null)
		selected.className="simple";
	obj.className="selected";
	selected=obj;
}

function Action(obj, id)
{
	if(selected != null)
		selected.className="simple";
	obj.className="selected";
	selected=obj;
	e = document.getElementById("mainView");
	e.src="main2.php?id="+id;
}

function ToggleMenu(o_img, obj)
{
	o_obj = document.getElementById(obj);
	if(o_obj.style.display == '')
	{
		o_obj.style.display = 'none';
		o_img.src = "/_img/themes/frameworks/jquery/treeview/bullet_add.gif";
	}
	else
	{
		o_obj.style.display = '';
		o_img.src = "/_img/themes/frameworks/jquery/treeview/bullet_delete.gif";
	}
}

function ShowPopupMenu(obj, type, id)
{
	var text;
	text = "<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\">";{/literal}
	text+= "<tr><td onmouseover=\"SelectElement(this)\" class=\"esimple\"><a href=\"index.php?section_id="+id+"&action=blank\" target=\"_blank\">В новом окне</a></td></tr>";
	{foreach from=$t_menu item=l}
	if({$l.id}==type)
		text+="{$l.text}";
	{/foreach}
	{literal}text+= Separator()+"<tr><td onmouseover=\"SelectElement(this)\" class=\"esimple\"><a href=\"main2.php?section_id="+id+"&maction=property\" target=\"mainView\">Свойства</a></td></tr>";
	text+= "</table>";
	o_menu = document.getElementById("menu");
	o_menu.innerHTML = text;
	o_menu.style.left = event.clientX - 3;
	o_menu.style.top = event.clientY - 3;
	o_menu.style.display = 'inline';
	return false;
}

function Separator()
{
	return "<tr><td style=\"background-color:#E0E0E0;padding:0px\"><img src=\"/_img/x.gif\" width=\"1\" height=\"1\"></td></tr>";
}

var e_selected = null;
function SelectElement(obj)
{
	if(e_selected != null)
		e_selected.className="esimple";
	obj.className="eselected";
	e_selected=obj;
}

function MouseMove()
{
	HideMenu();
}

function HideMenu()
{
	o_menu = document.getElementById("menu");
	if(o_menu != null)
		if(o_menu.style.display != 'none')
		{
			x = event.clientX;
			y = event.clientY;
			if(CursorInRect(o_menu, x, y) == false)
				o_menu.style.display='none';
		}
}

function CursorInRect(obj, x, y)
{
	if(x >= obj.offsetLeft && x <= obj.offsetLeft + obj.offsetWidth &&
	   y >= obj.offsetTop && y <= obj.offsetTop + obj.offsetHeight)
		return true;
	return false;
}


{/literal}</script>
</head>
<body onload="Init()" onmousemove="MouseMove()" style="margin:0px" oncontextmenu="return false;">
<div class="popupmenu" id="menu" name="menu" onmouseout="HideMenu()"></div>
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="180" valign="top">
			<table width="100%" height="100%" cellspacing="0" cellpadding="0"><tr><td height="100%">
				<div style="width:180px;height:100%;overflow-y:auto;overflow-x:scroll">{$menu}</div></td></tr><tr><td>
				<div style="width:180px;padding:3px;background-color:#f3f3f3;" align="center">
				{if $USER->IsInRole('e_adm_execute_heap')}<a href="heap.php" target="mainView">Объявления</a><br>{/if}
				{if $USER->IsInRole('e_adm_execute_forum')}<a href="forum.php" target="mainView">Форумы</a><br>{/if} 
				{if $USER->IsInRole('e_adm_execute_users')}<a href="user.php" target="mainView">Пользователи</a>{/if}
				</div>
			</td></tr></table>
		</td>
		<td width="1" valign="top" bgcolor="#eeeeee" style="overflow:hidden">&nbsp;</td>
		<td height="100%"><iframe src="main2.php{if $SECTION_ID!=null}?section_id={$SECTION_ID}{/if}" width="100%" height="100%" frameborder="no" name="mainView" id="mainView"></iframe></td>
	</tr>
</table>

</body>
</html>
