<?

$CONFIG['months'][0] = array(1 => "январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
$CONFIG['months'][1] = array(1 => "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

function DateFormat($day_start, $month_start, $day_end, $month_end) {
	global $CONFIG;

	$day_month = "";
	if ( ($day_start != $day_end) && ($month_start == $month_end) )
		$day_month = $day_start."&ndash;".$day_end." ".$CONFIG['months'][1][$month_start];
	else if ( ($day_start != $day_end) && ($month_start != $month_end) )
		$day_month = $day_start." ".$CONFIG['months'][1][$month_start]."&ndash;".$day_end." ".$CONFIG['months'][1][$month_end];
	else if ( ($day_start == $day_end) && ($month_start == $month_end) )
		$day_month = $day_start." ".$CONFIG['months'][1][$month_start];

	return $day_month;
}

/*function MonthToStr($month_number, $case=0, $upcase=0)
{
	global $CONFIG;
	$month_number = intval($month_number);
	if ( $month_number < 1 || $month_number > 12 )
		return "";
	else
	{
		if($upcase == 1)
			return ucfirst($CONFIG['months'][$case][$month_number]);
		else
			return $CONFIG['months'][$case][$month_number];
	}
} */

if(!function_exists('CutDownStr'))
	include 'old.cutdownstr.php';
/*function CutDownStr($source, $MAX_STR_LEN)
{
	if ( strlen($source) > $MAX_STR_LEN ) {
        $dest = substr($source, 0, $MAX_STR_LEN);
		$dest = substr($dest, 0, strrpos($dest, " "));
		return $dest."&nbsp;...";
	} else
		return $source;
} */

function EscapeVars()
{
	$count = func_num_args();
	for($i = 0; $i < $count; $i++)
		$ret[] = mysqli_escape_string(func_get_arg($i));
	if($count == 1)
		return $ret[0];
	else
		return $ret;
}

function GetExchangeRate($template)
{
	global $DCONFIG;
	$db = DBFactory::GetInstance('rugion');

	$res = $db->query("SELECT max(date_n) FROM exchange");
	$row = $res->fetch_row();
	$max_date = $row[0];
	$res = $db->query("SELECT id, name FROM valuta WHERE id != '2' ORDER BY id");

	while ( $row = $res->fetch_row() )
	{
		$cur_id = $row[0];
		$cur_name = $row[1];
		$qr1 = $db->query("SELECT MAX(buy) as max_buy FROM exchange
							WHERE valuta=$cur_id and date_n='$max_date' AND buy>0");
		$row1 = $qr1->fetch_assoc();

		$qr2 = $db->query("SELECT MIN(sell) as min_sell FROM exchange
							WHERE valuta=$cur_id and date_n='$max_date' AND sell>0");
		$row2 = $qr2->fetch_assoc();
		$l[] = array(
			'name'	=> $cur_name,
			'buy'	=> $row1["max_buy"],
			'sell'	=> $row2["min_sell"]);
	}

	$DCONFIG['smarty']->assign('exchange_rate', $l);
	$text =  $DCONFIG['smarty']->fetch($template);
	$DCONFIG['smarty']->clear_assign('exchange_rate');
	return $text;
}

function GetSiteStatistic($project, $regid=74)
{
	$db = DBFactory::GetInstance('rugion');
	$dayofweek = date("w");
	if ($dayofweek==1 || $dayofweek==0)
	{
		$sql = "SELECT today_clients FROM ramb_st WHERE regid=$regid AND subproject=$project";
		$res = $db->query($sql);
		if ($row = $res->fetch_row()){
			$count = $row[0];
		}else{
			return null;
		}
	}

	if ($dayofweek==2 || $dayofweek==3 || $dayofweek==4 || $dayofweek==5 || $dayofweek==6)
	{
		$sql = "SELECT yesterday_clients FROM ramb_st WHERE regid=$regid AND subproject=$project";
		$res = $db->query($sql);
		if ($row = $res->fetch_row()){
			$count =  $row[0];
		}else{
			return null;
		}
	}


	if ($project==7) {
		$sql = "SELECT today_clients FROM ramb_st WHERE regid=$regid AND subproject=$project";
		$res = $db->query($sql);
		if ($row = $res->fetch_row()){
			$count = $row[0];
		}else{
			return null;
		}
	}


	return number_format($count,0,',',' ');
}

?>