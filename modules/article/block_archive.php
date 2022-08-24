<?php

	return '';
	/**
	* Возвращает список годов и месяцев архива
	*
	* @return array
	*  group - имя группы текущей (для URL)
	*  l_y - array
	*    link - ссылка
	*    name - название года
	*  l_m[$i] - array
	*    link - ссылка
	*    date - дата месяца (так удобнее, можно по разному форматировать на уровне шаблона)
	*/
	
	if ($OBJECTS['smarty']->is_Template($template) === false)
		$template = $this->_config['templates']['block_archive'];

	$params['cache'] = true;
	if( $lifetime < 86400 )
		$lifetime = 86400;

	$cacheid = $this->_env['section'].'|archive';
	$page = $this->RenderBlock(
		$template, array($params), array($this, '_block_archive'),
		$params['cache'], $lifetime, $cacheid
	);

	return $page;
?>