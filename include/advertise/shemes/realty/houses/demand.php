<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/houses.php';

class AdvSheme_realty_houses_demand extends AdvSheme_realty_houses
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_houses_demand',
			'slaves' => array(
				'Options' 	=> '_houses_demand_options',
				'Favorite'	=> '_houses_demand_favorites',
			)
		);
		// скалярные поля
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_houses_demand extends AdvIterator_realty_houses
{
}

class Adv_realty_houses_demand extends Adv_realty_houses
{
}

?>