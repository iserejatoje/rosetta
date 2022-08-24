<?
if($template === null)
	$template = $this->_config['templates']['menu_left'];
	
$params['page'] = $this->_page;
$params['params'] = $this->_params;

if (strpos($this->_page, 'profile') !== 0) {

	$params['menu'] = $this->_config['mypages'];
	$params['menu']['gallery'] = array(
		'url' => '/user/'.App::$User->ID.'/gallery/',
		'name' => 'Моя фотогалерея',
	);
	
	$params['menu']['blogs'] = array(
		'url' => '/user/'.App::$User->ID.'/blogs/new.php',
		'name' => 'Мой блог',
	);

	$cacheid = 'blockmenuleft_'.$this->_page.'_'.App::$CurrentEnv['site']['tree_id'];
	
	$advanced_menu = false;
	if (!($this->_cache === null || $_GET['nocache'] >= 12))
		$advanced_menu = $this->_cache->get($cacheid);

	if ($advanced_menu === false) {
		$advanced_menu = array(
			'forum_magic' => array(
				'url' => 'selected.php',
				'name' => 'Мои форумы',
			),
			'job_magic' => array(
				'url' => 'my/vacancy.php',
				'name' => 'Моя работа',
				'istitle'=> true,
				'path' => '/job/',
			),
			'realty' => array(
				'url' => 'my.php',
				'name' => 'Моя недвижимость',
			),
			'car' => array(
				'url' => 'my.php',
				'name' => 'Мои авто',
			),
		);
		foreach($advanced_menu as $key => $value) {
		
			if ($value['path']) {
				$advanced_menu[$key]['url'] = $value['path'].$value['url'];				
				if ($value['istitle']) {
					$advanced_menu[$key]['url'] = App::$Protocol . App::$CurrentEnv['site']['regdomain'].$advanced_menu[$key]['url'];
				}
			} else {
		
				$it = STreeMgr::Iterator(array(
					'type'		=> 2,
					'visible'	=> 1,
					'deleted'	=> 0,
					'regions' 	=> App::$CurrentEnv['regid'],
					'module'	=> $key
				));

				if ($it->count() == 1 && ($node = $it->current()) != false) {
					$advanced_menu[$key]['url'] = ModuleFactory::GetLinkBySectionId($node->ID).$value['url'];
				} else if ($it->count() > 1) {
					foreach($it as $node) {
						if (empty($node))
							continue ;
					
						if (App::$CurrentEnv['site']['tree_id'] == $node->Parent->ID) {
							break ;
						}
					}
					
					if (!empty($node))
						$advanced_menu[$key]['url'] = ModuleFactory::GetLinkBySectionId($node->ID).$value['url'];
					else
						unset($advanced_menu[$key]);
				} else {
					unset($advanced_menu[$key]);
				}
			}
		}

		if ($this->_cache !== null)
			$this->_cache->set($cacheid, $advanced_menu, 0);
	}

	$params['menu'] = array_merge($params['menu'], $advanced_menu);
}

return $this->RenderBlock($template, $params, null);
?>