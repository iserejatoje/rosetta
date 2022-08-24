<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_list_list extends Control_TemplateVirtualControl implements Control_IHeader
{
	/**
	 * Строки
	 * строка = array(номер столбца => элемент)
	 * элемент = данные (зависит от шаблона строки, все в шаблон уходит)
	 */
	public $items			= array();
	
	// информация о столбцах, сортируемость, сортировка по умолчанию, ширина
	private $columns		= array();

	private $header			= null;
	private $pager			= null;
	/**
	 * идентификаторы выбранных элементов
	 */
	private $selected;
	private $sortcolumn;
	private $sortcolumndefault;
	private $sortorder;
	private $sortorderdefault;
	
	private $selectmode;
	
	private $sortable;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'list_list');
		$this->SetTemplate('controls/list/list/default');
		$this->SetRowTemplate('controls/list/list/row');
	}
	
	public function Init($params)
	{
		parent::Init($params);
		
		$this->pager = ControlFactory::GetInstance('extend/pager', $this, array('id' => $this->GetID().'p'));
		$this->header = ControlFactory::GetInstance('extend/header', $this, array('id' => $this->GetID().'h'));
		
		if($this->GetVirtualMode())
		{
			$this->pager->SetSource($this->GetSource());
			$this->header->SetSource($this->GetSource());
		}
		
		$this->columns =& $this->header->GetHeaderStructRef();
		
		// вытаскиваем выбранные элементы, сделано не в методе, потому что надо накладывать поверх тех что пришло с запроса
		// а сделать это можно только заполнив сразу
		$this->selected = App::$Request->Request[$this->GetID().'_item']->AsArray(array(), Request::INTEGER_NUM);
	}
	
	function &GetHeaderStructRef()
	{
		return $this->columns;
	}
	
	public function SetSource($source)
	{
		if(is_a($source, 'Source_ISourceIterator'))
		{
			parent::SetSource($source);
			// ставим только в случае если сорс подходит листу, иначе нет смысла
			if($this->header !== null)
				$this->header->SetSource($source);
			if($this->pager !== null)
				$this->pager->SetSource($source);
			$this->SetVirtualMode(true);
		}
		else
		{
			parent::SetSource(null);
			$this->SetVirtualMode(false);
		}
	}

	/**
	 * 
	 * @param index
	 * @param item
	 */
	public function AddItem($index, $item)
	{
		if($this->GetVirtualMode()) // не заполняем
			return;
		$this->items[$index] = $item;
	}

	public function Draw()
	{
		$this->header->Render();
		$this->pager->Render();
		
		if($this->GetVirtualMode())
			$items = $this->GetSource();
		else
			$items = $this->items;
			
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'columns' => $this->columns,
				'items' => $items,			
				'header' => $this->header,
				'pager' => $this->pager),
			));
	}
	
	public function AddColumn($title, $field = '', $params = array())
	{
		if($this->header !== null)
			return $this->header->AddColumn($title, $field, $params);
			
		$item = array(
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
	
	public function GetRowTemplate()
	{
		return $this->GetTemplate('row');
	}
	
	public function SetRowTemplate($tpl)
	{
		$this->SetTemplate('row', $tpl);
	}
	
	public function GetColumnSortable($index)
	{
		if($this->header !== null)
			return $this->header->GetColumnSortable($index);
			
		if($index < count($this->columns))
			return $this->columns[$index]['sortable'];
		else
			return null;
	}
	
	public function GetSortable()
	{
		if($this->header !== null)
			return $this->header->GetSortable();
			
		return $this->sortable;
	}
	
	public function IsSelected($index)
	{
		return $this->selected[$index] === true;
	}
	
	public function SetColumnSortable($index, $sortable)
	{
		if($this->header !== null)
			return $this->header->SetColumnSortable($index, $sortable);
			
		if($index < count($this->columns))
			$this->columns[$index]['sortable'] = $sortable;
	}
	
	public function SetSortable($sortable)
	{
		if($this->header !== null)
			$this->header->SetSortable($sortable);
			
		if(is_bool($sortable))
			$this->sortable = $sortable;
	}

	/**
	 * 
	 * @param field
	 * @param value
	 */
	public function FindItem($field, $value)
	{
	}

	public function GetDefaultSortColumn()
	{
		if($this->header !== null)
			return $this->header->GetDefaultSortColumn();
			
		return $this->sortcolumndefault;
	}

	public function GetDefaultSortOrder()
	{
		if($this->header !== null)
			return $this->header->GetDefaultSortOrder();
			
		return $this->sortorderdefault;
	}

	public function GetHeader()
	{
		return $this->header;
	}

	/**
	 * 
	 * @param index
	 */
	public function GetItem($index)
	{
		return $this->items[$index];
	}

	public function GetPager()
	{
		return $this->pager;
	}

	public function GetSelectedIndex()
	{
		foreach($this->selected as $index => $selected)
			if($selected)
				return $index;
	}

	public function GetSelected()
	{
		return $this->selected;
	}

	public function GetSelectMode()
	{
		return $this->selectmode;
	}

	public function GetSortColumn()
	{
		if($this->header !== null)
			return $this->header->GetSortColumn();
			
		return $this->sortcolumn;
	}

	public function GetSortOrder()
	{
		if($this->header !== null)
			return $this->header->GetSortOrder();
			
		return $this->sortorder;
	}
	
	public function GetStateUrl($withprefix = true, $withother = false)
	{
		$url = array();
		if($this->header !== null)
			if($u = $this->header->GetStateUrl(false))
				$url[] = $u;
		if($this->pager !== null)
			if($u = $this->pager->GetStateUrl(false))
				$url[] = $u;
		if($withprefix)
			return '?'.implode('&', $url);
		else
			return implode('&', $url);
	}

	/**
	 * 
	 * @param index
	 * @param item
	 * @param indexbefore
	 */
	public function InsertItem($index, $item, $indexbefore = null)
	{
	}

	/**
	 * 
	 * @param index
	 */
	public function RemoveItem($index)
	{
	}

	/**
	 * 
	 * @param field
	 * @param order
	 */
	public function SetDefaultSort($column, $order)
	{
		if($this->header !== null)
			return $this->header->SetDefaultSort($column, $order);
			
		$this->sortcolumndefault = $column;
		$this->sortorderdefault = $order;
	}

	/**
	 * 
	 * @param header
	 */
	public function SetHeader($header)
	{
		if(is_a($header, 'Control_IControl') && is_a($header, 'Control_IHeader'))
			$this->header = $header;
	}

	/**
	 * 
	 * @param pager
	 */
	public function SetPager($pager)
	{
		if(is_a($pager, 'Control_IControl') && is_a($pager, 'Control_IPager'))
			$this->pager = $pager;
	}
	
	public function SetSelected($index, $selected = true)
	{
		if($this->selectmode == 'none')
			$this->selected = array();
		if(!is_bool($selected))
			return;
		if($this->selectmode == 'single')
			$this->selected = array($index => $selected);
		if($this->selectmode == 'multi')
			$this->selected[$index] = $selected;
	}

	/**
	 * none - не выбирается
	 * single - единичный выбор
	 * multi - множественный выбор
	 * 
	 * @param mode
	 */
	public function SetSelectMode($mode)
	{
		if(
			$mode == 'none' ||
			$mode == 'single' ||
			$mode == 'multi')
		$this->selectmode = $mode;
	}

	/**
	 * 
	 * @param field
	 * @param order
	 */
	public function SetSort($column, $order)
	{
		if($this->header !== null)
			$this->header->SetSort($columnm, $order);
		$this->sortcolumn = $column;
		$this->sortorder = $order;
	}
}
?>