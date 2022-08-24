<table class="t11" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/love/" target="_blank">Знакомства</a></td></tr>
	</table>
</td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" align="left">
    <tr>
	<td width="100"><a href="/love/" target="_blank"><img src="/_img/design/200608_title/common/love_main.jpg" width="90" height="90" alt="Знакомства" border="0"></a></td>
        <td align="left">
            <form name="anketasearch" action="/love/search.html" method="get" target="_blank">
                <input type="hidden" value="all" name="time">
                <br>
                <table width="250" border="0" cellspacing="0" cellpadding="1">
                    <tr>
                        <td class="block_content"><b>&nbsp;Я</b></td>
                        <td>
                            <select style="font-size: 13px;" name="gi">
				<option value="1" selected>Парень</option>
				<option value="2">Девушка</option>
                            </select>
                        </td>
                        <td class="block_content"><b>Ищу</b></td>
                        <td>
                            <select style="font-size: 13px;" name="gw">
				<option value="1">Парня</option>
				<option value="2" selected>Девушку</option>
                            </select>
                        </td>
                    </tr>
		</table>
                <table width="250" border="0" cellspacing="0" cellpadding="1">
		    <tr><td colspan="5"><img src="/_img/x.gif" height="5" alt="" /></td></tr>
                    <tr>
                        <td class="block_content">&nbsp;<nobr><b>Возраст</b> от&nbsp;</nobr></td>
                        <td><input maxlength="2" size="3" name="agefrom" value="18"></td>
                        <td class="block_content">&nbsp;до&nbsp;</td>
                        <td><input maxlength="2" size="3" name="ageto" value="35"></td>
                        <td width="100%"><input name="submit" type="submit" value="Искать"></td>
		    </tr>
		    <tr><td colspan="5"><img src="/_img/x.gif" height="5" alt="" /></td></tr>
		</table>
{if !empty($BLOCK.res.anks)}
                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                    <tr align="right">
                        <td><div class="otzyv">Количество анкет <a href="/love/search.html?time=all&gi=-1&gw=1&agefrom=0&ageto=0&city=0&submit=%C8%F1%EA%E0%F2%FC" target="_blank">парней</a>: <b>{$BLOCK.res.anks[1]}</b>, <a href="/love/search.html?time=all&gi=-1&gw=2&agefrom=08&ageto=0&city=0&submit=%C8%F1%EA%E0%F2%FC" target="_blank">девушек</a>: <b>{$BLOCK.res.anks[2]}</b></div></td>
                    </tr>
                </table>
{/if}
            </form>
        </td>
    </tr>
</table>