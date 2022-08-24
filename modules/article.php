<?
/**
 * Модуль Mod_News_v2
 * Модуль новостей.
 *
 * @date		$Date: 2008/01/17 11:37:00 $
 */

/**
 * Зависимости:
 * Lib:
 *  Data
 *
 */

$error_code = 0;
define('ERR_M_NEWS_MASK', 0x00330000); 


LibFactory::GetStatic('application');
class Mod_Article extends ApplicationBaseMagic
{
	protected $_page = 'main';
	protected $_db;
	protected $_params;
	protected $_result = array();
	protected $_News = null;
	protected $_NewsID;
	protected $_RefID;
	protected $_IsComments = false;
	protected $_ShowCommentForm = false;
	protected $_isRating;
	protected $_strings = array(
		'archive_title'	=> 'Архив раздела «%s» за %s',
		'archive_title_wd'	=> 'Архив раздела «%s»'
	);
	
	protected $_TagsMgr;

	public function __construct() {
		parent::__construct('article');
	}

	function Init() {
		global $OBJECTS;
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
		LibFactory::GetStatic('ustring');
		$this->_db = DBFactory::GetInstance($this->_config['db']);
	}

	public function AppInit($params)
	{
		global $OBJECTS, $CONFIG;
	}

	public function &GetPropertyByRef($name)
	{
		global $OBJECTS;
		
		$name = strtolower($name);
		if ( $name == 'newsid' )
		{
			if ( $this->_page=='details' && $this->_NewsID )
				return $this->_NewsID;
			else
				return null;
		}
		else if ( $name == 'refid' )
		{
			if ( $this->_page=='details' && $this->_RefID )
				return $this->_RefID;
			else
				return null;
		}
		else if ($name == 'sectionid') {
			return $this->_env['sectionid'];
		} else if ($name == 'premoderate') {
			return $this->_config['premoderate'];
		} else if ($name == 'iscomments') {
			return $this->_IsComments;
		} else if ($name == 'israting') {
			return $this->_isRating;
		} else if ($name == 'rolekey') {
			return $this->_env['sectionid'].'_'.$this->_NewsID;
		} else if ($name == 'showcommentform') {
			return $this->_ShowCommentForm;
		}

		return parent::GetPropertyByRef($name);
	}

	protected function _ActionModRewrite(&$params)
	{
		
		// разбиваем строку с параметрами и анализируем

		// конкретная статья
		if(preg_match('@^(\d+)\.html$@', $params, $matches)) {
			$this->_page = 'details';
			$this->_params['id'] = $matches[1];
			$this->_Get_Details_Text();
		}
		else if(preg_match('@^(\d+)-print\.html$@', $params, $matches)) {
			$this->_page = 'print';
			$this->_params['id'] = $matches[1];
		}
		else if(preg_match('@^all/?$@', $params, $matches)) {
			$this->_page = 'list';
			
			$this->_params['year']  = null;
			$this->_params['month'] = null;
			$this->_params['day']   = null;
		}
		
		else if(preg_match("@^/?@", $params, $matches) && $this->_config['type'] == 'newsline') {
			Response::Status(301);
			Response::Redirect('/'.$this->_env['section'].'/all/');
		}
			
		// список всех статей и за одно архив
		else if(preg_match("@^(\d{4})((/(\d{1,2}))?(/(\d{1,2}))?)?/?@", $params, $matches)) {
			$this->_page = 'list';

			$this->_params['year']  = $matches[1];
			$this->_params['month'] = $matches[4];
			$this->_params['day']   = $matches[6];
		}
		// последняя статья
		else {
			if ($this->_config['default_archive'] !== true) {
				if($this->_config['type'] == 'newsline') {
					$ld = $this->_GetLastDate();
					Response::Redirect('/'.$this->_env['section'].'/'.date('Y/m/d/',$ld));
				}
				else
				{
					Response::Status(301);
					Response::Redirect('/'.$this->_env['section'].'/'.$this->_GetLastArticle().'.html');
				}
			} else {
				Response::Redirect('/'.$this->_env['section'].'/all/');
			}
		}
		

		$this->_env['section_page'] = $this->_page;

		$this->_params['p'] = App::$Request->Get['p']->Int(0, Request::UNSIGNED_NUM);
		if( !$this->_params['p'] )
			$this->_params['p'] = 1;
	}


	protected function _ActionPost()
	{
	}

	protected function _ActionGet()
	{			
		switch($this->_page)
		{
			case 'details':
				$page =& $this->_G_Details();
				break;
			case 'print':
				$this->_config['templates']['index'] = $this->_config['templates']['index_simple'];
				$this->_config['templates']['ssections']['details'] = $this->_config['templates']['ssections']['print'];
				$page =& $this->_G_Details();
				break;
			case 'list':
				$page =& $this->_G_List();
				break;
		}
		return $page;
	}

	/*
	* =======================================
	*  GET functions
	* =======================================
	*/

	protected function _G_FeedList($params) {
		global $OBJECTS, $CONFIG;

		LibFactory::GetStatic('source');

		$sql = 'SELECT a.*, a.Date as `pubDate`, r.RefID FROM '.$this->_config['tables']['ref'].' as r';
		$sql.= ' INNER JOIN '.$this->_config['tables']['article'].' AS a ';
		$sql.= ' ON (a.NewsID = r.NewsID)';
		$sql.= ' WHERE r.SectionID = '.$this->_env['sectionid'];

		if ($params['period'] > 0)
			$sql.= ' AND r.Date >= DATE_SUB(NOW(), INTERVAL '.$params['period'].' HOUR)';

		$sql.= " AND r.Date <= NOW()";
		$sql.= " AND a.`isRSS` = 1";

		$sql.= ' ORDER BY r.`Date` DESC';
		if($params['limit'] > 0)
			$sql.= ' LIMIT '. $params['limit'];
      
		$res = $this->_db->query($sql);

		$list = array();

		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$images_cont_url = (strpos($this->_config['images_cont_url'], App::$Protocol)===0? $this->_config['images_cont_url'] : App::$Protocol . $this->_env['site']['domain'].$this->_config['images_cont_url']);
		$images_url = (strpos($this->_config['images_url'], App::$Protocol)===0? $this->_config['images_url'] : App::$Protocol . $this->_env['site']['domain'].$this->_config['images_url']);
		while(false != ($row = $res->fetch_assoc())) {
			$enclosure = array();

			if (!sizeof($enclosure) && trim($row['ThumbnailImg']) != '' ) {
				
				try
				{
					$img_obj = FileStore::ObjectFromString($row['ThumbnailImg']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj, $this->_config['images_dir'], $this->_config['images_url']);
					
					if (!empty($preparedImage)) {
						$enclosure[] = array(
							'url'		=> $preparedImage['url'],
							'length'	=> $preparedImage['size'],
							'type'		=> $preparedImage['mime'],
							'w'			=> $preparedImage['w'],
							'h'			=> $preparedImage['h'],
						);
					} else 
						continue;
					
					unset($img_obj);
				}
				catch ( MyException $e ) 
				{ 
					continue;
				}
			}

			foreach($row as &$v) $v = trim($v);

			if ($row['Anon'] == '') {
				$row['Anon'] = trim(DATA::ScrapText(strip_tags($row['Text']),250));
			}
			$section = STreeMgr::GetNodeByID($this->_env['sectionid']);
			$list[] = array(
				'link'			=> ModuleFactory::GetLinkBySectionId($this->_env['sectionid']) . $row['NewsID'] . '.html',
				'title'			=> $row['Title'],
				'author'		=> array(
					'author_name'	=> $row['AuthorName'],
					'author_email'	=> $row['AuthorEmail']
				),
				'category'		=> ( $section == null ? '' : $section->Name ),				
				'pubDate'		=> strtotime($row['pubDate']), // выводится дата в чистом виде, т.к. в конечном месте используется date('r'), а там указывается часовой пояс.
				'enclosure' 	=> $enclosure,
				'description'	=> $row['Anon'],
				'full-text'		=> $row['Text']
			);
		}

		return $list;
	}

	protected function &_G_Details()
	{
		global $OBJECTS, $CONFIG;

		$this->_result['text'] =& $this->_Get_Details_Text();

		if (intval($this->_result['text']['NewsID']) <= 0)
			Response::Status(404, RS_EXIT | RS_SENDPAGE);

		$page['blocks']['text'] = $this->RenderBlock($this->_config['templates']['ssections']['details_text'],
			null, array($this, '_Get_Details_Text'), false);

		LibFactory::GetStatic('statincrement');
		StatIncrement::Log(
			$this->_config['db'], $this->_config['tables']['article'],
			'Views', 'NewsID', $this->_result['text']['NewsID']
		);

		# устанавливаем ключевые параметры
		#=================
		$page['NewsID'] = $this->_result['text']['NewsID'];

		if ($this->_result['text']['SeoTitle'] == "")
			$OBJECTS['title']->AppendBefore(strip_tags($this->_result['text']['Title']));
		else
		{
			App::$Title->Title = $this->_result['text']['SeoTitle'];
			App::$Title->Description = UString::ChangeQuotes($this->_result['text']['SeoDescription']);
			App::$Title->Keywords = UString::ChangeQuotes($this->_result['text']['SeoKeywords']);
		}
		

		# Чистим переменные
		#=================
		$this->_result = array();

		return $page;
	}

	protected function &_G_List()
	{
		global $OBJECTS, $CONFIG;

		# list
		#=================

		$page["blocks"]["list"] = $this->RenderBlock($this->_config['templates']['ssections']["list_list"],
			null, array($this, '_Get_List_List'), false);

		# Устанавливаем заголовки
		#=================
		if($this->_config['type'] == 'newsline') {
			$OBJECTS["title"]->AppendBefore($this->_env['site']['title'][$this->_env['section']]);
		} else {

			$date = array(
				'month' => $this->_params['month'] ? $this->_params['month'] : 1,
				'day' => $this->_params['day'] ? $this->_params['day'] : 1,
				'year' => $this->_params['year'],
			);

			if ( !checkdate($date['month'], $date['day'], $date['year']) )
				$OBJECTS['title']->AppendBefore(sprintf($this->_strings['archive_title_wd'],
					$this->_env['site']['title'][$this->_env['section']]));
			else {
				if($this->_params['day'])
					$date = $this->_params['day'].' '.Arrays::$Month['genitive'][intval($this->_params['month'])];
				else if ($this->_params['month'])
					$date = Arrays::$Month['subjective'][intval($this->_params['month'])];
				else
					$date = '';

				$date .= ' '.$this->_params['year'].($date?' года':' год');
				$OBJECTS['title']->AppendBefore(sprintf($this->_strings['archive_title'],
					$this->_env['site']['title'][$this->_env['section']], $date));
			}
		}
		return $page;
	}

	/**
	* Возвращает список новостей
	*
	* @return array
	*  title - заголовок списка
	*  count - кол-во новостей
	*  pageslink - массив ссылок постраничной навигации
	*  list - array
	*    NewsID - ID новости
	*    Date - дата новости
	*    Anon - массив анонсиков новости
	*    Title - название новости
	*    TitleType - тип новости
	*    TitleArr - имя новости разбитое в массив
	*    ThumbnailImg - каритнка массив (file, w, h)
	*/
	protected function &_Get_List_List()
	{
		global $CONFIG, $OBJECTS;

		$list = array(
			'title' => '',
			'count' => 0,
			'list' => array(),
			'pageslink' => array(),
		);

		if ($this->_page == 'list')
		{
			$list['date'] = strtotime($this->_params['year'].'-'.$this->_params['month'].'-'.$this->_params['day']);
		}

		$sql = 'SELECT SQL_CALC_FOUND_ROWS a.*, r.RefID FROM '.$this->_config['tables']['article'].' as  a';

		$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ';
		$sql.= ' ON (r.NewsID = a.NewsID AND r.SectionID = '.$this->_env['sectionid'].')';
		$sql.= ' WHERE ';

		// date
		if ($this->_params['year']) {

			$date = array(
				'year' => $this->_params['year'],
				'month' => $this->_params['month'] !== null ? $this->_params['month'] : '01',
				'day' => $this->_params['day'] !== null ? $this->_params['day'] : '01',
			);

			if ( !checkdate($date['month'], $date['day'], $date['year']) )
				return $list;

			$sql .= ' a.Date >= \''.implode('-', $date).'\' AND ';
			if ( $this->_params['day'] )
				$sql .= ' a.Date < DATE_ADD(\''.implode('-', $date).'\', INTERVAL 1 DAY) AND ';
			else if ( $this->_params['month'] )
				$sql .= ' a.Date < DATE_ADD(\''.implode('-', $date).'\', INTERVAL 1 MONTH) AND ';
			else
				$sql .= ' a.Date < DATE_ADD(\''.implode('-', $date).'\', INTERVAL 1 YEAR) AND ';
		}
		//$sql .= ' r.opt_inState = 1 ';
		$sql .= ' TRUE ';

		$sql .= ' ORDER BY a.Date DESC';
		$sql .= ' LIMIT '.($this->_config['art_col_pp']*($this->_params['p']-1)).', '.$this->_config['art_col_pp'];
                
		
		$resNews = $this->_db->query($sql);
		if ( !$resNews || !$resNews->num_rows )
			return $list;

		// [B] Get pages link
		$res1 = $this->_db->query('SELECT found_rows()');
		if ( $res1 && $res1->num_rows )
			list($list['count']) = $res1->fetch_row();

		if ((($this->_params['p']-1) * $this->_config['art_col_pp']) > $list['count']+1)
			return $list;

		$list['pageslink'] = Data::GetNavigationPagesNumber(
			$this->_config['art_col_pp'], $this->_config['art_col_pageslink'],
			$list['count'], $this->_params['p'], '?p=@p@', 1);

		$name = $this->_env['site']['title'][$this->_env['section']];
		// [E] Get pages link

		if ( !checkdate($date['month'], $date['day'], $date['year']) ) {
			$list['title'] = sprintf($this->_strings['archive_title_wd'], $name);
		} else {
			if($this->_params['day'])
				$date = $this->_params['day'].' '.Arrays::$Month['genitive'][intval($this->_params['month'])];
			else if ($this->_params['month'])
				$date = Arrays::$Month['subjective'][intval($this->_params['month'])];
			else
				$date = '';

			$date .= ' '.$this->_params['year'].($date ? ' года' : ' год');
			$list['title'] = sprintf($this->_strings['archive_title'], $name, $date);
		}

		if ($resNews && $resNews->num_rows) {
			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('images');

			while ( false != ($news = $resNews->fetch_assoc()) ) {

				if (trim($news['ThumbnailImg']) != '') {
					LibFactory::GetStatic('filestore');
					LibFactory::GetStatic('images');
					
					try
					{
						$img_obj = FileStore::ObjectFromString($news['ThumbnailImg']);
						$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
						$preparedImage = Images::PrepareImageFromObject($img_obj, $this->_config['images_dir'], $this->_config['images_url']);
						
						unset($img_obj);
					}
					catch ( MyException $e )
					{
						$news['ThumbnailImg'] = null;
					}
					if (!empty($preparedImage)) {
						$news['ThumbnailImg'] = array(
							'file'	=> $preparedImage['url'],
							'w'		=> $preparedImage['w'],
							'h'		=> $preparedImage['h'],
						);
					} else $news['ThumbnailImg'] = null;
						
					
				} else 
					$news['ThumbnailImg'] = null;
				
				
				$news['Date'] = strtotime(Datetime_my::NowOffset(null, strtotime($news['Date'])));
				$news['TitleArr'] = $this->_ParsenameArticle($news['Title'], $news['TitleType']);

				$list['list'][$news['NewsID']] = $news;
			}
		}
				
		return $list;
	}


	/**
	* Возвращает подробную информацию о новости
	*
	* @return array
	*/
	protected function &_Get_Details_Text() {
		global $OBJECTS;
		if ( $this->_News !== null )
			return $this->_News;

		$sql = 'SELECT a.*, r.RefID FROM '.$this->_config['tables']['article'].' as  a';
		$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ON (r.NewsID = a.NewsID)';
		$sql.= ' WHERE r.NewsID='.$this->_params['id'];

		$sql.= ' AND r.SectionID = '.$this->_env['sectionid'];

		if ( App::$Request->Get['preview']->Int(0, Request::UNSIGNED_NUM) != 1 )
			$sql.= ' AND a.IsVisible = 1';

		if ( App::$Request->Get['preview']->Int(0, Request::UNSIGNED_NUM) != 1 )
			$res = $this->_db->query($sql);
		else
			$res = $this->_db->query($sql);
                
		$News = null;
		$this->_IsComments = false;
		$this->_isRating = 0;
		if ( $res && $res->num_rows ) {
			$News = $res->fetch_assoc();

			if ($this->_config['allow_comments'] === true)
				$this->_IsComments = $News['isComments'] == 1 || $News['isComments'] == 2;
			$this->_ShowCommentForm = $News['isComments'] != 2;
			$this->_NewsID = $News['NewsID'];
			$this->_RefID = $News['RefID'];
			$this->_isRating = $News['isRating'];

			$News['Date'] = strtotime(Datetime_my::NowOffset(null, strtotime($News['Date'])));
			
			/*if ($News['hideLinks'])
				$News['Text'] = UString::ScreenHref($News['Text']);*/

			$News['TitleArr'] = $this->_ParsenameArticle($News['Title'], $News['TitleType']);
			
			$filter = array(
				'UniqueID' => array($News['NewsID']),
				'SectionID' => array($this->_env['sectionid']),
			);
						
			
			$News['Title'] = UString::ChangeQuotes($News['Title']);
			//App::$Title->Description = UString::Truncate(strip_tags(UString::ChangeQuotes($News['Text'])), 500);
			//App::$Title->Add('meta', array('name' => 'title', 'content' => $News['Title']));
			
			
			if (trim($News['ThumbnailImg']) != '') {
				LibFactory::GetStatic('filestore');
				LibFactory::GetStatic('images');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($News['ThumbnailImg']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj, $this->_config['images_dir'], $this->_config['images_url']);
					
					$image_src = $preparedImage['url'];
					if (strpos($image_src, App::$Protocol) === false)
					{
						$image_src = App::$Protocol . $this->_env['site']['domain'].$image_src;
					}
					
					App::$Title->Add('link', array('rel' => 'image_src', 'href' => $image_src));
					
					unset($img_obj);
				}
				catch ( MyException $e )
				{
					$News['ThumbnailImg'] = null;
				}
			}
			
			if (!empty($preparedImage)) {
				$News['Thumb'] = array(
						'file' => $preparedImage['url'],
						'w' => $preparedImage['w'],
						'h' => $preparedImage['h'],
					);
			} else 
				$News['Thumb'] = null;
				
			
			$News['type'] = 'news';			
		}
		
		$this->_News = $News;
		return $News;
	}

	/*
	* =======================================
	*  COMMON functions
	* =======================================
	*/

	/**
	* Возвращает время последней новости
	*
	* @return int
	*/
	private function _GetLastDate() {
		$sql = 'SELECT UNIX_TIMESTAMP(a.Date) FROM '.$this->_config['tables']['article'].' as  a';
		$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ON (r.NewsID = a.NewsID)';
		$sql.= ' WHERE r.SectionID = '.$this->_env['sectionid'];
		$sql.= ' ORDER BY r.Date DESC';
		$sql.= ' LIMIT 1';

		$tsDate = 0;
		$res = $this->_db->query($sql);
		if($res && $res->num_rows )
			list($tsDate) = $res->fetch_row();

		return $tsDate;
	}

	/**
	* Возвращает ID последней новости
	*
	* @return int
	*/
	private function _GetLastArticle() {

		$sql = 'SELECT a.NewsID FROM '.$this->_config['tables']['article'].' as  a';
		$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ON (r.NewsID = a.NewsID)';
		$sql.= ' WHERE r.SectionID = '.$this->_env['sectionid'];
		$sql.= ' ORDER BY r.Date DESC';
		$sql.= ' LIMIT 1';
		
		$NeswID = 0;
		$res = $this->_db->query($sql);
		if($res && $res->num_rows )
			list($NeswID) = $res->fetch_row();

		return $NeswID;
	}

	/**
	* Разрезает название статьи в зависимости от типа
	* $title string - текст названия статьи
	* $type int - тип статьи
	* @return array
	*/
	protected function _ParsenameArticle($title, $type)
	{
		switch ($type) {
			case 3:		// признание
				if(preg_match("@^(.+?)(:\s*(.+?))?$@i", $title, $regs))
					return array('name' => $regs[1], 'text' => $regs[3]);
				break;
			case 2: 	// интервью
				if(preg_match("@^(.+?),\s*(.+?)(:\s*(.+?))?$@i", $title, $regs))
					return array('name' => $regs[1], 'position' => $regs[2], 'text' => $regs[4]);
				break;
			default:
				return array('name' => $title);
		}
	}
}

?>
