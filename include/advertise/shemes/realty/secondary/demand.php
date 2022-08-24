<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/secondary.php';

class AdvSheme_realty_secondary_demand extends AdvSheme_realty_secondary
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_secondary_demand',
			'slaves' => array(
				'Options' 	=> '_secondary_demand_options',
				'Favorite'	=> '_secondary_demand_favorites',
			)
		);
		// скалярные поля
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_secondary_demand extends AdvIterator_realty_secondary
{
}

class Adv_realty_secondary_demand extends Adv_realty_secondary
{
}

?>