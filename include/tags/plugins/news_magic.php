<?

class TagsPlugin_News_Magic extends TagsPluginTrait
{
	public function GetData($items)
	{
		global $OBJECTS;

		LibFactory::GetMStatic('news', 'newsmgr');
		LibFactory::GetStatic('app_comment_tree');
		$NewsMgr = NewsMgr::getInstance();

		$temp = reset ($items);
		$config = ModuleFactory::GetConfigById('section', $temp['SectionID']);

		AppCommentTree::$db = NewsMgr::$db;
		AppCommentTree::$tables = array(
			'comments' 	=> $config['tables']['comments'],
			'votes'		=> $config['tables']['comments_votes'],
			'ref'		=> $config['tables']['comments_ref'],
		);

		$filter = array(
			'newsid' => array_keys($items),
		);

		$news = $NewsMgr->getNews($filter);

		$reference = array();
		//$sections = array();

		$result = array();
		foreach($news as $v) {

			/*if (!isset($sections[$v->SectionID])) {
				$section = STreeMgr::GetNodeByID($v->SectionID);
				if ($section->ParentID == $items[$v->ID]['SiteID'])
					$sections[$v->SectionID] = array(
						'Name' => $section->Name,
						'Link' => ModuleFactory::GetLinkBySectionId($v->SectionID, array(), true),
					);
				else {
					$sections[$v->SectionID] = false;
					continue ;
				}
			}*/

			if (!isset($reference[$v->ID]))
				$reference[$v->ID] = array();

			$reference[$v->ID][ $v->SectionID ] = $v->RefID;

			$result[$v->ID] = $v->Data;
			$result[$v->ID]['ThumbnailImg'] = $v->Thumb;
			$result[$v->ID]['Time'] = $v->Time;
			$result[$v->ID]['Url'] = STreeMgr::GetLinkBySectionId($items[$v->ID]['SectionID']).$v->Data['NewsID'].".html";
		}

		foreach($result as $k => $v) {

			if ($v['isComments'] == false)
				continue ;

			if (empty($reference[$k]))
				continue ;

			/*$result[$k]['Sections'] = array();
			foreach(array_keys($reference[$k]) as $v) {
				if (!$sections[$v])
					continue ;

				$result[$k]['Sections'][] = $sections[$v];
			}*/

			$filter = array(
				'fields' => array(
					'uniqueid'	=> $reference[$k][$items[$k]['SectionID']],
					'isvisible'	=> 1,
					'isnew'		=> 0,
					'maxlevel'	=> 0,
				),
				'sort' => array(
					array('field' => 'created', 'dir' => 'DESC'),
				),
				'limit' => array(
					'offset'=> 0,
					'limit'	=> 1,
				),
			);

			$cresult = AppCommentTree::GetComments($filter, true);
			if ( is_array($cresult) && sizeof($cresult) ) {
				$comment = current($cresult);

				$comment = array(
					'CommentID'	=> $comment['data']['CommentID'],
					'Name'		=> $comment['data']['Name'],
					'Text'		=> $comment['data']['Text'],
					'UserID'	=> $comment['data']['UserID'],
					'Created'	=> $comment['data']['Created'],
					'User'		=> array(
						'Name'		=> '',
						'InfoUrl'	=> '',
					),
				);

				if ( $comment['UserID'] ) {
					$user = $OBJECTS['usersMgr']->GetUser($comment['UserID']);
					if ( $user !== null && $user->ID > 0 ) {
						$comment['User']['Name'] = trim($user->Profile['general']['ShowName']);
						$comment['User']['InfoUrl'] = $user->Profile['general']['InfoUrl'];
					}
				}
				$result[$k]['UrlComment'] = $result[$k]['Url'].'?p=last#comment'.$comment['CommentID'];
				$result[$k]['Comment'] = $comment;
			} else
				$result[$k]['Comment'] = null;

		}

		return $result;
	}
}