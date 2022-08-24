<table width="550" border="0" cellspacing="0" cellpadding="3" align="center" bgcolor="#30A89E">
    <tr>
        <td align="center" style="color:#60D1C7;font-family:tahoma,verdana,arial;font-size:24px;font-weight:bold;">ЗНАКОМСТВА</td>
    </tr>
    <tr>
        <td align="center" bgcolor="#3FC5BA">
            <form name="anketasearch" action="/love/search.html" method="get">
                <input type="hidden" value="all" name="time">
                <br>
                <table width="450"  border="0" cellspacing="0" cellpadding="1">
                    <tr>
                        <td bgcolor="#6BD5CC" style="color:white"><b>&nbsp;Я</b></td>
                        <td bgcolor="#6BD5CC">
                            <select style="font-size: 13px;" name="gi">
                                <option value="0"{if $res.gi==0} selected{/if}></option>
								<option value="1"{if $res.gi==1 || empty($res.gi)} selected{/if}>Парень</option>
								<option value="2"{if $res.gi==2} selected{/if}>Девушка</option>
                            </select>
                        </td>
                        <td bgcolor="#6BD5CC" style="color:white"><b>Ищу</b></td>
                        <td bgcolor="#6BD5CC">
                            <select style="font-size: 13px;" name="gw">
                                <option value="0"{if $res.gw==0} selected{/if}></option>
								<option value="1"{if $res.gw==1} selected{/if}>Парня</option>
								<option value="2"{if $res.gw==2 || empty($res.gw)} selected{/if}>Девушку</option>
                            </select>
                        </td>
                        <td width="106" rowspan="5"><img src="{$images}/img1.gif" width="106" height="140"></td>
                    </tr>
                    <tr>
                        <td style="color:white">&nbsp;от</td>
                        <td><input maxlength="2" size="3" name="agefrom" value="{$res.agefrom}"></td>
                        <td style="color:white">до</td>
                        <td><input maxlength="2" size="3" name="ageto" value="{$res.ageto}"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#6BD5CC"><input type="checkbox" value="checked" name="photo_checkbox"{if $res.photo_checkbox} checked{/if}></td>
                        <td bgcolor="#6BD5CC" style="color:white">с фотографией</td>
                        <td bgcolor="#6BD5CC">&nbsp;</td>
                        <td bgcolor="#6BD5CC">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="color:white">&nbsp;Где</td>
                        <td>
                            <select id="search_city_name" style="font-size: 13px;" name="city">
                                <option value="0" selected>Любой город</option>
{foreach from=$res.cities item=l key=k}
							<option value="{$k}"{if (isset($res.city) && $res.city==$k) || (!isset($res.city) && $l.name==$CURRENT_ENV.site.name)} selected{/if}>{$l.name}</option>
{/foreach}
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td><input name="submit" type="submit" value="Искать"></td>
                    </tr>
                    <tr>
                        <td bgcolor="#6BD5CC" colspan="2">&nbsp;<a href="/{$SITE_SECTION}/extsearch.html" style="color:white">Расширенный поиск</a></td>
                        <td bgcolor="#6BD5CC">&nbsp;</td>
                        <td bgcolor="#6BD5CC">&nbsp;</td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>