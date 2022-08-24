<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/realty/foreign.php';

class AdvSheme_realty_foreign_houses extends AdvSheme_realty_foreign
{
	public function __construct($path, $prefix = '')
	{
		// скалярные поля
		$this->sheme['scalar_fields']['LandArea']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Decoration'] 	= array( 'type' => 'int' );
		// векторные поля
		$this->sheme['vector_fields']['Options']	= array( 'type' => 'int' );
		parent::__construct($path, $prefix);
	}	
}

class AdvIterator_realty_foreign_houses extends AdvIterator_realty_foreign
{
}

class Adv_realty_foreign_houses extends Adv_realty_foreign
{
}

?>