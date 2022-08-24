<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/foreign/new.php';

class AdvSheme_realty_foreign_new_demand extends AdvSheme_realty_foreign_new
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_new_demand',
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

class AdvIterator_realty_foreign_new_demand extends AdvIterator_realty_foreign_new
{
}

class Adv_realty_foreign_new_demand extends Adv_realty_foreign_new
{
}

?>