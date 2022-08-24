<?

class BL_system_provider_block extends BL_system_provider implements IBL_system_provider_data
{
	public function GetValue($name)
	{
		$name = explode(':', $name);
		
		if ( is_callable( array(ProxyBlock::$objects[ $name[0] ], 'GetPropertyByRef') ) )
			return ProxyBlock::$objects[$name[0]]->GetPropertyByRef($name[1]);
		else
			return null;
	}
}

?>
