<?
/**
 * Модуль Passport.
 *
 * @date		$Date: 2008/02/27 13:34:00 $
 */

$error_code = 0;
define('ERR_M_PASSPORT_MASK', 0x00250000);
define('ERR_M_PASSPORT_UNKNOWN_ERROR', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_UNKNOWN_ERROR]
	= 'Незвестная ошибка.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_EMPTY]
	= 'EMail не может быть пустым.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_NOTREG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_NOTREG]
	= 'Если вы хотите создать дополнительный E-mail отметьте "Создать дополнительный E-mail".';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_ALREADY_EXISTS]
	= 'Данный EMail уже зарегистрирован.<br />Если Вы уверены, что это ваш ящик, то возможно Вы регистрировались ранее. Воспользуйтесь <a href="/account/forgot.php?url='.$_GET['url'].'" style="color:red">системой восстановления пароля</a>.';
define('ERR_M_PASSPORT_EMAIL_NOT_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMAIL_NOT_EXISTS]
	= 'Данный EMail не зарегистрирован.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_WRONG]
	= 'Неверный EMail.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_OUR_EMAIL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_OUR_EMAIL]
	= 'Вы не можете сменить свой почтовый ящик на указанный.';

define('ERR_M_PASSPORT_EMPTY_PASSWORD', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMPTY_PASSWORD]
	= 'Пароль не может быть пустым.';
define('ERR_M_PASSPORT_PASSWORD_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_PASSWORD_WRONG]
	= 'Вы указали недопустимые символы для пароля. Возможно вы использовали буквы русского языка.';
define('ERR_M_PASSPORT_EMPTY_SWITCH_DATA', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMPTY_SWITCH_DATA]
	= 'Необходимо указать идентификатор пользователя или E-Mail.';

define('ERR_M_PASSPORT_EMPTY_SWITCH_USER_NF', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMPTY_SWITCH_USER_NF]
	= 'По введенным вами данным пользователь не найден.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_EMPTY]
	= 'Старый пароль не может быть пустым.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_OLDPASSWORD_WRONG]
	= 'Неверный старый пароль.';
define('ERR_M_PASSPORT_WRONG_CAPTCHA', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_WRONG_CAPTCHA]
	= 'Неверный код защиты от роботов.';
define('ERR_M_PASSPORT_PASSWORD_NOT_EQUAL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_PASSWORD_NOT_EQUAL]
	= 'Пароли не равны.';
define('ERR_M_PASSPORT_EMPTY_QUESTION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMPTY_QUESTION]
	= 'Вопрос не указан.';
define('ERR_M_PASSPORT_EMPTY_ANSWER', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_EMPTY_ANSWER]
	= 'Ответ не указан.';
define('ERR_M_PASSPORT_WRONG_ANSWER', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_WRONG_ANSWER]
	= 'Ответ неверный.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_EMPTY]
	= 'Отображаемое имя не может быть пустым.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_WRONG]
	= 'Неверное отображаемое имя.';
define('ERR_M_PASSPORT_NICKNAME_ALREADY_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_NICKNAME_ALREADY_EXISTS]
	= 'Данное отображаемое имя уже зарегистрировано.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_LEN', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_NICKNAME_LEN]
     = 'Длина отображаемого имени не должна превышать %1$s знаков.';

define('ERR_M_PASSPORT_INCORRECT_FILE_TYPE', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_FILE_TYPE]
     = 'Вы не можете прикрепить файл данного типа.';

define('ERR_M_PASSPORT_REG_EMAIL_ERROR', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_REG_EMAIL_ERROR]
	= 'При регистрации Email возникла ошибка. Обратитесь в службу поддержки.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_RETYPE_PASSWORD', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_RETYPE_PASSWORD]
	= 'Не забудьте ввести пароль.';
define('ERR_M_PASSPORT_QUESTION_NOT_EXIST', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_QUESTION_NOT_EXIST]
	= 'Вопрос для восстановления не задан. Обратитесь в службу поддержки.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_GENDER_EMPTY]
	= 'Укажите Ваш пол.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_HEIGHT', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_HEIGHT]
	= 'Рост должен быть в пределах от %s до %s.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_WEIGHT', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_WEIGHT]
	= 'Вес должен быть в пределах от %s до %s.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EXISTS]
	= 'Данное имя уже зарегистрировано.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_INVALID', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_INVALID]
	= 'Имя может сотоять только из символов: A-Z, a-z, А-Я, а-я, 0-9, "_" и "-".';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_INVALID', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_INVALID]
	= 'Фамилия может сотоять только из символов: A-Z, a-z, А-Я, а-я, 0-9, "_" и "-".';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_INVALID', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_INVALID]
	= 'Отчество может состоять только из символов: A-Z, a-z, А-Я, а-я, 0-9, "_" и "-".';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_EMAIL_LEN]
     = 'Длина почтового ящика не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SIGNATURE_LEN', ERR_M_MAIL_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SIGNATURE_LEN]
     = 'Длина подписи не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_MESSAGES_COL_PP', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_MESSAGES_COL_PP]
     = 'Неверное количество сообщение на странице.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_COL_PP', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_COL_PP]
     = 'Неверное количество адресов на странице.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SF', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SF]
     = 'Неверное поле сортировки писем.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SO', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SO]
     = 'Неверный порядок сортировки писем.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_SF', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_SF]
     = 'Неверное поле сортировки адресов.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_SO', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ADDRESS_SO]
     = 'Неверный порядок сортировки адресов.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_QUESTION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_QUESTION]
     = 'Выберите вопрос из списка или укажите свой.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ANSWER', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ANSWER]
     = 'Введите ответ на вопрос.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_PASSWORD', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_PASSWORD]
     = 'Неверный пароль.';

define('ERR_M_PASSPORT_NOT_CONFIRMED', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_NOT_CONFIRMED]
	= 'Вы не ознакомились с правилами.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_WRONG]
	= 'Неверный ICQ, ICQ должен состоять из цифр и символа дефис и содержать 5 или более цифр.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_WRONG]
	= 'Неверный сайт.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ICQ_LEN]
	= 'Длина ICQ не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SITE_LEN]
	= 'Длина сайта не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_SKYPE_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_SKYPE_LEN]
	= 'Длина Skype не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_WRONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_WRONG]
	= 'Неверный номер телефона, номер может состоять только из символов 0-9, -, (), и пробел';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_PHONE_LEN]
	= 'Длина телефона не должна превышать %1$s знаков.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_LEN]
	= 'Длина имени не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_LEN]
	= 'Длина фамилии не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_LASTNAME_IS_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_LASTNAME_IS_EMPTY]
	= 'Вы не указали свою фамилию.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_MIDNAME_LEN]
	= 'Длина отчества не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_CITY_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_CITY_LEN]
	= 'Длина города не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_ABOUT_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_ABOUT_LEN]
	= 'Длина поля &quot;О себе&quot; не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_WORKPLACE_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_WORKPLACE_LEN]
	= 'Длина места работы не должна превышать %1$s знаков.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_POSITION_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_POSITION_LEN]
	= 'Длина должности не должна превышать %1$s знаков.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_NUM', ERR_M_PLACE_MASK | $place_error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_NUM]
	= 'Номер дома введен неверно.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_INDEX', ERR_M_PLACE_MASK | $place_error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_HOUSE_INDEX]
	= 'Индекс дома введен неверно.';

define('ERR_M_PASSPORT_INCORRECT_SETTINGS_AVATAR', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_AVATAR]
	= 'Ошибка загрузки аватара. Проверьте требования к аватару.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_PHOTO', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_PHOTO]
	= 'Ошибка загрузки фотографии. Проверьте требования к фотографии.';

define('ERR_M_PASSPORT_REG_ADD_USER', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_REG_ADD_USER]
	= 'Ошибка регистрации. Если данная ошибка будет повторяться, обратитесь в службу поддержки.';

define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_EMPTY]
	= 'Поле кому не может быть пустым';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TO_NOT_EXISTS]
	= 'Указанный вами пользователь не существует';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TITLE_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TITLE_EMPTY]
	= 'Тема сообщения не может быть пустой.';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TITLE_TOLONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TITLE_TOLONG]
	= 'Тема сообщения не может быть более 100 символов.';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_EMPTY]
	= 'Текст сообщение не может быть пустым.';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_TOLONG', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_TEXT_TOLONG]
	= 'Текст сообщения не может превышать %1$s символов.';
define('ERR_M_PASSPORT_INCORRECT_MESSAGE_SEND_TO_SELF', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_MESSAGE_SEND_TO_SELF]
	= 'Вы не можете отправить сообщение себе.';

define('ERR_M_PASSPORT_INCORRECT_USER_STATUS_LEN', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_USER_STATUS_LEN]
     = 'Длина статусного сообщения не должна превышать %1$s знаков.';

define('ERR_M_PASSPORT_NOT_ENOUGH_RIGHTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_NOT_ENOUGH_RIGHTS]
     = 'У вас не достаточно прав для выполнения данной операции.';

define('ERR_M_PASSPORT_INCORRECT_FRIEND_ID', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_FRIEND_ID]
	= 'Вы не можете добавить сами себя.';

define('ERR_M_PASSPORT_INCORRECT_FRIEND_EXISTS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_FRIEND_EXISTS]
	= "Заявка уже была отправлена.<br/>Повторно заявка отправлена не будет.";

define('ERR_M_PASSPORT_FRIEND_INVITE_REFUSE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_FRIEND_INVITE_REFUSE]
     = 'Заявка отклонена.';

define('ERR_M_PASSPORT_FRIEND_INVITE_REFUSE_ALL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_FRIEND_INVITE_REFUSE_ALL]
     = 'Все заявки отклонены.';

define('ERR_M_PASSPORT_FRIEND_INVITE_APPROVED', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_FRIEND_INVITE_APPROVED]
     = 'Заявка принята.';

define('ERR_M_PASSPORT_FRIEND_INVITE_REMOVE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_FRIEND_INVITE_REMOVE]
     = 'Пользователь удален из списка друзей.';

define('ERR_M_PASSPORT_FRIEND_INVITE_SENT', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_FRIEND_INVITE_SENT]
     = 'Пользовател получил уведомление и подтвердит, что Вы его друг.';

// FOR PLACES BEGIN

define('ERR_M_PASSPORT_INCORRECT_PT_GENERAL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PT_GENERAL]
     = 'Пожалуйста укажите место работы.';

define('ERR_M_PASSPORT_INCORRECT_PT_HIGHER_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PT_HIGHER_EDUCATION]
     = 'Пожалуйста укажите учебное заведение.';

define('ERR_M_PASSPORT_INCORRECT_PT_SECONDARY_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PT_SECONDARY_EDUCATION]
     = 'Пожалуйста укажите школу.';

define('ERR_M_PASSPORT_INCORRECT_PT_OTHERS', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PT_OTHERS]
     = 'Пожалуйста укажите место.';

define('ERR_M_PASSPORT_INCORRECT_ADDRESS_PT', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_ADDRESS_PT]
     = 'Адрес указан не верно.';

define('ERR_M_PASSPORT_INCORRECT_PLACE_PT_GENERAL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PLACE_PT_GENERAL]
     = 'Не удалось добавить место работы.';

define('ERR_M_PASSPORT_INCORRECT_PLACE_PT_HIGHER_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PLACE_PT_HIGHER_EDUCATION]
     = 'Не удалось добавить место высшего образования.';

define('ERR_M_PASSPORT_INCORRECT_PLACE_PT_SECONDARY_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PLACE_PT_SECONDARY_EDUCATION]
     = 'Не удалось добавить место высшего образования.';

define('ERR_M_PASSPORT_INCORRECT_PLACE_PT', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_PLACE_PT]
     = 'Не удалось добавить место.';

define('ERR_M_PASSPORT_INCORRECT_YEARS_PT_GENERAL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_YEARS_PT_GENERAL]
     = 'Год окончания работы не может быть меньше года начала работы.';

define('ERR_M_PASSPORT_INCORRECT_YEARS_PT_HIGHER_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_YEARS_PT_HIGHER_EDUCATION]
     = 'Год окончания обучения не может быть меньше года начала обучения.';

define('ERR_M_PASSPORT_INCORRECT_YEARS_PT_SECONDARY_EDUCATION', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_YEARS_PT_SECONDARY_EDUCATION]
     = 'Год окончания обучения не может быть меньше года начала обучения.';

// FOR PLACES END

// OFF-line registration BEGIN

define('ERR_M_PASSPORT_INCORRECT_OFFLINE_REGISTER_SECRET_KEY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_OFFLINE_REGISTER_SECRET_KEY]
     = 'Неверный секретный ключ.';

define('ERR_M_PASSPORT_INCORRECT_OFFLINE_ACTIVATION_CODE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_OFFLINE_ACTIVATION_CODE]
     = 'Неверный код активации.';

// OFF-line registration END

// profile AUTO BEGIN

define('ERR_M_PASSPORT_AUTO_NOT_FOUND', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_NOT_FOUND]
     = 'Автомобиль не найден.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_MARKA_MODEL', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_MARKA_MODEL]
     = 'Марка и/или модель автомобиля не заданы или не верны.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_CAPACITY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_CAPACITY]
     = 'Не задано количество пассажирских мест в автомобиле.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_YEAR', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_YEAR]
     = 'Не задан год выпуска автомобиля.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_VOLUME', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_VOLUME]
     = 'Не задан объем двигателя автомобиля.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_WHEELTYPE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_WHEELTYPE]
     = 'Не задан тип руля в автомобиле.';
define('ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO]
     = 'Ошибка при загрузке фотографии.';
define('ERR_M_PASSPORT_AUTO_INCORRECT_ANKETA', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_AUTO_INCORRECT_ANKETA]
     = 'Ошибка в анкете.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_FIRSTNAME_EMPTY]
     = 'Вы не заполнили поле Имя.';
define('ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_SETTINGS_LASTNAME_EMPTY]
     = 'Вы не заполнили поле Фамилия.';
// profile AUTO END

// delete profile
define('ERR_M_PASSPORT_NOT_ISSET_CHECKBOX_DELETE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_NOT_ISSET_CHECKBOX_DELETE]
     = 'Вы не поставили галочку на удаление учетной записи.';
     
define('ERR_M_PASSPORT_ERROR_LENGTH_PHONE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_ERROR_LENGTH_PHONE]
     = 'Номер телефона должен состоять из 11-ти цифр.';

define('ERR_M_PASSPORT_IS_REGISTER_PHONE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_IS_REGISTER_PHONE]
     = 'Указанный номер уже подтверждён.';

define('ERR_M_PASSPORT_SEND_SMS_ERROR', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_SEND_SMS_ERROR]
     = 'Ошибка отправки кода';
     
define('ERR_M_PASSPORT_CHECK_CODE_FAILURE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_CHECK_CODE_FAILURE]
     = 'Неправильный код подтверждения';
	 
define('ERR_M_PASSPORT_INCORRECT_POSTCODE', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_INCORRECT_POSTCODE] = 'Неверно указан почтовый индекс';

define('ERR_M_PASSPORT_CITY_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_CITY_EMPTY] = 'Не указан город';

define('ERR_M_PASSPORT_CITY_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_CITY_EMPTY] = 'Не указан город';

define('ERR_M_PASSPORT_STREET_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_STREET_EMPTY] = 'Не указана улица';

define('ERR_M_PASSPORT_HOUSE_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_HOUSE_EMPTY] = 'Не указан номер дома';

define('ERR_M_PASSPORT_APARTMENT_EMPTY', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_APARTMENT_EMPTY] = 'Не указан номер квартиры';

define('ERR_M_PASSPORT_PHONE_INCORRECT', ERR_M_PASSPORT_MASK | $error_code++);
UserError::$Errors[ERR_M_PASSPORT_PHONE_INCORRECT] = 'Не верно указан номер телефона';
	 
	
     
// пока инициализация здесь, после теста уедет в ядро
LibFactory::GetStatic('application');
class Mod_Passport extends ApplicationBaseMagic
{
	protected $_page = 'default';
	protected $_cache = null;
	protected $_lib_mail = null;
	protected $_examples = array();
	protected $_ssp = null;
	protected $_RoleKey = null;
	protected $_UniqueID = null;

	public function __construct()
	{		
		parent::__construct('passport');		
		
	}

	public function Action($params)
	{
		$url = '';
		
		if(!empty($_SERVER["HTTP_REFERER"]) && !preg_match('@^http:\/\/[\w\._\-\@]+\/passport@', $_SERVER["HTTP_REFERER"]))
			$url = $_SERVER["HTTP_REFERER"];
		if($_SERVER['REQUEST_METHOD'] == 'GET')
			$_url = $_GET['url'];
		else
			$_url = $_POST['url'];
		if(!empty($_url) && !preg_match('@^http:\/\/[\w\._\-\@]+\/passport@', $_url))
			$url = $_url;

		$url = rawurldecode($url);

		if((!empty($url) || empty($_SERVER["HTTP_REFERER"])) && !headers_sent())
		{
			//set domain 
			if(0 === strpos($_SERVER['SERVER_NAME'], 'm.'))
			{
				$deskDomain = substr($_SERVER['SERVER_NAME'], 2);
				$mobileDomain = $_SERVER['SERVER_NAME'];
			}
			else
			{
				$deskDomain = $_SERVER['SERVER_NAME'];
				$mobileDomain = 'm.'.$_SERVER['SERVER_NAME'];
			}

			setcookie('burl', $url, time() + 604800, '/', $deskDomain);
			setcookie('burl', $url, time() + 604800, '/', $mobileDomain);
			$_COOKIE['burl'] = $url; // на текущий реквест
		}

		$this->_ActionModRewrite($params);
		$this->_ActionPost();
	}

	public function Init()
	{
		global $CONFIG, $OBJECTS;
		LibFactory::GetStatic('cache');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'passport');
	}

	public function AppInit($params)
	{
		global $CONFIG, $OBJECTS;
		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('subsection');
		$this->_ssp = SubsectionProviderFactory::GetInstanceApp($this->Name, $this->Folder);
		$this->_ssp->AddLocation(array());

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'passport');

	}

	protected function redirect_not_authorized()
	{
		global $CONFIG;
		$shema = STreeMgr::GetNodeByID($this->_env['site']['tree_id'])->IsSSL ? 'https://' : 'http://';
		#Response::Redirect($shema.$this->_env['site']['domain'].'/'.$this->_env['section'].'/'.$this->_config['files']['get']['login']['string'].'?url='.App::$Request->Server['REQUEST_URI']->Url());
		# здесь пока поставим так:

		Response::Redirect($shema.$_SERVER['HTTP_HOST'].'/'.$this->_env['section'].'/'.$this->_config['files']['get']['login']['string'].'?url='.App::$Request->Server['REQUEST_URI']->Url());
	}

	protected function redirect_authorized()
	{
		#Response::Redirect('http://'.$this->_env['site']['domain'].'/'.$this->_env['section'].'/'.$this->_config['files']['get']['mypage']['string']);
		# здесь пока поставим так:

		Response::Redirect('http://'.$_SERVER['HTTP_HOST'].'/'.$this->_env['section'].'/'.$this->_config['files']['get']['mypage_person']['string']);
	}

	public function &GetPropertyByRef($name)
	{
		global $OBJECTS;

		$name = strtolower($name);
		if ($name == 'id')
			return $this->_UniqueID;
		elseif ($name == 'rolekey')
			return $this->_RoleKey;

		return parent::GetPropertyByRef($name);
	}

	public function SSP($id)
	{
		if($this->_ssp !== null)
			return $this->_ssp->CreateKey(array('id' => $id));
		else
			return 's'.$id;
	}
}

?>