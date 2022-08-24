<?php

interface ISphinxPlugin {

	/**
     * Возвращает данные для отображения в результатах поиска
	 * @param $attr array
     * @return array
     */
	function GetObjectData(array $attr);

	function __get($name);
}