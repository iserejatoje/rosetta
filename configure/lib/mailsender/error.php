<?php

global $ERROR;

static $l_mail_error_code = 0;
define('ERR_L_MAIL_MASK', 0x00012000);
define('ERR_L_MAIL_UNKNOWN_ERROR', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_UNKNOWN_ERROR]
	= 'Unknown error.';

define('ERR_L_MAIL_SENT_SUCCESSFULLY', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_SENT_SUCCESSFULLY]
	= 'Message sent successfully.';

define('ERR_L_MAIL_FIELD_TO_IS_EMPTY', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_FIELD_TO_IS_EMPTY]
	= 'Field To is empty.';

define('ERR_L_MAIL_FIELD_FROM_IS_EMPTY', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_FIELD_FROM_IS_EMPTY]
	= 'Field From is empty.';

define('ERR_L_MAIL_SEND_ERROR', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_SEND_ERROR]
	= 'Message send error.';

define('ERR_L_MAIL_ADDRESS_INCORRECT', ERR_L_MAIL_MASK | $l_mail_error_code++);
$ERROR[ERR_L_MAIL_ADDRESS_INCORRECT]
	= 'Wrong email address.';


?>