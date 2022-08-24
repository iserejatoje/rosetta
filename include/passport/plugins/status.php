<?php

class PStatusPassportPlugin extends PABasePassportPlugin {

	const ST_NORMAL = 2;
	const ST_SUSPECT = 1;
	const ST_SPAM = 0;

	private $_rating = null;

	public function __construct($user, $mgr) {
		parent::__construct($user, $mgr, 'Status');
	}

	public function Spam() {

		$this->_rating = 0;
		return $this->_setRating($this->user->ID, $this->_rating);
	}

	public function Down($level = 1) {

		$level = abs($level);
		$this->_rating = $this->GetRating();
		$this->_rating-= $level;

		if ( $this->_rating <= 0 )
			$this->_rating = 0;

		return $this->_setRating($this->user->ID, $this->_rating);
	}

	public function Up($level = 1) {

		$this->_rating = $this->GetRating();

		if ( $this->_rating <= 0 )
			$this->_rating = 0;

		if ( $this->_rating < 50 )
			$this->_rating+= $level;

		return $this->_setRating($this->user->ID, $this->_rating);
	}

	public function GetRating() {

		if ( $this->_rating !== null )
			return $this->_rating;

		$result = $this->_getRating($this->user->ID);
		if ($result !== false)
			return (int) $result;

		return 0;
	}

	public function GetStatus() {

		$this->_rating = $this->GetRating();

		if ( $this->_rating > 10 )
			return self::ST_NORMAL;
		else if ( $this->_rating <= 10 && $this->_rating > 0 )
			return self::ST_SUSPECT;

		return self::ST_SPAM;
	}

	private function _setRating($userid, $rating) {
		if (!is_numeric($userid) || $userid <= 0)
			return false;

		if (!is_numeric($rating) || $rating < 0)
			return false;

		$sql = "UPDATE ".PUsersMgr::$tables['profile_general']." SET ";
		$sql.= " `Rating` = ".(int) $rating;
		$sql.= " WHERE `UserID` = ".(int) $userid;

		return PUsersMgr::$db->query($sql);
	}

	private function _getRating($userid) {
		$sql = "SELECT `Rating` FROM ".PUsersMgr::$tables['profile_general'];
        $sql.= " WHERE `UserID` = ".(int) $userid;
		if (false == ($res = PUsersMgr::$db->query($sql)))
			return false;

		if ($res->num_rows == 0)
			return false;

		list($Rating) = $res->fetch_row();
		return $Rating;
	}
}
