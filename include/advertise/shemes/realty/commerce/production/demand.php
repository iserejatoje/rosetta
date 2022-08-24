<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/commerce.php';

class AdvSheme_realty_commerce_production_demand extends AdvSheme_realty_commerce
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_commerce_demand',
			'slaves' => array(
				'Options' 	=> '_commerce_demand_options',
				'Favorite'	=> '_commerce_demand_favorites',
			)
		);
		// скалярные поля
		// векторные поля
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_commerce_production_demand extends AdvIterator_realty_commerce
{
}

class Adv_realty_commerce_production_demand extends Adv_realty_commerce
{
}

?>