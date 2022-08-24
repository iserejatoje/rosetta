<?
	$params = array(
		'list' => $this->_get_list(),
		'form' => $this->_get_form(),
	);
	return STPL::Fetch('modules/reviews/default', $params);