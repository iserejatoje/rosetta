<?

class Review
{
	private $_mgr;

	public $ID;
	public $SectionID;
	public $Created;
	public $LastUpdated;
	public $Username;
	public $Surname;
	public $Title;
	public $Phone;
	public $Text;
	public $AnswerText;
	public $Email;
	public $IsVisible;

	private $Avatar;
	private $Author;

	private $_images_dir = '/common_fs/i/reviews/';
	private $_images_url = '/resources/fs/i/reviews/';

	private $avatar_size = array('max_width' => 59, 'max_height' => 57);

	private $avatar_file_size = 2097152; //2M
	private $file_size = 2097152; // 2M

	function __construct(array $info)
	{
		global $OBJECTS;

		$info = array_change_key_case($info, CASE_LOWER);

		if ( isset($info['reviewid']) && Data::Is_Number($info['reviewid']) )
			$this->ID = $info['reviewid'];

		$this->Author		= $info['author'];
		$this->Username		= $info['username'];
		$this->Surname		= $info['surname'];
		$this->SectionID	= (int)$info['sectionid'];
		$this->Created		= $info['created'];
		$this->LastUpdated	= $info['lastupdated'];
		$this->Title		= $info['title'];
		$this->Phone		= $info['phone'];
		$this->Text			= $info['text'];
		$this->AnswerText	= $info['answertext'];
		$this->Avatar		= $info['avatar'];
		$this->Email		= $info['email'];
		$this->IsVisible	= $info['isvisible']  ? true : false;
	}

	/**
	 * сохранить информацию в базе
	 * использует метод плагина и метод EShopMgr
	 */
	public function Update()
	{
		$info = array(
			'Author'     => $this->Author,
			'Username'   => $this->Username,
			'Surname'    => $this->Surname,
			'SectionID'  => $this->SectionID,
			'Title'      => $this->Title,
			'Avatar'     => $this->Avatar,
			'Phone'      => $this->Phone,
			'IsVisible'  => (int) $this->IsVisible,
			'Text'       => $this->Text,
			'AnswerText' => $this->AnswerText,
			'Email'      => $this->Email,
		);

		if ( $this->ID !== null )
		{
			$info['ReviewID'] = $this->ID;
			if (ReviewMgr::getInstance()->Update($info) !== false)
				return true;
		}
		else if ( ($new_id = ReviewMgr::getInstance()->Add($info)) !== false)
		{
			$this->ID = $new_id;
			return $new_id;
		}

		return false;
	}

	private function _deleteAvatar()
	{
		return $this->_deleteFile($this->Avatar);
	}

	private function _deleteFile($image_string)
	{
		try
		{
			if( ($img_obj = FileStore::ObjectFromString($image_string)) !== false )
			{
				$del_file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
				if (FileStore::IsFile($del_file))
					return FileStore::Delete_NEW($del_file);
			}
		}
		catch(MyException $e) { }
		return false;
	}


	public function UploadAvatar()
	{
		return $this->_uploadFile('Avatar', '_avatar');
	}

	private function _uploadFile($fieldName, $postfix)
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');

		if (empty($_FILES[$fieldName]['name']))
			return "";

		$pname = FileStore::Upload_NEW(
			$fieldName, $this->_images_dir, rand(1000, 9999).$this->ID.$postfix,
			FileMagic::MT_WIMAGE, $this->avatar_file_size
			,
			array(
				'resize' => array(
					'tr' => 3,
					'w'  => $this->avatar_size['max_width'],
					'h'  => $this->avatar_size['max_height'],
				),
			)
		);

		$pname = FileStore::GetPath_NEW($pname);
		$fileNew = Images::PrepareImageToObject($pname, $this->_images_dir);
		$pname = FileStore::ObjectToString($fileNew);

		$this->__set($fieldName, $pname);
		return $pname;
	}

	public function __set($name, $value)
	{
		LibFactory::GetStatic('images');
        LibFactory::GetStatic('filestore');

		$name = strtolower($name);
		switch($name)
		{
			case 'avatar':
				if ($value === null)
				{
					if ($this->Avatar)
						$this->_deleteAvatar($this->Avatar);

					$this->Avatar = '';
					return $value;
				}

				try
				{
					if( ($img_obj = FileStore::ObjectFromString($value)) !== false )
					{
						$file = $this->_images_dir.FileStore::GetPath_NEW($img_obj['file']);
						if (FileStore::IsFile($file)) {
							$this->__set($name, null);

							return $this->Avatar = FileStore::ObjectToString($img_obj);
						}
					}
				}
				catch(MyException $e) { }
			break;

		}
		return null;
	}

	public function __get($name)
	{
		$name = strtolower($name);
		switch($name)
		{
			case 'author':
				return implode(" ", array($this->Surname, $this->Username));
			break;
			case 'avatar':
				if (!$this->Avatar)
					return null;

				LibFactory::GetStatic('images');
				LibFactory::GetStatic('filestore');

				try
				{
					$img_obj = FileStore::ObjectFromString($this->Avatar);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj,
						$this->_images_dir, $this->_images_url);
					unset($img_obj);
					if (empty($preparedImage))
						return null;
				}
				catch ( MyException $e )
				{
					return null;
				}

				return array(
					'f' => $preparedImage['url'],
					'w' => $preparedImage['w'],
					'h' => $preparedImage['h'],
				);
			break;
		}

		return null;
	}

	public function Remove()
	{
		if ( $this->ID === null)
			return false;

		ReviewMgr::getInstance()->Remove($this->ID);
	}

	function __destruct()
	{

	}
}

