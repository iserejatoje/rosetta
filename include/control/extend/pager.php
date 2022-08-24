<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_extend_pager extends Control_TemplateVirtualControl
{

	private $defaultpage			= 1;
	private $itemsperpage			= 20;
	private $maxpage				= 1;
	private $page					= null;
	private $pagesperpager			= 10;
	private $type					= 'page';
	private $link					= null;
	private $showonepage			= true;
	private $pages					= null;

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_pager');
		$this->SetTemplate('controls/extend/pager/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this,
			'private' => array(
				'pages' => $this->GeneratePagesArray()),
			));
	}
	
	public function PreRender()
	{
		$page = $this->GetPage();
		if($page > $this->GetMaxPage())
			$page = $this->GetMaxPage();
		
		if($page < 1)
			$page = 1;
			
		if($this->page != $page)
		{
			$this->page = $page;
		}
		
		// инициализируем сорс
		if($this->GetVirtualMode())
			$this->GetSource()->setlimit(($this->page - 1) * $this->itemsperpage, $this->itemsperpage);
	}
	
	protected function ResetCache()
	{
		$this->pages = null;
		$this->renderbuffer = null;
	}
	
	private function GeneratePagesArray()
	{
		if($this->pages !== null)
			return $this->pages;
			
		if($this->link !== null)
			$link = $this->link;
		else
			$link = App::$Request->Get->GetUrl(array($this->GetID().'_page'), false);
		
		$link.= '&'.$this->GetID().'_page=@p@';
			
		$this->pages = array();
		
		$this->pages['back'] = "";
		$this->pages['next'] = "";
		$this->pages['btn'] = array();
		$this->pages['current'] = str_replace("@p@", $this->page, $link);
		
		$this->pages['pages'] = array();
		
		$maxpage = $this->GetMaxPage();
		
		if($maxpage > 1 || $this->showonepage)
		{
			// определим границы блока страниц
			if($maxpage > $this->pagesperpager)
			{
				$pbegin = 1;
				$pend = $this->pagesperpager;
				
				$lblock = floor($this->pagesperpager / 2);
				$rblock = $this->pagesperpager - $lblock - 1;
				
				if($this->page <= $lblock)
				{
					$pbegin = 1;
					$pend = $this->pagesperpager;
				}
				elseif($maxpage - $this->page <= $rblock)
				{
					$pend = $maxpage;
					$pbegin = $maxpage - $this->pagesperpager + 1;
				}
				else
				{
					$pbegin = $this->page - $lblock;
					$pend = $this->page + $rblock;
				}
			}
			else
			{
				$pbegin = 1;
				$pend = $maxpage;
			}
			
			if ($this->page <> 1)
			{
				$this->pages['back'] = str_replace("@p@", $this->page - 1, $link);
				$this->pages['first'] = str_replace("@p@", 1, $link);
			}
			if ($this->page <> $maxpage)
			{
				$this->pages['next'] = str_replace("@p@", $this->page + 1, $link);
				$this->pages['last'] = str_replace("@p@", $maxpage, $link);
			}
			
			for($i = $pbegin; $i <= $pend; $i++)
			{
				$pl_start = ($this->itemsperpage * ($i - 1)) + 1;
				$pl_end = $this->itemsperpage * $i;
				if ($this->type == 'items')
					$this->pages['btn'][$i]["text"] = $pl_start."-".$pl_end;
				else
					$this->pages['btn'][$i]["text"] = $i;
				$this->pages['btn'][$i]["link"] = str_replace("@p@", $i, $link);
				if ($i == $this->page)
					$this->pages['btn'][$i]["active"] = 1;
				else
					$this->pages['btn'][$i]["active"] = 0;
			}
		}

		return $this->pages;
	}
	
	public function SetSource($source)
	{
		
		if(is_a($source, 'Source_ISourceCountable') && is_a($source, 'Source_ISourceLimitable'))
		{
			parent::SetSource($source);
			$this->SetVirtualMode(true);
		}
		else
		{
			parent::SetSource(null);
			$this->SetVirtualMode(false);
		}
	}

	/**
	 * получить страницу по умолчанию
	 */
	public function GetDefaultPage()
	{
		return $this->defaultpage;
	}

	public function GetItemsPerPage()
	{
		return $this->itemsperpage;
	}
	
	public function GetLink()
	{
		return $this->link;
	}

	public function GetMaxPage()
	{
		if($this->GetVirtualMode())
		{
			return ceil(count($this->GetSource()) / $this->itemsperpage);
		}
		else
			return $this->maxpage;
	}

	/**
	 * получить текущую страницу
	 */
	public function GetPage()
	{
		if($this->page === null)
		{
			if(isset(App::$Request->Get[$this->GetID().'_page']))
				$this->page = App::$Request->Get[$this->GetID().'_page']->Int(1);
			else
				$this->page = $this->defaultpage;
		}
		return $this->page;
	}

	public function GetPagesPerPager()
	{
		return $this->pagesperpager;
	}
	
	public function GetStateUrl($withprefix = true, $withother = false)
	{
		if($withother === false)
		{
			$url = $this->GetID().'_page='.$this->GetPage();
			
			if($withprefix)
				return '?'.$url;
			else
				return $url;
		}
		else
		{
			$link = App::$Request->Get->GetUrl(array($this->GetID().'_page'), false);
			if(strpos($link, '?') !== null)
				$link.= '&';
			else
				$lint.= '?';
			$link.= $this->GetID().'_page='.$this->GetPage();
			if($withprefix === false)
			{
				if(strpos($link, '?'))
					$link = substr($link, 1);
			}
			return $link;
		}
	}

	public function GetType()
	{
		return $this->type;
	}
	
	public function GetItemsCount()
	{
		if($this->GetVirtualMode())
			return $this->GetSource()->count();
		else
			return false;
	}

	/**
	 * Установить страницу по умолчанию (если не пришла в GET запросе)
	 * 
	 * @param page
	 */
	public function SetDefaultPage($page)
	{
		if(is_numeric($page))
		{
			$this->defaultpage = $page;
			$this->ResetCache();
		}
	}

	/**
	 * 
	 * @param itemsperpage
	 */
	public function SetItemsPerPage($itemsperpage)
	{
		if(is_numeric($itemsperpage))
		{
			$this->itemsperpage = $itemsperpage;
			$this->ResetCache();
		}
	}
	
	/**
	 * 
	 * @param link
	 */
	public function SetLink($link = null)
	{
		if($link === null || is_string($link))
		{
			$this->link = $link;
			$this->ResetCache();
		}
	}

	/**
	 * 
	 * @param maxpage
	 */
	public function SetMaxPage($maxpage)
	{
		if($this->GetVirtualMode())
			return;
			
		if(is_numeric($maxpage))
		{
			$this->maxpage = $maxpage;
			$this->ResetCache();
		}
	}

	/**
	 * Установить номер страницы, игнорируя GET запрос
	 * 
	 * @param page
	 */
	public function SetPage($page)
	{
		if(is_numeric($page))
		{
			$this->page = $page;
			$this->ResetCache();
		}
	}

	/**
	 * 
	 * @param pagesperpager
	 */
	public function SetPagesPerPager($pagesperpager)
	{
		if(is_numeric($pagesperpager))
		{
			$this->pagesperpager = $pagesperpager;
			$this->ResetCache();
		}
	}

	/**
	 * page - номера страниц: 1, 2, 3
	 * items - диаппазон элементов: 1-10, 11-20, 21-25
	 * input - ручной ввод: <поле ввода страницы> из 3 страницы
	 * 
	 * @param type
	 */
	public function SetType($type)
	{
		if($type == 'page' || $type == 'items'/* || $type == 'input'*/)
		{
			$this->type = $type;
			$this->ResetCache();
		}
	}

}
?>