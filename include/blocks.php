<?

//2do: переделать все блоки такого типа на виджеты


class Blocks
{
	static function GetBlock($block, $template, $lifetime, $params)
	{
		global $CONFIG, $DCONFIG, $OBJECTS;
		switch($block)
		{
			case "banner":
				return self::_GetBanner($params);
			case "template":
				return self::_GetTemplate($block, $template, $lifetime, $params);
		}
		
	}
	
	/**
	 * добавление баннера
	 * @param array $params параметры (id - идентификатор (обязателен), withtext - с текстовой строкой, page - таргетинг)
	 */
	static function _GetBanner($_params)
	{
		global $CONFIG, $DCONFIG, $OBJECTS;
		
		$_params['id'] = preg_replace("@[^\d]+@", "", $_params['id']);
		$styles = "text-align: center;";
		$params = array();
		$params['version'] = 2;
		// VISIBLE
		if(isset($_params['visible']))
			if($_params['visible'] == false || $_params['visible'] == 0)
				$styles.= "display:none;";
		// WIDTH
		if(!empty($_params['width'])){
			if(preg_match("@\d$@", $_params['width'])) $_params['width'].= "px";
			$styles.= "width:".$_params['width'].";";
		}
		// HEIGHT
		if(!empty($_params['height'])){
			if(preg_match("@\d$@", $_params['height'])) $_params['height'].= "px";
			$styles.= "height:".$_params['height'].";";
		}
		// TEXT
		if($_params['text'] == true || $_params['text'] == 1)
			$params['withText'] = "1";
		// PAGE
		if(!empty($_params['page']))
			$params['page'] = $_params['page'];
		// TYPE
		if(in_array($_params['type'], array("single", "multi")))
			$params['type'] = $_params['type'];
		// VERSION
		if( isset($_params['version']) && in_array($_params['version'], array(1, 2)) )
			$params['version'] = $_params['version'];
		
		if( $params['version'] == 1 )
		{
			$text = "<script language=\"javascript\" type=\"text/javascript\" src=\"".self::GetPath()."?c=".$_params['id'].(isset($params['page'])?"&amp;".$params['page']:"")."\"></script>";
		}
		else
		{
			$text = "<div class=\"surbis_banner\" id=\"sb_".$_params['id']."\"".($styles!=""?" style=\"".$styles."\"":"").">";
			if(count($params)>0)
				foreach ($params as $k=>$v)
					$text.= "<p class=\"".$k."\" style=\"display:none;\">".$v."</p>";
			$text.= "</div>";
		}
		unset($params); unset($id); unset($_params); unset($styles);
		return $text;
	}
	
	
	static private $path = null;
	
	static private function GetPath()
	{
		if( self::$path === null  )
		{
			LibFactory::GetStatic('rand');
			self::$path = Rand::RandStrByRule(Rand::$Rules['banner_single']);
		}
		return self::$path;
	}

	
	/**
	 * обработка шблона
	 * @param string $block имя блока (используется для кеша)
	 * @param string $template шаблон
	 * @param integer $lifetime время кеширования
	 * @param array $params параметры
	 */
	static function _GetTemplate($block, $template, $lifetime, $params)
	{
		global $CONFIG, $DCONFIG, $OBJECTS;
		
		if( isset($OBJECTS['smarty']) && is_object($OBJECTS['smarty']) )
			$tpl = $OBJECTS['smarty'];
		else if( isset($DCONFIG['smarty']) && is_object($DCONFIG['smarty']) )
			$tpl = $DCONFIG['smarty'];
		else
			return "";
		
		if(isset($params['cache']) && $params['cache'])
		{
			$cacheid = $block;
			if(!$tpl->is_cached($template, $cacheid))
				$tpl->assign_by_ref('params', $params);
			$tpl->cache_lifetime = $lifetime;
			return $tpl->fetch($template, $cacheid);
		}
		else
		{
			$oc = $tpl->caching;
			$tpl->caching = 0;
			$tpl->assign_by_ref('params', $params);
			$html = $tpl->fetch($template);
			$tpl->caching = $oc;
			return $html;
		}
	}
}

?>
