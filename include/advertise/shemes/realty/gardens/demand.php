<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/gardens.php';

class AdvSheme_realty_gardens_demand extends AdvSheme_realty_gardens
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

class AdvIterator_realty_gardens_demand extends AdvIterator_realty_gardens
{
}

class Adv_realty_gardens_demand extends Adv_realty_gardens
{
}

?>