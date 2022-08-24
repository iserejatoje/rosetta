<?

class SphinxXMLFeed extends XMLWriter
{
    private $fields = array();
    private $attributes = array();
    protected $kill_list = array();

    public function __construct($options = array())
    {
        $defaults = array(
            'indent' => false,
        );
        $options = array_merge($defaults, $options);

        
        // Store the xml tree in memory
        $this->openMemory();

        if ($options['indent'])
        {
            $this->setIndent(true);
        }
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
	
	public function getFields()
    {
        return $this->fields;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function addKillList($kill_list)
    {
        $this->kill_list = $kill_list;
    }

    public function addDocument($id, $doc, $keys)
    {
        $this->startElement('sphinx:document');
        $this->writeAttribute('id', $id);

        array_map(array($this, 'writeElement'), $keys, $doc);
        $this->endElement();
    }
	
    public function beginOutput()
    {
        $this->startDocument('1.0', 'UTF-8');
        $this->startElement('sphinx:docset');
        $this->startElement('sphinx:schema');


        // add fields to the schema
        foreach ($this->fields as $field)
        {
            $this->startElement('sphinx:field');
            $this->writeAttribute('name', $field);
            $this->endElement();
        }


        // add attributes to the schema
        foreach ($this->attributes as $attributes)
        {
            $this->startElement('sphinx:attr');
            foreach ($attributes as $key => $value)
            {
                $this->writeAttribute($key, $value);
            }
            $this->endElement();
        }


        // end sphinx:schema
        $this->endElement();
        print $this->outputMemory();
    }

    public function endOutput()
    {
        // add kill list
        if (!empty($this->kill_list))
        {

            $this->startElement('sphinx:killlist');
            foreach ($this->kill_list as $id)
            {
                $this->writeElement("id", $id);
            }
            $this->endElement();
        }


        // end sphinx:docset
        $this->endElement();
        print $this->outputMemory();
    }
}