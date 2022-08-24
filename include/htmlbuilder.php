<?
class lib_htmlbuilder
{
	private $stacktags = array();
	private $currtag = null;
	private $html;
	
	function OpenTag($name)
	{
		
	}
	
	function CloseTag($name)
	{
	}
	
	function Attr()
	{
	}
	
	function Text()
	{
	}
	
	function GetHTML()
	{
		return $this->html;
	}
}
?>