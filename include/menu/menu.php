<?php

LibFactory::GetStatic('arrays');

class Menu
{
	private $_fields = array(
		'menuid'	=> 'int',
		'sectionid'	=> 'int',
		'parentid'	=> 'int',
		'groupid'	=> 'int',
		'ord'		=> 'int',
		'name'		=> 'string',
		'link'		=> 'string',
		'isvisible' => 'bool',
		);

	private $_values = array();

	private $_cacheChildren = null;

	function __construct(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['menuid']) && Data::Is_Number($info['menuid']) )
			$this->_values["menuid"] = $info['menuid'];
		else 
			$this->_values["menuid"] = 0;

		foreach ($this->_fields as $key => $type)
		{
			switch ($type)
			{
				case 'int':
					$this->_values[$key] = intval($info[$key]);
					break;

				case 'string':
					$this->_values[$key] = stripslashes($info[$key]);
					break;

				case 'bool':
					$this->_values[$key] = $info[$key] ? true : false;
					break;
					
				default:
					$this->_values[$key] = $info[$key];
					break;
			}
		}
	}

	public function __get($name)
	{
		$name = strtolower($name);

		if ($name == 'id')
			return $this->_values['menuid'];
		
		if ($name == 'children')
		{
			if ($this->_cacheChildren !== null)
				return $this->_cacheChildren;

			$children = MenuMgr::getInstance()->GetChildren($this->_values["menuid"]);

			$this->_cacheChildren = $children;
			return $this->_cacheChildren;
		}

		if(isset($this->_values[$name]))
		{
			return $this->_values[$name];
		}

		return null;
	}

	public function __set($name, $value)
	{
		$name = strtolower($name);

		if (isset($this->_fields[$name]))
		{
			switch ($this->_fields[$name]) 
			{
				case 'int':
					$this->_values[$name] = (int)$value;
					break;

				case 'string':
					$this->_values[$name] = stripslashes($value);
					break;

				default:
					$this->_values[$name] = $value;
					break;
			}
		}
	}

	public function Update()
	{
		if ($this->_values['menuid'] === 0)
		{
			return  $this->_values["menuid"] = MenuMgr::getInstance()->AddMenu($this->_values);
		}
		else
		{
			return  MenuMgr::getInstance()->UpdateMenu($this->_values);
		}
	}

	public function Remove()
	{
		if  ($this->_values['menuid'] === 0)
			return false;

		$children = $this->Children;
		if (is_array($children) && count($children) > 0)
		{
			foreach($children as $child)
				$child->Remove();
			$this->_cacheChildren = null;
		}
		return MenuMgr::getInstance()->RemoveMenu($this->_values['menuid']);
	}
}
