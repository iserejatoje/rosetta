<?php


/**
 * @author danilin
 * @version 1.0
 * @created 03-авг-2009 11:26:46
 */
interface Source_ISource
{

}

interface Source_ISourceCountable extends Countable,Source_ISource
{
}

interface Source_ISourceCustom extends Source_ISource
{

	/**
	 * 
	 * @param param
	 * @param value
	 */
	public function setparam($param, $value);

}

interface Source_ISourceData extends Source_ISource
{

	public function fill();

}

interface Source_ISourceFilterable extends Source_ISource
{

	/**
	 * 
	 * @param field
	 * @param rule
	 * @param mask
	 */
	public function setfilter($field, $rule, $mask);

}

interface Source_ISourceHeaderInfo extends Source_ISource
{

	public function getheaderinfo();

}

interface Source_ISourceIterator extends Source_ISource, Iterator
{
}

interface Source_ISourceLimitable extends Source_ISource
{

	/**
	 * 
	 * @param start
	 * @param count
	 */
	public function setlimit($start, $count);

}

interface Source_ISourceSortable extends Source_ISource
{

	/**
	 * 
	 * @param field
	 * @param order
	 */
	public function setsort($field, $order);

}
?>