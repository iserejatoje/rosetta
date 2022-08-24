<?

require_once $CONFIG['engine_path'].'include/advertise/shemes/auto/trailers.php';

class AdvSheme_auto_trailers_light extends AdvSheme_auto_trailers
{
	public $RubricID = 10;
	
	public $VisibleFields = array( 'brand', 'model', 'color', 'metallic',
		'year', 'status', 'capacity', 'destiny' );
	
	public function __construct($path, $prefix = '')
	{
		$this->sheme['scalar_fields']['Destiny']				= array( 'type' => 'int' );
	
		parent::__construct($path, $prefix);
	
		$this->Config['destiny'] =  array (
				1	=> 'для перевозки грузов',
				2 	=> 'для катера, лодки, гидроцикла',
				3 	=> 'для снегоходов, квадроциклов',
				4 	=> 'легковые автовозы',				
			);	
	}
}

class AdvIterator_auto_trailers_light extends AdvIterator_auto_trailers
{	
}

class Adv_auto_trailers_light extends Adv_auto_trailers
{
}

?>