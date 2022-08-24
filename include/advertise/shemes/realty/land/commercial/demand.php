<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/land.php';

class AdvSheme_realty_land_commercial_demand extends AdvSheme_realty_land
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_land_demand',
			'slaves' => array(
				'Options' 	=> '_land_demand_options',
				'Favorite'	=> '_land_demand_favorites',
			)
		);
		// скалярные поля
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_land_commercial_demand extends AdvIterator_realty_land
{
}

class Adv_realty_land_commercial_demand extends Adv_realty_land
{
}

?>