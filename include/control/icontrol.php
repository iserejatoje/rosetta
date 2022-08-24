<?php


/**
 * Базовый интерфейс элемента управления
 * @author danilin
 * @version 1.0
 * @created 29-июл-2009 16:31:53
 */
interface Control_IControl
{

	/**
	 * Отрисовать содержимое элемента управления
	 */
	public function Draw();
	
	public function GetCSS();

	/**
	 * Получить высоту
	 */
	public function GetHeight();
	
	public function GetName();

	/**
	 * Получить идентификатор
	 */
	public function GetID();

	/**
	 * Получить родителя, если создан не в элементе управления null
	 */
	public function GetParent();
	
	public function GetStateUrl($withprefix = true, $withother = false);
	public function GetStyle();

	/**
	 * Получить заголовок элемента управления
	 */
	public function GetTitle();

	/**
	 * Получить видимость
	 */
	public function GetVisible();

	/**
	 * Получить ширину
	 */
	public function GetWidth();

	/**
	 * Инициализация
	 * 
	 * @param params    Параметры инициализации, свойства элемента управления, для
	 * простоты задания через фабрику элементов управления
	 */
	public function Init($params);

	/**
	 * Отрендерить элемент управления, вызывается из движка, должен проверять видимость
	 */
	public function Render();
	
	/**
	 *
	 */
	public function PreRender();
	
	public function SetCSS($css);

	/**
	 * Установить высоту
	 * 
	 * @param height
	 */
	public function SetHeight($height);

	/**
	 * Установить идентификатор
	 * 
	 * @param id
	 */
	public function SetID($id);

	/**
	 * Установить родителя
	 * 
	 * @param parent
	 */
	public function SetParent($parent);
	
	public function SetStyle($name, $value);

	/**
	 * Установить заголовок
	 * 
	 * @param title
	 */
	public function SetTitle($title);

	/**
	 * Установить видимость
	 * 
	 * @param visible
	 */
	public function SetVisible($visible);

	/**
	 * Установить ширину
	 * 
	 * @param width
	 */
	public function SetWidth($width);

	/**
	 * Установить кастомный параметр, чтобы иметь возможность без создания нового класса прокидивать параметры в шаблоны
	 *
	 * @param name
	 * @param value
	 */
	public function SetCustomParam($name, $value);
	
	/**
	 * Получить кастомный параметр
	 *
	 * @param name
	 */
	public function GetCustomParam($name);
}
?>