<? if ($vars['children']['header']) { ?>
	<?=$vars['children']['header']?>
<? } ?>

<tr>
	<td valign="top" style="height:100%;">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr valign="top">
				<? if ($vars['children']['left']) { ?>
				<td style="width:220px"><?=$vars['children']['left']?></td>
				<? } ?>
				
                <td style="width:10px"> </td>
				<td><?=$vars['children']['center']?></td>
                <td style="width:10px"> </td>
				
				<? if ($vars['children']['right']) { ?>
				<td style="width:220px"><?=$vars['children']['right']?></td>
				<? } ?>
			</tr>
		</table>
	</td>
</tr>

<? if ($vars['children']['footer']) { ?>
	<?=$vars['children']['footer']?>
<? } ?>
