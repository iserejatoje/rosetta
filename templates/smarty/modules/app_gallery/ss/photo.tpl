{include file="`$TEMPLATE.sectiontitle`" type="2"}

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr><td>
	<div style="position: relative; width: 97%; margin-bottom: 143px;">
	<div id="previews" class="bg_color2" style="overflow:auto; height:143px; width:100%; padding:4px; position:absolute;">
		<table border="0" cellspacing="0" cellpadding="0" style="width:auto; border-collapse: collapse">
		<tr>
		{foreach from=$page.photos item=l}
			<td align="center">
				{if $page.cphoto.id == $l.id}
					{include file=$TEMPLATE.ssections.thumb photo=$l hide=1 notitle=1 active=1}
				{else}
					{include file=$TEMPLATE.ssections.thumb photo=$l hide=1 notitle=1}
				{/if}
			</td>
		{/foreach}
		</tr>
		</table>
	</div>
	</div>
</td></tr>
</table>

<br/>

{if $page.caneditphoto}<div class="profile_div" align="right">
	<div style="float:right; margin-left:20px">
		<a href="{$page.actions.delete}">Удалить фото</a>
	</div>	
	<div style="float:right; margin-left:20px">
		<a href="{$page.actions.add}">Добавить фото</a>
	</div>
	<div style="float:right; margin-left:20px">
		<a href="{$page.actions.edit}">Редактировать фото</a>
	</div>
	{if is_array($page.rights)}{include file=$TEMPLATE.rightsmenu rights=$page.rights right=$page.cphoto.rights url=$page.actions.setrights}{/if}
</div>{/if}
<br/>
<div class="title" style="padding: 5px" align="center">{$page.cphoto.title}</div>
<div style="clear:both; margin-bottom:50px" align="center">
	<img src="{$page.cphoto.photo.url}" border="0" width="{$page.cphoto.photo.width}" height="{$page.cphoto.photo.height}" alt="{$page.cphoto.title}" />
	<div style="padding:10px;">{$page.cphoto.descr}</div>
</div>


<script type="text/javascript" language="javascript">
<!--

var i = 1;
{foreach from=$page.photos item=l name="array"}
app_gallery.count = $
app_gallery.photos[i] = new Array();
app_gallery.photos[i]['thumb'] = new Array();
app_gallery.photos[i]['id'] = {$l.id};
app_gallery.photos[i]['url'] = '{$l.thumb.url}';
app_gallery.photos[i++]['descr'] = '{$l.descr}';
{/foreach}

app_gallery.nearest_count = 2;
app_gallery.image_size = 120;
app_gallery.container = document.getElementById('previews');
app_gallery.initPosition({$page.cphoto.id});

-->
</script>