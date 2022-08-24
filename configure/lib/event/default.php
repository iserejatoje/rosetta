<?
return array(
	'exchange_currency_set' => array(
		array('name' => 'exchange', 'method' => 'async', 'params' => array('event' => 'clear_graphs')),
		array('name' => 'exchange', 'method' => 'async', 'params' => array('event' => 'clear_yandex_announce_cache')),
	),

	'passport_profile_general_change' => array(
		array('name' => 'love', 'method' => 'async', 'params' => array('event' => 'profile_general_change')),
	),
	
	'passport_profile_location_change' => array(
		array('name' => 'love', 'method' => 'async', 'params' => array('event' => 'profile_location_change')),
	),
	
	'diaries_add_diary' => array(
		array('name' => 'love', 'method' => 'async', 'params' => array('event' => 'add_diary')),
	),
	
	'diaries_remove_diary' => array(
		array('name' => 'love', 'method' => 'async', 'params' => array('event' => 'remove_diary')),
	),

	///////////////////////////////////////////
	// глобальные
	'im_message_sent' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'im_message_sent')),
	),
/*	'user_interest_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_interest_add')),
	),*/
	/*'user_interest_v2_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_interest_v2_add')),
	),*/
	/*'user_place_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_place_add')),
	),*/
	/*'user_address_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_address_add')),
	),*/
	/*'user_auto_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_auto_add')),
	),*/
/*	'user_community_enter' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_community_enter')),
	),*/
	/*'community_interest_v2_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_interest_v2_add')),
	),*/
	/*'community_forum_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_forum_add')),
	),*/
	'comment_add' => array(
		array('name' => 'app_comments', 'params' => array('event' => 'comment_add')),
	),
	'comment_delete' => array(
		array('name' => 'app_comments', 'params' => array('event' => 'comment_delete')),
	),
	'multimedia_remove_node' => array(
		array('name' => 'multimedia_changement', 'params' => array('event' => 'multimedia_remove_node')),
	),
	/*'community_forum_message_add' => array(
		array('name' => 'community_changement', 'params' => array('event' => 'community_forum_message_add')),
	),
	'community_forum_message_del' => array(
		array('name' => 'community_changement', 'params' => array('event' => 'community_forum_message_del')),
	),*/
	/*'community_news_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_news_add')),
		array('name' => 'community_changement', 'params' => array('event' => 'community_news_add')),
	),*/
	/*'community_news_del' => array(
		array('name' => 'community_changement', 'params' => array('event' => 'community_news_del')),
	),*/
	/*'community_poll_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_poll_add')),
		array('name' => 'community_changement', 'params' => array('event' => 'community_poll_add')),
	),*/
	/*'community_poll_del' => array(
		array('name' => 'community_changement', 'params' => array('event' => 'community_poll_del')),
	),*/
	/*'community_gallery_photo_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_gallery_photo_add')),
		array('name' => 'community_changement', 'params' => array('event' => 'community_gallery_photo_add')),
	),*/
	/*'community_gallery_photo_del' => array(
		array('name' => 'community_changement', 'params' => array('event' => 'community_gallery_photo_del')),
	),*/
	/*'community_gallery_album_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'community_gallery_album_add')),
	),*/
	
	/*'user_friend_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_friend_add')),
	),
	'user_friend_remove' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_friend_remove')),
	),
	'user_gallery_photo_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_gallery_photo_add')),
	),
	'user_gallery_album_add' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_gallery_album_add')),
	),
	'user_community_leave' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_community_leave')),
	),*/
	'user_friend_invite' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_friend_invite')),
	),
/*	'user_community_invite' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_community_invite')),
	),*/
	/*'user_photo_comment' => array(
		array('name' => 'user_notification', 'params' => array('event' => 'user_photo_comment')),
	),*/
	/*'delete_community' => array(
		array('name' => 'community_delete', 'params' => array('event' => 'delete_community')),
	),	*/
	'update_news' => array(
		array('name' => 'news_changement', 'params' => array('event' => 'update_news')),
	),
	'delete_news' => array(
		array('name' => 'news_changement', 'params' => array('event' => 'delete_news')),
	),
);
?>