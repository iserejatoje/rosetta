<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/garage.php';

class AdvSheme_realty_garage_cooperative_demand extends AdvSheme_realty_garage
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_garage_demand',
			'slaves' => array(
				'Options' 	=> '_garage_demand_options',
				'Favorite'	=> '_garage_demand_favorites',
			)
		);
		// скалярные поля
		$this->sheme['scalar_fields']['BuildingArea'] 	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Decoration'] 	= array( 'type' => 'int' );
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_garage_cooperative_demand extends AdvIterator_realty_garage
{
}

class Adv_realty_garage_cooperative_demand extends Adv_realty_garage
{
}

?>