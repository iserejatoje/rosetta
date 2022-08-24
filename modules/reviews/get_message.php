<?
	switch ($this->_params['message']) {
		case 'success_submit':
			UserError::AddErrorIndexed('global', ERR_M_REVIEWS_SUCCESS_SUBMIT);
			break;
		default:
			UserError::AddErrorIndexed('global', ERR_M_REVIEWS_UNKNOWN_ERROR);
		break ;
	}

	return STPL::Fetch('modules/reviews/message', array(
		'message' => $this->_params['message'],
		'order' => $order,
	));