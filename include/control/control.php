<?php
/**
 * Базовый класс элемента управления
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:52
 */
abstract class Control_Control implements Control_IControl
{

	private $height;
	private $id;
	private $name				= 'control';
	private $parent				= null;
	private $style				= null;
	private $css				= null;
	/**
	 * буфер рендеринга, если null, не отрендерен
	 */
	protected $renderbuffer		= null;
	private $title				= '';
	private $visible			= true;
	private $width;
	private $drawcontainer		= true;
	static private $counter 	= 1;

	function __construct($parent = null, $name = 'control')
	{
		$this->id = 'control'.self::$counter;
		self::$counter++;
		$this->name = $name;
		if($parent !== null)
			$this->SetParent($parent);
	}
	
	public function GetCSS()
	{
		return $this->css;
	}

	/**
	 * Получить высоту
	 */
	public function GetHeight()
	{
		return $this->height;
	}

	/**
	 * Получить идентификатор
	 */
	public function GetID()
	{
		return $this->id;
	}
	
	public function GetName()
	{
		return $this->name;
	}

	/**
	 * Получить родителя
	 */
	public function GetParent()
	{
		return $this->parent;
	}
	
	public function GetStateUrl($withprefix = true, $withother = false)
	{
		return '';
	}

	public function GetStyle()
	{
		// Отдается совместный стильник, генерный и кастомный
		$style = $this->style;
		if(!empty($this->height))
			$style['height'] = $this->height;
		if(!empty($this->width))
			$style['width'] = $this->width;
		if(count($style) == 0)
			return null;
		if(count($style))
		{
			$_style=array();
			foreach($style as $k=>$v)
				$_style[] = $k.':'.$v;
			return implode(';',$_style);
		}
	}

	/**
	 * Получить заголовок
	 */
	public function GetTitle()
	{
		return $this->title;
	}

	/**
	 * Получить видимость
	 */
	public function GetVisible()
	{
		return $this->visible;
	}

	/**
	 * Получить ширину
	 */
	public function GetWidth()
	{
		return $this->width;
	}

	/**
	 * 
	 * @param params
	 */
	public function Init($params)
	{
		if(isset($params['height']) && is_string($params['height']))			$this->height 	= $params['height'];
		if(isset($params['width']) && is_string($params['width']))				$this->width 	= $params['width'];
		if(isset($params['id']) && is_string($params['id']))					$this->id	 	= $params['id'];
		if(isset($params['title']) && is_string($params['title']))				$this->title 	= $params['title'];
		if(isset($params['parent']) && is_a($params['parent'], 'IControl'))		$this->parent 	= $params['parent'];
		if(isset($params['visible']) && is_bool($params['visible']))			$this->visible 	= $params['visible'];
	}

	public function Render()
	{
		global $OBJECTS;
		
		if($this->css !== null && isset($OBJECTS['title']))
			$OBJECTS['title']->AddStyle($this->css);
		
		$this->PreRender();
		if($this->visible === true && $this->renderbuffer === null)
			$this->renderbuffer = $this->RenderContainer($this->Draw());
			
		return $this->renderbuffer;
	}
	
	// рендерит рамку вокруг контрола исходя из базовых параметров
	private function RenderContainer($html)
	{
		// сейчас реализация только в шаблоне для элементов управления на базе шаблонов
		return $html;
	}
	
	public function PreRender()
	{
	}
	
	public function SetCSS($css)
	{
		if(is_string($css) || $css == null)
			$this->css = $css;
	}

	/**
	 * 
	 * @param height
	 */
	public function SetHeight($height)
	{
		if(is_string($height) || is_numeric($height) || $height == null)
			$this->height = $height;
	}

	/**
	 * 
	 * @param id
	 */
	public function SetID($id)
	{
		if(is_string($id))
			$this->id = $id;
	}

	/**
	 * 
	 * @param parent
	 */
	public function SetParent($parent)
	{
		if(is_a($parent, 'Control_IControl'))
			$this->parent = $parent;
	}

	public function SetStyle($name, $value)
	{
		if(is_string($name) && (is_string($value) || is_numeric($title)))
			$this->style[$name] = $value;
	}

	/**
	 * 
	 * @param title
	 */
	public function SetTitle($title)
	{
		if(is_string($title) || is_numeric($title))
			$this->title = $title;
	}

	/**
	 * 
	 * @param visible
	 */
	public function SetVisible($visible)
	{
		if(is_bool($visible))
			$this->visible = $visible;
	}

	/**
	 * 
	 * @param width
	 */
	public function SetWidth($width)
	{
		if(is_string($width) || is_numeric($width) || $width == null)
			$this->width = $width;
	}
	
	public function GetDrawContainer()
	{
		return $this->drawcontainer;
	}
	
	public function SetDrawContainer($draw)
	{
		if(is_bool($draw))
			$this->drawcontainer = $draw;
	}
	
	private $custom = array();
	public function SetCustomParam($name, $value)
	{
		$this->custom[$name] = $value;
	}
	
	public function GetCustomParam($name)
	{
		return $this->custom[$name];
	}
}
?>