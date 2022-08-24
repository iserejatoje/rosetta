<?php

/**
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:51
 */
class Control_extend_path extends Control_TemplateVirtualControl
{

	private $items			= array();

	function __construct($parent = null)
	{
		parent::__construct($parent, 'extend_path');
		$this->SetTemplate('controls/extend/path/default');
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this->this,
			'private' => array(
				'items' => $this->items),
			));
	}
	
	public function PreRender()
	{

	}
	
	public function AppendBefore($title, $url)
	{
		$item = array(
			'title' => $title,
			'url' => $url,
		);
		
		array_unshift($this->items, $item);
	}
	
	public function AppendAfter($title, $url)
	{
		$item = array(
			'title' => $title,
			'url' => $url,
		);
		
		array_push($this->items, $item);
	}
	
	protected function ResetCache()
	{
		$this->pages = null;
		$this->renderbuffer = null;
	}
	
	private function Fill()
	{
		foreach($this->GetSource() as $i)
		{
			$this->AppendAfter($i['title'], $i['url']);
		}
	}
	
	public function GetStateUrl($withprefix = true, $withother = false)
	{
		if($withother === false)
		{
			if($withprefix)
				return '?';
			else
				return '';
		}
		else
		{
			$link = App::$Request->Get->GetUrl(array(), false);
			if(strpos($link, '?') !== null)
				$link.= '&';
			else
				$lint.= '?';
			if($withprefix === false)
			{
				if(strpos($link, '?') !== false)
					$link = substr($link, 1);
			}
			return $link;
		}
	}
	
	public function SetSource($source)
	{
		
		if(is_a($source, 'Source_ISourceIterator'))
		{
			parent::SetSource($source);
			$this->SetVirtualMode(true);
			$this->Fill();
		}
		else
		{
			parent::SetSource(null);
			$this->SetVirtualMode(false);
		}
	}
}
?>