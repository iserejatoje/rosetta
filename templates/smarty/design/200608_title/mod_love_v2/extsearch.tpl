<form name="anketasearch" action="#result" method="get" style="margin:0px">
<table cellspacing="0" cellpadding="0" width="90%" border="0" align="center">
    <tr>
        <td class="txt_white" valign="top" align="left">
            <input type="hidden" value="all" name="time">
            <table cellspacing="0" cellpadding="5" width="100%" border="0">
                <tr align="center" bgcolor="#30A89E">
                    <TD colSpan="2" class="zag-white">ЗНАКОМСТВА</td>
                </tr>
                <tr align="center" bgcolor="#3FC5BA">
                    <td colSpan="2" class="txt_white"><b>Я</b>&nbsp;&nbsp;
                        <select style="font-size: 13px;" name="gi">
                            <option value="0"{if $res.gi==0} selected{/if}></option>
                        	<option value="1"{if $res.gi==1 || empty($res.gi)} selected{/if}>Парень</option>
                        	<option value="2"{if $res.gi==2} selected{/if}>Девушка</option>
                        </select>
                        &nbsp;&nbsp;<b>Ищу</b>&nbsp;&nbsp;
                        <select style="font-size: 13px;" name=gw>
                            <option value="0"{if $res.gw==0} selected{/if}></option>
                            <option value="1"{if $res.gw==1} selected{/if}>Парня</option>
                            <option value="2"{if $res.gw==2 || empty($res.gw)} selected{/if}>Девушку</option>
                        </select>
                    </td>
                </tr>
                <tr bgcolor="#3FC5BA">
                    <td align="right" nowrap="nowrap"> <span class="txt_white">Имя:</span></td>
                    <td nowrap="nowrap"> <input maxLength="50" size="14" name="name"> <span class="txt_white">Где искать:</span>
                        <select id="search_city_name" style="font-size: 13px;" name="city">
                            <option value="0" selected>Любой город</option>
{foreach from=$res.cities item=l key=k}
							<option value="{$k}"{if (isset($res.city) && $res.city==$k) || (!isset($res.city) && $l.name==$CURRENT_ENV.site.name)} selected{/if}>{$l.name}</option>
{/foreach}
                        </select>
    				</td>
                </tr>
                <tr bgcolor="#3FC5BA">
                    <td align="right" valign="center" class="txt_white">В возрасте</td>
                    <td class="txt_white">от&nbsp;<input maxLength="2" size="3" name="agefrom" value="{$res.agefrom}">&nbsp;
                        до&nbsp;<input maxLength="2" size="3" name="ageto" value="{$res.ageto}">&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" value="checked" name="photo_checkbox" >&nbsp;
                        с фотографией&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="isicq">&nbsp;ICQ&nbsp;
                    </td>
                </tr>
                <tr bgcolor="#A6EFE9">
                    <td valign="top" bgcolor="#A6EFE9" class="tit_vac" align="right">Знак зодиака: </td>
                    <td>
                        <table cellpadding="0" cellspacing="0">
{foreach from=$res.details.zodiak item=l key=i}
		                    {cycle values="<tr>,," name="zodiakb"}
		                        <td width="150"><input type="checkbox" name="zodiak[]" value="{$i}"{if in_array($i, (array)$res.details.zodiak_selected)} checked{/if}>{$l.alt}</td>
		                    {cycle values=",,</td>" name="zodiake"}
{/foreach}
                        </table>
                    </td>
                </tr>
                <tr bgcolor="#30A89E"><td height="1" colspan="2">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="top" bgcolor="#FFF3FB" class="tit_vac">Цель поиска: </td>
                    <td>
                        <table cellpadding="0" cellspacing="0">
{foreach from=$res.target_arr item=l key=k}
		                {cycle values="<tr>,," name="targetb"}
		                    <td width="22" valign="top"><input type="checkbox" name="target[]" value="{$k}"{if in_array($k, (array)$res.details.target.selected)} checked{/if}></td><td width=130 valign=top>{$l}</td>
		                {cycle values=",,</td>" name="targete"}
{/foreach}
                        </table>
                    </td>
                </tr>
                <tr bgColor="#DBFBF8" height="32">
                    <td align="right" valign="top" class="tit_vac">Семейное положение:</td>
                    <td nowrap="nowrap">
                        <select style="font-size: 13px;" name="married" size="1">
{foreach from=$res.married_arr item=l key=k}
                          <option value="{$k}" {if $k==$res.details.married.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                        &#160;&#160;&#160;
                        Наличие детей:
                        <select style="font-size: 13px;" name="kids" size="1">
{foreach from=$res.kids_arr item=l key=k}
                     	<option value="{$k}" {if $k==$res.details.kids.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr height="32">
                    <td align="right" bgcolor="#FFF3FB" class="tit_vac">Рост, см:</td>
                    <td nowrap="nowrap">
                        от <input type="text" name="heightfrom" size="3" value="{$res.heightfrom}" maxlength=3>
						до <input type="text" name="heightto" size="3" value="{$res.heightto}" maxlength=3>
                        &nbsp;&nbsp;&nbsp;
                        Телосложение:&nbsp;
                        <select style="font-size: 13px;" name="figure" size="1">
{foreach from=$res.figure_arr item=l key=k}
                         <option value="{$k}" {if $k==$res.details.figure.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr bgColor="#DBFBF8" height=32>
                    <td align="right" class="tit_vac">Волосы:</td>
                    <td>
                        <select style="font-size: 13px;" name="hair" size="1">
{foreach from=$res.hair_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.hair.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr height="32">
                    <td align="right" bgcolor="#FFF3FB" class="tit_vac">Образование:</td>
                    <td>
                        <select style="font-size: 13px;" name="edu" size="1">
{foreach from=$res.edu_arr item=l key=k}
                			<option value="{$k}" {if $k==$res.details.edu.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr bgColor="#DBFBF8">
                    <td align="right" vAlign="top" class="tit_vac">Материальное положение:</td>
                    <td>
                        <select style="font-size: 13px;" name="circs" size="1">
{foreach from=$res.circs_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.circs.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" vAlign="top" bgcolor="#FFF3FB" class="tit_vac">Разговорные языки:</td>
                    <td>
                        <table cellpadding="0" cellspacing="0">
{foreach from=$res.lang_arr item=l key=k}
						{cycle values="<tr>,," name="langb"}
							<td width="22" valign="top"><input type="checkbox" name="lang[]" value="{$k}"{if in_array($k, (array)$res.details.lang.selected)} checked{/if}></td><td width=130 valign=top>{$l}</td>
						{cycle values=",,</td>" name="lange"}
{/foreach}
                        </table>
                    </td>
                </tr>
                <tr bgcolor="#DBFBF8">
                    <td align="right" vAlign="top" class="tit_vac">Увлечения:</td>
                    <td>
                        <table cellpadding="0" cellspacing="0">
{foreach from=$res.hobby_arr item=l key=k}
		                {cycle values="<tr>,," name="hobbyb"}
		                    <td width="22" valign="top"><input type="checkbox" name="hobby[]" value="{$k}"{if in_array($k, (array)$res.details.hobby.selected)} checked{/if}></td><td width=130 valign=top>{$l}</td>
		                {cycle values=",,</td>" name="hobbye"}
{/foreach}
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top" bgcolor="#FFF3FB" class="tit_vac">Отношение к курению:</td>
                    <td>
                        <select style="font-size: 13px;" name="smoking" size="1">
{foreach from=$res.smoking_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.smoking.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr bgColor="#DBFBF8">
                    <td align="right" vAlign="top" class="tit_vac">Отношение к алкоголю:</td>
                    <td>
                        <select style="font-size: 13px;" name="alkohol" size="1">
{foreach from=$res.alkohol_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.alkohol.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" vAlign="top" bgcolor="#FFF3FB" class="tit_vac">Отношение к наркотикам:</td>
                    <td>
                        <select style="font-size: 13px;" name="dope" size="1">
{foreach from=$res.dope_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.dope.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr bgColor="#DBFBF8">
                    <td align="right" vAlign="top" class="tit_vac">Отношение к сексу:</td>
                    <td>
                        <select style="font-size: 13px;" name="sexing" size="1">
{foreach from=$res.sexing_arr item=l key=k}
							<option value="{$k}" {if $k==$res.details.sexing.selected} selected{/if}>{$l}</option>
{/foreach}
                        </select>
                    </td>
                </tr>
                <tr align="center" bgColor="30A89E" height="32"><td colSpan=2><input type="submit" value="Искать"></td></tr>
            </table>
        </td>
    </tr>
</table>
</form>
<a name="result"></a>
