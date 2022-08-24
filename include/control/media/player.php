<?
class Control_media_player extends IControl
{
	const MODE_CUSTOM		= 0;
	const MODE_VIDEO		= 1;
	const MODE_AUDIO		= 2;
	
	protected $lib;						// библиотека
	
	protected $container = null;
	protected $media = '';				// имя медиафайла
	protected $mediaid = null;			// идентификатор медиафайла, если указан, media будет установлен из бд
	protected $mode = null;				// режим работы
	protected $splash = null;			// картинка, показываемая пока плейер не загружен
	protected $autoplay = false;		// начинать проигрование после автоматически
	
	public function Init($params)
	{
		$this->id = 'player';
		parent::Init($params);
		$this->lib = LibFactory::GetInstance('multimedia');
		$this->mode = self::MODE_VIDEO;
		
		if(isset($params['media']))			$this->media 						= $params['media'];
		if(isset($params['mode']))			$this->mode 						= $params['mode'];
		if(isset($params['skin']))			$this->skin 						= $params['skin'];
	}
	
	protected function GetHTMLCode()
	{
		$html = $this->lib->GetHTMLCode($this->MediaID, array(
			'id' => $this->ID,
			'width' => $this->size['width'],
			'height' => $this->size['height'],
			'splash' => $this->Splash,
			'media' => $this->Media,
			'mediaid' => $this->MediaID,
			'mode' => $this->Mode,
			'autoplay' => $this->Autoplay,			
		));
		return $html;
	}

	public function Render()
	{
		global $OBJECTS, $CONFIG;
		
		/*$html = $this->lib->GetHTMLCode($this->MediaID, array(
			'id' => $this->ID,
			'width' => $this->size['width'],
			'height' => $this->size['height'],
			'splash' => $this->Splash,
			'media' => $this->Media,
			'mode' => $this->Mode,
			'autoplay' => $this->Autoplay,			
		));
		
		return $html;*/
		$html = '';
		if(isset($OBJECTS['title']))
			$OBJECTS['title']->AddScript($this->lib->config['url']['jsapi']);
		else
			$html = '<script type="text/javascript" language="javascript" src="'.$this->lib->config['url']['jsapi'].'"></script>';
		
		$html.= '<div';
		
		// стиль оформелиня (размеры)
		$html.= ' style="background-color:black;text-align:center;cursor:pointer;cursor:hand;display:block;';
		
		if($this->splash != null)
			$html.= 'background-image:url('.$this->splash.');background-position: center;background-repeat: no-repeat;';
		
		$html.= $this->CSSSize.'"';
		
		// идентификатор плейера
		$html.= ' '.$this->ATTRID;
		$html.= '>';
		if($this->splash != null)
		{
			$padding = floor(($this->size['height'] - 83) / 2);
			$html.= '<div style="padding-top:'.$padding.'"><img src="/_img/themes/players/flowplayer/play_large.png"></div>';
		}
		$html.= '</div>';
		
		// создание объекта плейера
		$html.= '<script language="JavaScript">$f("'.$this->id.'", "'.$this->lib->config['url']['player'].'"';
			$html.= ','.$this->GetConfig().'';
		$html.= ');</script>';
		
		return $html;
	}
	
	protected function GetConfig()
	{
		global $OBJECTS, $CONFIG;
		$flv = $this->lib->GetMediaUrl($this->media, $this->mode);

		
		$params = array(
			'clip' => array(
				'url' => $flv,
				'autoPlay' => $this->autoplay || $this->splash != null,
			),
			'plugins' => array(
				'controls' => array(
					'url' => $this->lib->config['url']['controls'],
				),
			),
		);
		
		include_once $CONFIG['engine_path']."include/json.php";
		$json = new Services_JSON();
		$json->charset = 'WINDOWS-1251';
		
		return $json->encode($params);
	}
	
	public function __get($name)
	{
		$name = strtolower($name);
		
		switch($name)
		{
		case 'autoplay':
			return $this->autoplay;
		case 'splash':
			return $this->splash;
		case 'mode':
			return $this->mode;
		case 'media':
			return $this->media;
		case 'mediaid':
			return $this->mediaid;
		case 'htmlcode':
			return $this->GetHTMLCode();
		}
		return parent::__get($name);
	}
	
	public function __set($name, $value)
	{
		$name = strtolower($name);
		
		switch($name)
		{
		case 'mode':
			if($value != self::MODE_CUSTOM && $value != self::MODE_VIDEO && $value != self::MODE_AUDIO)
				break;
			$this->mode = $value;
			break;
		case 'media':
			$this->media = $value;
			break;
		case 'autoplay':
			$this->autoplay = $value;
			break;
		case 'splash':
			$this->splash = $value;
			break;
		case 'mediaid':
			if(!is_numeric($value))
				break;
			$file = $this->lib->GetFile($value);
			if($file === null)
				break;
			$this->mediaid = $value;
			$this->media = $file['Path'];
			$this->mode = $file['Type'];
			
			break;
		}
		parent::__set($name, $value);
	}
}
?>