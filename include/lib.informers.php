<?
class Informers
{
	static private $_informers = array(
		'realtygraffic'		=> array(
			'w' => 200,
			'h' => 325,
			'styles' => array(
				'default' => array(
					'title' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'subtitle' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'text' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'border' => array(
						'bordercolor' => '#000000',
					),
				),
			),
		),
		'realtystatistic'	=> array(
			'w' => 200,
			'h' => 355,
			'styles' => array(
				'default' => array(
					'title' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'subtitle' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'text' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'border' => array(
						'bordercolor' => '#000000',
					),
				),
			),
		),
		'weather'		=> array(
			'w' => 190,
			'h' => 250,
			'styles' => array(
				'default' => array(
					'title' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'subtitle' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'text' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'border' => array(
						'bordercolor' => '#000000',
					),
				),
			),
		),
		'news'			=> array(
			'w' => 180,
			'h' => 343,
			'styles' => array(
				'default' => array(
					'title' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'subtitle' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'text' => array(
						'textcolor' => '#808080',
						'linkcolor' => '#404040',
						'backcolor' => '#ffffff',
					),
					'border' => array(
						'bordercolor' => '#000000',
					),
				),
			),
		),
	);
	
	static private $_allowed_templates = array(
		'widgets/informers/_css/default/realtygraffic',
		'widgets/informers/_css/default/realtystatistic',
	    'widgets/informers/_css/default/weather',
	);

	static private $_designs = array('default');

	static public function GetList()
	{
		return self::$_informers;
	}

	static public function GetTemplate($informer, $design = 'default')
	{
		if (!in_array($design, self::$_designs))
			return false;

		if (!array_key_exists($informer, self::$_informers))
			return false;

		return "widgets/informers/_css/".$design."/".$informer;
	}

	static public function GetDesigns()
	{
		return self::$_designs;
	}
	
	static public function GetAllowedTemplates()
	{
		return self::$_allowed_templates;
	}
}
?>