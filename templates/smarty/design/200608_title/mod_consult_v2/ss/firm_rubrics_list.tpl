<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">Разделы</font>
		</td>
	</tr>
</table>
<br/><br/>
<table width="100%" cellpadding="0" cellspacing="0">
	{section name=i loop=$res.rubrics step=2}
	<tr>
		<td width="20"><img src="/_img/x.gif" width="20" height="1" alt="" /></td>
		<td valign="top"  width="50%">
			<p><font class="zag2"><a href="/{$ENV.section}/{$res.rubrics[i].r_path}/{$res.rubrics[i].cid}.html" class="zag2">{$res.rubrics[i].r_name}</a></font><br/>
			{if !empty($res.rubrics[i].last_comment)}
			<font class="data"><b>{$res.rubrics[i].last_comment.name}</b>: </font><font class="ssyl">{$res.rubrics[i].last_comment.otziv|truncate:40:"...":false}</font> <a href="/{$ENV.section}/{$res.rubrics[i].r_path}/{$res.rubrics[i].cid}.html#{$res.rubrics[i].last_comment.id}"><small>&gt;&gt;</small></a><br/>
			{/if}
			</p>
		</td>
		<td width="20" valign="top"><img src="/_img/x.gif" width="20" height="1" alt="" /></td>
		{section name=i2 loop=$res.rubrics max=1 start=$smarty.section.i.index+1}
		<td valign="top" width="50%">
			<p><font class="zag2"><a href="/{$ENV.section}/{$res.rubrics[i2].r_path}/{$res.rubrics[i2].cid}.html" class="zag2">{$res.rubrics[i2].r_name}</a></font><br/>
			{if !empty($res.rubrics[i2].last_comment)}
			<font class="data"><b>{$res.rubrics[i2].last_comment.name}</b>: </font><font class="ssyl">{$res.rubrics[i2].last_comment.otziv|truncate:40:"...":false}</font> <a href="/{$ENV.section}/{$res.rubrics[i2].r_path}/{$res.rubrics[i2].cid}.html#{$res.rubrics[i2].last_comment.id}"><small>&gt;&gt;</small></a><br/>
			{/if}
			</p>
		</td>
		{/section}
		<td width="20" valign="top"><img src="/_img/x.gif" width="20" height="1" alt="" /></td>
	</tr>
	<tr>
		<td width="20" valign="bottom">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td width="20">&nbsp;</td>
	</tr>
	{/section}
</table>