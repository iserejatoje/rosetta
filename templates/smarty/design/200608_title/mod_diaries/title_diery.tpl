
	<table cellpadding=2 cellspacing=0 border=0>
		<tr>
			<td>
				<font class="block_title3"><span>ДНЕВНИК <font color=red>{if ($USER->isAuth() && $smarty.get.id == $USER->ID) || ($USER->isAuth() && empty($smarty.get.id))}{$USER->NickName}{else}{$res.NickName}{/if}</font></span></font>
			</td>
		</tr>
	</table>