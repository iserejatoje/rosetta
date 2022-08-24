<?

/**
* Выводит селекты для дня-месяца-года
* Используется в adm/contest
*
* @param Name string - название массива элементов формы, которые относятся к дате
* @param Value string - текущая выбранная дата
* @param days array - дни (в adm/contest от 1 до 31), попадают в option'ы select'а с днями
* @param months array - названия месяцев (в adm/contest в родительном падеже), попадают в option'ы select'а с месяцами
* @param years array - годы, попадают в option'ы select'а с годами
*/

if( isset($vars['Name']) && !empty($vars['Name']) && isset($vars['days']) && sizeof($vars['days']) && isset($vars['months']) && sizeof($vars['months']) && isset($vars['years']) && sizeof($vars['years']) )
{
	$value = ( isset($vars['Value']) ) ? $vars['Value'] : 0;

?>
	<select style="width: 40px;" name="data[<?=$vars['Name']?>][day]">
<?
				$day = ($value == 0) ? 0 : date('j', $value);
				$sel = 0;
				
				foreach($vars['days'] as $k => $v)
				{
					if($day == $v)
						$sel = $v;
?>
					<option value="<?=$v?>"<?=( $day == $v ? ' selected="selected"' : '' )?>><?=$v?></option>
<?
				}
?>
				<option value="0"<?=( $sel ? '' : ' selected="selected"' )?>></option>
			</select>
			<select name="data[<?=$vars['Name']?>][month]">
<?
				$month = ($value == 0) ? 0 : date('n', $value);
				$sel = 0;
				
				foreach($vars['months'] as $k => $v)
				{
					if($month == $k)
						$sel = $k;
?>
					<option value="<?=$k?>"<?=( $month == $k ? ' selected="selected"' : '' )?>><?=$v?></option>
<?
				}
?>
				<option value="0"<?=( $sel ? '' : ' selected="selected"' )?>></option>
			</select>
			<select style="width: 58px;" name="data[<?=$vars['Name']?>][year]">
<?
				$year = ($value == 0) ? 0 : date('Y', $value);
				$sel = 0;
				
				foreach($vars['years'] as $k => $v)
				{
					if($year == $v)
						$sel = $v;
?>
					<option value="<?=$v?>"<?=( $year == $v ? ' selected="selected"' : '' )?>><?=$v?></option>
<?
				}
?>
				<option value="0"<?=( $sel ? '' : ' selected="selected"' )?>></option>
			</select>
			<input style="width: 24px;" value="<?=($value == 0 ? '' : date('H', $value))?>" name="data[<?=$vars['Name']?>][hour]" /> : <input style="width: 24px;" value="<?=($value == 0 ? '' : date('i', $value))?>" name="data[<?=$vars['Name']?>][min]" /> : <input style="width: 24px;" value="<?=($value == 0 ? '' : date('s', $value))?>" name="data[<?=$vars['Name']?>][sec]" />
<?
}
?>