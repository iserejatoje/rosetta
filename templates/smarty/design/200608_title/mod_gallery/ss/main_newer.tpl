<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td align="center" rowspan="2" bgcolor="#F3F8F8">
			<a href="/{$ENV.section}/view/photo/{$photos[0].id}.html">
			{if !empty($photos[0].image)}
				<img src="{$photos[0].image}" {$photos[0].image_size} style="border: #005A52 solid 1px"
			alt="Последнее фото" title="Смотреть фото &laquo;{$photos[0].name}&raquo;"/><br />
			{/if}</a>

			<a href="/{$ENV.section}/view/photo/{$photos[0].id}.html" 
				title="Смотреть фото &laquo;{$photos[0].name}&raquo;"><b>{$photos[0].name}</b></a>
			{if $photos[0].descr}
				<br /><font class="lit2" title="Описание">{$photos[0].descr}</font>
			{/if}
				<br /><b>Автор:</b>
				<a href="/{$ENV.section}/list/albums/u{$photos[0].uid}.html"><b><font class="s1" title="Смотреть альбомы {$photos[0].user}">{$photos[0].user}</font></b></a>
				<br /><font class="lit2"><b>Добавлено: </b> {"d.m.Y H:i:s"|date:$photos[0].date_create}</b></font>
			
		</td>
		<td align="center">
			<a href="/{$ENV.section}/view/photo/{$photos[1].id}.html">
			{if !empty($photos[1].image)}
				<img src="{$photos[1].image}" {$photos[1].image_size} style="border: #005A52 solid 1px"
			alt="Последнее фото" title="Смотреть фото &laquo;{$photos[1].name}&raquo;"/><br />
			{/if}</a>

			<a href="/{$ENV.section}/view/photo/{$photos[1].id}.html" 
				title="Смотреть фото &laquo;{$photos[1].name}&raquo;"><b><font
				class="s1">{$photos[1].name}</font></b></a>
			{if $photos[1].descr}
				<br /><font class="lit2" title="Описание">{$photos[1].descr}</font>{/if}<br />
				<b>Автор:</b>
				<a href="/{$ENV.section}/list/albums/u{$photos[1].uid}.html"><b><font class="s1" title="Смотреть альбомы {$photos[1].user}">{$photos[1].user}</font></b></a>
				<br /><font class="lit2"><b>Добавлено: </b>{"d.m.Y H:i:s"|date:$photos[1].date_create}</b></font>
			
		</td>
		<td align="center">
			<a href="/{$ENV.section}/view/photo/{$photos[2].id}.html">
			{if !empty($photos[2].image)}
				<img src="{$photos[2].image}" {$photos[2].image_size} style="border: #005A52 solid 1px"
			alt="Последнее фото" title="Смотреть фото &laquo;{$photos[2].name}&raquo;"/><br />
			{/if}</a>

			<a href="/{$ENV.section}/view/photo/{$photos[2].id}.html" 
				title="Смотреть фото &laquo;{$photos[2].name}&raquo;"><b><font
				class="s1">{$photos[2].name}</font></b></a>
			{if $photos[2].descr}
				<br /><font class="lit2" title="Описание">{$photos[2].descr}</font>{/if}<br />
				<b>Автор:</b>
				<a href="/{$ENV.section}/list/albums/u{$photos[2].uid}.html"><b><font class="s1" title="Смотреть альбомы {$photos[2].user}">{$photos[2].user}</font></b></a>
				<br /><font class="lit2"><b>Добавлено: </b>{"d.m.Y H:i:s"|date:$photos[2].date_create}</b></font>
			
		</td>
	</tr>
	<tr>
		<td align="center">
			<a href="/{$ENV.section}/view/photo/{$photos[3].id}.html">
			{if !empty($photos[3].image)}
				<img src="{$photos[3].image}" {$photos[3].image_size} style="border: #005A52 solid 1px"
			alt="Последнее фото" title="Смотреть фото &laquo;{$photos[3].name}&raquo;"/><br />
			{/if}</a>

			<a href="/{$ENV.section}/view/photo/{$photos[3].id}.html" 
				title="Смотреть фото &laquo;{$photos[3].name}&raquo;"><b><font
				class="s1">{$photos[3].name}</font></b></a>
			{if $photos[3].descr}
				<br /><font class="lit2" title="Описание">{$photos[3].descr}</font>{/if}<br />
				<b>Автор:</b>
				<a href="/{$ENV.section}/list/albums/u{$photos[3].uid}.html"><b><font class="s1" title="Смотреть альбомы {$photos[3].user}">{$photos[3].user}</font></b></a>
				<br /><font class="lit2"><b>Добавлено: </b>{"d.m.Y H:i:s"|date:$photos[3].date_create}</b></font>
			
		</td>
		<td align="center">
			<a href="/{$ENV.section}/view/photo/{$photos[4].id}.html">
			{if !empty($photos[4].image)}
				<img src="{$photos[4].image}" {$photos[4].image_size} style="border: #005A52 solid 1px"
			alt="Последнее фото" title="Смотреть фото &laquo;{$photos[4].name}&raquo;"/><br />
			{/if}</a>

			<a href="/{$ENV.section}/view/photo/{$photos[4].id}.html" 
				title="Смотреть фото &laquo;{$photos[4].name}&raquo;"><b><font
				class="s1">{$photos[4].name}</font></b></a>
			{if $photos[4].descr}
				<br /><font class="lit2" title="Описание">{$photos[4].descr}</font>{/if}<br />
				<b>Автор:</b>
				<a href="/{$ENV.section}/list/albums/u{$photos[4].uid}.html"><b><font class="s1" title="Смотреть альбомы {$photos[4].user}">{$photos[4].user}</font></b></a>
				<br /><font class="lit2"><b>Добавлено: </b>{"d.m.Y H:i:s"|date:$photos[4].date_create}</b></font>
			
		</td>
	</tr>
	<tr>
		<td colspan="3"><img src="/_img/x.gif" width="1" height="15" alt="" /></td>
	</tr>
</table>
