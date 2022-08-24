<table width="100%" cellspacing="3" cellpadding="0" >
	<tr><td class="block_title_obl" style="padding-left: 15px;" align="left"><span>{$BLOCK.title}</span></td></tr>
</table>
<table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
	  <td valign="top" class="zag1" bgcolor="#EDF6F8">{$BLOCK.res.status[1].p}</td>
        </tr>
        <tr>
          <td valign="top" style="padding-left: 10px;" class="text11">
                <strong>{$BLOCK.res.rub[1]}</strong> ({$BLOCK.res.count[1][1][0]|number_format:"0":",":" "})<br/>
		{foreach from=$BLOCK.res.object item=l key=k name=salelist}
                <a href="/sale/list.html?search=1&rubric=1&object[{$k}]=1&status=1" class=text11>{$l.s}</a>{* ({$BLOCK.res.count[1][1][$k]|number_format:"0":",":" "})*}{if !$smarty.foreach.salelist.last},{/if}
		{/foreach}
                <br/><img src="/_img/x.gif" width="1" height="7"></br>
                <strong>{$BLOCK.res.rub[2]}</strong> ({$BLOCK.res.count[2][1][0]|number_format:"0":",":" "})<br/>
		{foreach from=$BLOCK.res.object item=l key=k name=salelist}
                <a href="/sale/list.html?search=1&rubric=2&object[{$k}]=1&status=1" class=text11>{$l.s}</a>{* ({$BLOCK.res.count[2][1][$k]|number_format:"0":",":" "})*}{if !$smarty.foreach.salelist.last},{/if}
		{/foreach}
	  </td>
	</tr>
        <tr>
           <td align="right"><table width="90"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                 <td align="center"><small><a href="/sale/search.html"><b>Поиск по базе</b></a></small></td>
              </tr>
           </table></td>
        </tr>
	<tr>
	  <td valign="top" class="zag1" bgcolor="#EDF6F8">{$BLOCK.res.status[2].p}</td>
	</tr>
        <tr>
          <td valign="top" style="padding-left: 10px;" class="text11">
                <strong>{$BLOCK.res.rub[1]}</strong> ({$BLOCK.res.count[1][2][0]|number_format:"0":",":" "})<br/>
		{foreach from=$BLOCK.res.object item=l key=k name=salelist}
                <a href="/sale/list.html?search=1&rubric=1&object[{$k}]=1&status=2" class=text11>{$l.s}</a>{* ({$BLOCK.res.count[1][2][$k]|number_format:"0":",":" "})*}{if !$smarty.foreach.salelist.last},{/if}
		{/foreach}
                <br/><img src="/_img/x.gif" width="1" height="7"></br>
                <strong>{$BLOCK.res.rub[2]}</strong> ({$BLOCK.res.count[2][2][0]|number_format:"0":",":" "})<br/>
		{foreach from=$BLOCK.res.object item=l key=k name=salelist}
                <a href="/sale/list.html?search=1&rubric=2&object[{$k}]=1&status=2" class=text11>{$l.s}</a>{* ({$BLOCK.res.count[2][2][$k]|number_format:"0":",":" "})*}{if !$smarty.foreach.salelist.last},{/if}
		{/foreach}
	  </td>
	</tr>
        <tr>
           <td align="right"><table width="90"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                 <td align="center"><small><a href="/sale/search.html"><b>Поиск по базе</b></a></small></td>
              </tr>
           </table></td>
        </tr>
           <tr><td align="right" class="otzyv"><a href="/sale/add.html" style="color:red">Добавить объявление</a></td>
      </tr>
</table>