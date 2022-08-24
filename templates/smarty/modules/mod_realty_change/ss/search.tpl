{$page.top}

<br /><br />

    	<form name="frm" action="/{$ENV.section}/list.html" method="get">
    	<input type="hidden" name="search" value="1"/>
    	<table align="center" cellspacing="1" class="table2">
    		<tr>
				<th colspan="2">Поиск</th>
		    </tr>
			<tr>
      			<td align="right" class="bg_color2">Рубрика:</td>
      			<td width="300" class="bg_color4">
      				<select name="rubric" type="select-one" style="width:300px">

{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.rubric}selected="selected"{/if}>{$v}</option>
{/foreach}
					</select>
      			</td>
    		</tr>
		<tr>
			<td align="right" class="bg_color2">Схема обмена:</td>
			<td class="bg_color4"><input type="text" name="scheme" style="width:295px" value=""{$ENV._params.scheme}"><br />
			<font class="small">Пример: 1 + 1 + д = 3 или 4</font></td>
		</tr>
		<tr>
			<td align="right" class="bg_color2">Имеется:</td>
			<td class="bg_color4"><textarea name=have style="width:295px;height:50px">{$ENV._params.have}</textarea></td>
		</tr>
		<tr>
			<td align="right" class="bg_color2">Требуется:</td>
			<td class="bg_color4"><textarea name=need style="width:295px;height:50px">{$ENV._params.need}</textarea></td>
		</tr>
    	<tr>
      		<td align="right" class="bg_color2">Дата:</td>
      		<td class="bg_color4">
		      <select name="date_show" style="width:300px">
{foreach from=$ENV._arrays.date_show item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.date_show}selected="selected"{/if}>{$v.t}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
      		<td align="right" class="bg_color2">C фото?</td>
			<td class="bg_color4"><input type="checkbox" name="photo" {if $ENV._params.photo}checked="checked"{/if}></td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Показать в виде:</td>
      		<td class="bg_color4">
      			<select name="view" style="width:300px">
{foreach from=$ENV._arrays.view item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.view}selected="selected"{/if}>{$v}</option>
{/foreach}
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Сортировать:</td>
      		<td class="bg_color4">
      			<select name="order" style="width:300px">
{foreach from=$ENV._arrays.order item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.order}selected="selected"{/if}>{$v[1]}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
      		<td align="center" colspan="2">
      			<input class="button" type="submit" value="Искать" style="width:100px">&nbsp
      			<input class="button" type="reset" value="Очистить" style="width:100px">
      		</td>
    	</tr>
    </table>
	</form>

<br /><br />