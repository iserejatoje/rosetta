
{if sizeof($res.yearlink)}
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td>
 <table width=100% cellpadding=0 cellspacing=0 border=0>
 <tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
 <tr><td align=center>
	{foreach from=$res.yearlink item=l}
		{if $l==$smarty.get.year}
			&nbsp;[ {$l} ]&nbsp;
		{else}
			&nbsp;<A href="{$CONFIG.files.get.journals_calendar.string}?id={$smarty.get.id}&year={$l}">{$l}</A>&nbsp;
		{/if}
	{/foreach}
 </td></tr>
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 <tr><td align=center>
	<table width=100% cellpadding=4 cellspacing=0 border=0>
	{php}
	$a[1]="Январь";
	$a[2]="Февраль";
	$a[3]="Март";
	$a[4]="Апрель";
	$a[5]="Май";
	$a[6]="Июнь";
	$a[7]="Июль";
	$a[8]="Август";
	$a[9]="Сентябрь";
	$a[10]="Октябрь";
	$a[11]="Ноябрь";
	$a[12]="Декабрь";

	for($m=1;$m<=12;$m++){
		if( $m==1 || $m==4 || $m==7 || $m==10 ){
			echo "<tr valign=top>";
		}
		echo "<td width=34%>
		<TABLE width=100% cellpadding=2 cellspacing=1 border=0 bgcolor=#999999>
		<tr align=center bgcolor=#e9efef><td colspan=7><b>".$a[$m]."</b></td></tr>
		<tr align=center bgcolor=#e9efef>
		<td>ПН</td><td>ВТ</td><td>СР</td><td>ЧТ</td><td>ПТ</td><td>СБ</td><td>ВС</td>
		</tr>";

		$days=date("t",mktime(0,0,0,$m,1,$_GET["year"]));
		$fday=date("w",mktime(0,0,0,$m,1,$_GET["year"]));
		if(!$fday){$fday=7;}
		$digit=1;
		$curcell=1;

		for($row=1;$row<=ceil(($days + $fday - 1) / 7);$row++){
			echo "<tr align=center bgcolor=#ffffff>";
			for($i=1;$i<=7;$i++){
				if($digit > $days) {
					echo "<td>&nbsp;</td>";
				}else{
					if($curcell < $fday) {
						echo "<td>&nbsp;</td>";
						$curcell++;
						next;
					}else{
						{/php}
						{capture name=kk}{php}$key=$_GET["year"]."-".($m>=10?$m:"0".$m)."-".($digit>=10?$digit:"0".$digit);echo $key;{/php}{/capture}
						{if $res.list[$smarty.capture.kk]>0}
							<td bgcolor=#EFEFEF><a title="Записей: {$res.list[$smarty.capture.kk]}" class=s8red href="{$CONFIG.files.get.journals_record.string}?id={$smarty.get.id}&date={$smarty.capture.kk}"><font color=red>{php} echo $digit;{/php}</font></a></td>
						{else}
							<td>
								{php}echo $digit{/php}
							</td>
						{/if}
						{php}
						$digit++;
					}
				}
			}
			echo "</tr>";
		}
		if (ceil(($days + $fday - 1) / 7)==4) {
			echo "<tr align=center bgcolor=#ffffff>\n";
			echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>\n";
			echo "</tr>\n";
		}
		if (ceil(($days + $fday - 1) / 7)<6) {
			echo "<tr align=center bgcolor=#e9efef>\n";
			echo "<td>ПН</td><td>ВТ</td><td>СР</td><td>ЧТ</td><td>ПТ</td><td>СБ</td><td>ВС</td>\n";
			echo "</tr>\n";
		}

		echo "</TABLE>\n";
		echo "</td>\n";
		if( $m==3 || $m==6 || $m==9 || $m==12 ){
			echo "</tr>\n";
		}
	}
	{/php}
	</table>
 </td></tr>
 <tr><td><img src="/_img/x.gif" width=0 height=20 border=0></td></tr>
 </table>
</td></tr>
</table>
{else}
<br/><br/><br/><center>Записи не найдены</center><br/><br/>
{/if}