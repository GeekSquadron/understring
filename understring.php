<?php 
/**
 * PHP port of the Underscore.string javascript library
 * (https://github.com/epeli/underscore.string)
 *
 * @author Ahmad Shah Hafizan Hamidin <ahmadshahhafizan@gmail.com>
 * @version 0.1
 */

class __ {

	/**
	 * [$_instance description]
	 * @var [type]
	 */
	private static $_instance;

	/**
	 * [$_chained description]
	 * @var boolean
	 */
	private $_chained = false;

	/**
	 * [$_lv description]
	 * @var boolean
	 */
	private $_lv = false;
	
	/**
	 * [$_string description]
	 * @var [type]
	 */
	public $_string;

	/**
	 * [getInstance description]
	 * @return [type] [description]
	 */
	public static function getInstance()
	{
		if ( ! isset(self::$_instance))
		{
			$c = __CLASS__;
			self::$_instance = new $c;
		}

		return self::$_instance;
	}

	/**
	 * Check wether if the string is blank or not
	 * 
	 * @param  string  $str
	 * @return boolean
	 */
	private function _isBlank($str)
	{
		$this->_string = preg_match('/^[\s]*$/', $str) ? true : false;
		return $this;
	}

	/**
	 * Capitalize every first characters
	 * 
	 * @param  string $str
	 * @return string
	 */
	private function _capitalize($str)
	{
		$this->_string = ucwords($str);
		return $this;
	}

	/**
	 * Swap between uppercase and lowercase characters
	 * 
	 * @param  string $str
	 * @return string
	 */
	private function _swapCase($str)
	{
		$this->_string = preg_replace_callback('/[a-zA-Z]/', function($matches) { return (ctype_upper($matches[0])) ? strtolower($matches[0]) : strtoupper($matches[0]); }, $str);
		return $this;
	}

	/**
	 * Reverse the string
	 * 
	 * @param  string $str
	 * @return string
	 */
	private function _reverse($str)
	{
		$this->_string = strrev($str);
		return $this;
	}

	/**
	 * Join two words into a sentence using the glue
	 * 
	 * @param  string $str
	 * @param  string $substr
	 * @param  string $glue
	 * @return string
	 */
	private function _join($str, $substr, $glue)
	{
		$this->_string = $str . $glue . $substr;
		return $this;
	}

	/**
	 * Split the string into array
	 * 
	 * @param  string $str
	 * @return array
	 */
	private function _lines($str)
	{
		$this->_string = preg_split('/\n/', $str);
		return $this;
	}

	/**
	 * Remove all whitespaces before and after from the string
	 * 
	 * @param  string $str
	 * @return string
	 */
	private function _trim($str)
	{
		$this->_string = trim($str);
		return $this;
	}

	/**
	 * Remove all extra whitespaces and spaces
	 * 
	 * @param  string $str
	 * @return string
	 */
	private function _clean($str)
	{
		$this->_string = trim(preg_replace('/\s+/', ' ', $str));
		return $this; 
	}

	/**
	 * Split the string into array
	 * 
	 * @param  string  $str
	 * @param  integer $length
	 * @return array
	 */
	private function _chop($str, $length = 1)
	{
		$this->_string = str_split($str, $length);
		return $this;
	}

	/**
	 * Split the string into array
	 * 
	 * @param  string $str
	 * @return array
	 */
	private function _chars($str)
	{
		return $this->chop($str);
	}

	/**
	 * [_includes description]
	 * @param  [type] $haystack [description]
	 * @param  [type] $needle   [description]
	 * @return [type]           [description]
	 */
	private function _includes($haystack = null, $needle)
	{
		$this->_string = (strpos($haystack, $needle) !== false) ? true : false;

		return $this;
	}

	/**
	 * [_includes description]
	 * @param  [type] $haystack [description]
	 * @param  [type] $needle   [description]
	 * @return [type]           [description]
	 */
	private function _numberFormat($number = null, $decimals = 0, $decimal_seperator = '.', $order_seperator = ',')
	{
		$this->_string = number_format($number, $decimals, $decimal_seperator, $order_seperator);
		return $this;
	}

	/**
	 * [_levenshtein description]
	 * @param  [type]  $str        [description]
	 * @param  [type]  $comparison [description]
	 * @param  boolean $percentage [description]
	 * @return [type]              [description]
	 */
	private function _levenshtein($str, $comparison, $percentage = false)
	{
		$this->_lv = true;
		$this->_levenshtein[1] = $comparison;

		$this->_levenshtein[0] = levenshtein($str, $comparison);

		if ((bool)$percentage)
		{
			$max_length = (strlen($str) > strlen($comparison)) ? strlen($str) : strlen($comparison);

			$this->_levenshtein[2] = round((1 - $this->_levenshtein[0] / $max_length) * 100);
		}

		return $this;
	}

	/**
	 * [_escapeHTML description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	private function _escapeHTML($str)
	{
		$this->_string = htmlspecialchars($str, ENT_QUOTES);
		return $this;
	}

	/**
	 * [_unescapeHTML description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	private function _unescapeHTML($str)
	{
		$this->_string = htmlspecialchars_decode($str, ENT_QUOTES);
		return $this;
	}

	/**
	 * [_stripTags description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	private function _stripTags($str)
	{
		$this->_string = strip_tags($str);
		return $this;
	}

	/**
	 * [_value description]
	 * @return [type] [description]
	 */
	private function _value()
	{
		return (isset($this) and isset($this->_string) and $this->_chained) ? 
			(( ! (bool)$this->_lv) ? $this->_string : array('string' => $this->_string, 'comparison' => $this->_levenshtein[1], 'distance' => $this->_levenshtein[0], 'percentage' => $this->_levenshtein[2])) : null;
	}

	/**
	 * [__callStatic description]
	 * @param  [type] $method [description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public static function __callStatic($method, $params)
    {
    	$i = self::getInstance();

    	if ($method == 'chain')
    	{
    		$i->_chained = true;
    		$i->_string = $params[0];

    		return $i;
    	}

    	$i->_chained = false;
    	$i->_lv = false;

    	$m = '_'.$method;
    	return $i->__call($method, $params);
    }

    /**
     * [__call description]
     * @param  [type] $method [description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function __call($method, $params)
	{
		$m = '_'.$method;
		$params[0] = ((bool)$this->_chained) ? $this->_string : $params[0];

		$output = call_user_func_array(array($this, $m), $params);
		return ((bool)$this->_chained) ? $output : (((bool)$this->_lv) ? array('string' => $params[0], 'comparison' => $params[1], 'distance' => $this->_levenshtein[0], 'percentage' => $this->_levenshtein[2]) : $this->_string);
	}

}