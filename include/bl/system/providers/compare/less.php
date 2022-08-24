<?

class BL_system_provider_compare_less implements IBL_system_provider_data, IBL_system_provider_name
{
	public function Compare($a, $b)
	{
		return $a < $b;
	}
	
	public function GetName()
	{
		return 'less';
	}
}

?>

