<table width="100%" class="block_right" cellspacing="3" cellpadding="0" >
	<tr><th><span>{$ENV.site.title.love}</span></th></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
	<form name="anketasearch" action="/love/search.html" metod="get">
	<input type=hidden name="time" value="all"> 
	<input type=hidden name="gi" value="0"> 
	<table width="100%" border="0" cellspacing="2" cellpadding="0" class="announce_form">
	<tr>
		<td align="right">
			<table width="100%"  border="0" cellspacing="0" cellpadding="2">
				<tr align="left">
					<td width="10">&nbsp;</td>
					<td><font class="form_title">Ищу</font></td>
					<td width="120">
						<select name="gw" style="width:100%" class="in_field">
							<option value="0"{if $BLOCK.res.gw==0} selected{/if}></option>
                            <option value="1"{if $BLOCK.res.gw==1} selected{/if}>Парня</option>
                            <option value="2"{if $BLOCK.res.gw==2 || empty($res.gw)} selected{/if}>Девушку</option>
						</select>
					</td>
					<td width="10">&nbsp;</td>
				</tr>
				<tr align="left">
					<td width="10">&nbsp;</td>
					<td><font class="form_title">Возраст</font></td>
					<td width="120">
						<select name="agefrom" style="width:48%" class="in_field">
							<option selected value="0">От</option>
							<option>18</option>
							<option>20</option>
							<option>25</option>
							<option>30</option>
							<option>35</option>
							<option>40</option>
							<option>45</option>
							<option>50</option>
							<option>55</option>
						</select>
						<select name="ageto" style="width:48%" class="in_field">
							<option selected value="0">До</option>
							<option>18</option>
							<option>20</option>
							<option>25</option>
							<option>30</option>
							<option>35</option>
							<option>40</option>
							<option>45</option>
							<option>50</option>
							<option>55</option>
						</select>
					</td>
					<td width="10">&nbsp;</td>
				</tr>
				<tr align="left">
					<td width="10">&nbsp;</td>
					<td><font class="form_title">В&nbsp;городе</font></td>
					<td width="120">
						<select name="city" id="search_city_name" style="width:100%" class="in_field">
							<option value="0" selected>Любой город</option>
{foreach from=$BLOCK.res.cities item=l key=k}
                           	<option value="{$k}"{if (isset($BLOCK.res.city) && $BLOCK.res.city==$k) || (!isset($BLOCK.res.city) && $l.name==$CURRENT_ENV.site.name)} selected{/if}>{$l.name}</option>
{/foreach}
						</select>
					</td>
					<td width="10">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr><td width="10">&nbsp;</td><td align="right"><input type="submit" name="imageField" value="Искать" class="in_submit"></td><td width="15">&nbsp;</td>
		</tr></table></td>
	</tr>
	</form> 
</table>
</td>
</tr>
</table>