<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/garage.php';

class AdvSheme_realty_garage_parking_demand extends AdvSheme_realty_garage
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_parking_demand',
			'slaves' => array(
				'Options' 	=> '_parking_demand_options',
				'Favorite'	=> '_parking_demand_favorites',
			)
		);
		// скалярные поля
		$this->sheme['scalar_fields']['LandArea']	= array( 'type' => 'int' );
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_garage_parking_demand extends AdvIterator_realty_garage
{
}

class Adv_realty_garage_parking_demand extends Adv_realty_garage
{
}

?>