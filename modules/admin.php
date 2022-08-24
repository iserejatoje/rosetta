<?
/**
 * Модуль Admin.
 *
 */

class Mod_Admin extends AMultiFileModule_Magic
{
    protected $_page = 'default';
    
    public function __construct()
    {
        parent::__construct('admin');
    }

    public function Init($params = array())
    {
		global $OBJECTS;		
    }
}

?>