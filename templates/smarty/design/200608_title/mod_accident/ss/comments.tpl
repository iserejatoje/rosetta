{if count($comments)!=0}
<br><div class="zag6"><b>Мнение посетителей:</b></div><br>
			
					{foreach from=$comments item=comment key=k}
					
				<table cellpadding=2 cellspacing=0 width=100% border=0>
					<tr bgcolor="#F1F6F9">
						<td align=left>&nbsp;
							<a name="#{$comment.id}"></a>{$k+1}.&nbsp;
							<b>{if !empty($comment.email)} <a href='mailto:{$comment.name}'>{$comment.name}</a>
							{else}{$comment.name}{/if}</b>&nbsp;
							<font class="copy"><font class="rem"> <b>{"G:i"|date:$comment.date}</b>&nbsp;{"j.m.Y"|date:$comment.date} </font></font></td>
					</tr>
					<tr>
						<td align=left>{$comment.otziv}</td>
					</tr>
				</table>
			<br>{/foreach}
{/if}