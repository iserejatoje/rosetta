<?
    $add_script = false;
    switch ($this->_params['message']) {
        case 'order_success_paid':
            $add_script = true;
            UserError::AddErrorIndexed('global', ERR_M_CATALOG_ORDER_SUCCESS_PAID);
            break;
        case 'order_fail_pay':
            UserError::AddErrorIndexed('global', ERR_M_CATALOG_ORDER_FAIL_PAY);
            break;
        case 'order_old':
            UserError::AddErrorIndexed('global', ERR_M_CATALOG_ORDER_OLD);
            break;
        case 'order_unknow':
            UserError::AddErrorIndexed('global', ERR_M_CATALOG_ORDER_UNKNOW);
            break;
        case 'order_was_paid':
            UserError::AddErrorIndexed('global', ERR_M_CATALOG_ORDER_WAS_PAID);
            break;
        case 'artificial_sent':
            UserError::AddErrorIndexed('global', ERR_M_ARTIFICIAL_SEND_ORDER);
            break;
        default:
            UserError::AddErrorIndexed('global', ERR_M_STATIC_PAGE_UNKNOWN_ERROR);
        break ;
    }

    return STPL::Fetch('modules/catalog/message', array(
        'message' => $this->_params['message'],
        'add_script' => $add_script,
    ));