<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:50
 */
class Control_extend_header extends Control_TemplateVirtualControl implements Control_IHeader
{

	/**
	 * индексы
	 * name - имя столбца
	 * field - поле данных столбца
	 * title - заголовок столбца
	 * sortable - возможномсть сортировки
	 * defaultorder - сортировка по умолчанию для поля, при клике по полю без сортировки выставится эта
	 */
	private $columns				= array();
	private $sortcolumn				= null;
	private $sortcolumndefault		= 0;
	
	// 0 - ASC 1 - DESC
	private $sortorder				= null;
	private $sortorderdefault		= 0;
	
	private $sortable				= true;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_header');
		$this->SetTemplate('controls/extend/header/default');
		
		if($this->GetParent() !== null)
			$this->SetDrawContainer(false);
	}
	
	function &GetHeaderStructRef()
	{
		return $this->columns;
	}

	/**
	 * 
	 * @param title
	 * @param field
	 */
	public function AddColumn($title, $field = '', $params = array())
	{
		if(is_string($title) && is_string($field))
		{
			$item = array(
				'title' => $title, 
				'field' => $field);
				
			if(is_bool($params['sortable']))
				$item['sortable'] = $params['sortable'];
			else
				$item['sortable'] = true;
				
			if($params['defaultorder'] == 0 || $params['defaultorder'] == 1)
				$item['defaultorder'] = intval($params['defaultorder']);
			else
				$item['defaultorder'] = 0;
				
			if(is_string($params['width']))
				$item['width'] = $params['width'];
				
			if(is_string($params['href']))
				$item['href'] = $params['href'];
				
			return array_push($this->columns, $item) - 1;			
		}
		return null;
	}
	
	public function PreRender()
	{
		if($this->sortable)
		{
			// ссылки сортировки
			foreach($this->columns as $k => $v)
			{
				if($v['sortable'] === true)
				{
					if($this->GetSortColumn() == $k)
					{
						// инверченный порядок
						$url = App::$Request->Get->GetUrl(array($this->GetID().'_scol', $this->GetID().'_sord'), false);
						$url.= '&'.$this->GetID().'_scol='.$k;
						$url.= '&'.$this->GetID().'_sord='.(1 - $this->GetSortOrder());
					}
					else
					{
						$url = App::$Request->Get->GetUrl(array($this->GetID().'_scol', $this->GetID().'_sord'), false);
						$url.= '&'.$this->GetID().'_scol='.$k;
						$url.= '&'.$this->GetID().'_sord='.$v['defaultorder'];
					}
					$this->columns[$k]['url'] = $url;
				}
			}
		}
		
		if($this->GetVirtualMode())
			$this->GetSource()->setsort($this->columns[$this->GetSortColumn()]['field'], $this->GetSortOrder()?'DESC':'ASC');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'columns' => $this->columns,
				'standalone' => $this->GetParent() === null)
			));
	}
	
	public function GetStateUrl($withprefix = true, $withother = false)
	{
		$url = $this->GetID().'_scol='.$this->GetSortColumn().'&'.$this->GetID().'_sord='.$this->GetSortOrder();
		
		if($withprefix)
			return '?'.$url;
		else
			return $url;
	}
	
	public function SetSource($source)
	{
		
		if(is_a($source, 'Source_ISourceSortable'))
		{
			parent::SetSource($source);
			$this->SetVirtualMode(true);
			if(is_a($source, 'Source_ISourceHeaderInfo'))
				$this->FillHeader();
		}
		else
		{
			parent::SetSource(null);
			$this->SetVirtualMode(false);
		}
	}
	
	private function FillHeader()
	{
		$hi = $this->GetSource()->getheaderinfo();
		foreach($hi as $h)
		{
			$this->AddColumn($h['title'], $h['field'], $h['params']);
		}
	}

	public function GetDefaultSortColumn()
	{
		return $this->sortcolumndefault;
	}

	public function GetDefaultSortOrder()
	{
		return $this->sortorderdefault;
	}

	/**
	 * 
	 * @param name
	 */
	public function GetColumnSortable($index)
	{
		if($index < count($this->columns))
			return $this->columns[$index]['sortable'];
		else
			return null;
	}

	/**
	 * 
	 * @param name
	 */
	public function GetColumnTitle($index)
	{
		if($index < count($this->columns))
			return $this->columns[$index]['title'];
		else
			return null;
	}
	
	public function GetColumnField($index)
	{
		if($index < count($this->columns))
			return $this->columns[$index]['field'];
		else
			return null;
	}

	/**
	 * 
	 * @param index
	 */
	public function GetColumn($index)
	{
		if($index < count($this->columns))
			return $this->columns[$index];
		else
			return null;
	}
	
	public function GetSortable()
	{
		return $this->sortable;
	}

	public function GetSortColumn()
	{
		if($this->sortcolumn === null)
		{
			if(isset(App::$Request->Get[$this->GetID().'_scol']))
				$this->sortcolumn = App::$Request->Get[$this->GetID().'_scol']->Int(0);
			else
				$this->sortcolumn = $this->sortcolumndefault;
		}
		return $this->sortcolumn;
	}

	public function GetSortOrder()
	{
		if($this->sortorder === null)
		{
			if(isset(App::$Request->Get[$this->GetID().'_sord']))
				$this->sortorder = App::$Request->Get[$this->GetID().'_sord']->Int(0);
			else
				$this->sortorder = $this->sortorderdefault;
		}
		return $this->sortorder;
	}

	/**
	 * 
	 * @param index
	 */
	public function RemoveColumn($index)
	{
		if($index < count($this->columns))
			unset($this->columns[$index]);
	}

	/**
	 * 
	 * @param field
	 * @param order
	 */
	public function SetDefaultSort($index, $order)
	{
		$this->sortcolumndefault = $index;
		$this->sortorderdefault = $order;
	}

	public function SetColumnSortable($index, $sortable)
	{
		if($index < count($this->columns))
			$this->columns[$index]['sortable'] = $sortable;
	}

	public function SetColumnTitle($index, $title)
	{
		if($index < count($this->columns))
			$this->columns[$index]['title'] = $title;
	}

	public function SetSort($index, $order)
	{
		$this->sortcolumn = $index;
		$this->sortorder = $order;
	}
	
	public function SetSortable($sortable)
	{
		if(is_bool($sortable))
			$this->sortable = $sortable;
	}
}
?>