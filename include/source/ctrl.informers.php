<?
/** Получение шаблонов СТПЛ в асинхронном режиме
 *  Цель: получать ответ по шаблону с подстановкой параметров
 *  Входные параметры:
 *  $params - array()
 *  $params['template'] - путь до шаблона
 *  $params['vars'] - переменные для вставки
 */
function source_ctrl_informers($params)
{
	LibFactory::GetStatic("informers");
	LibFactory::GetStatic("stpl");
	$informers = Informers::GetAllowedTemplates();
	if (!in_array($params['template'], $informers))
		return false;
	return STPL::Fetch($params['template'], $params['vars']);
}
?>