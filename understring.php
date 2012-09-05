<?php 

class __ {

	private static $_instance;

	public static function getInstance()
	{
		if ( ! isset(self::$_instance))
		{
			$c = __CLASS__;
			self::$_instance = new $c;
		}

		return self::$_instance;
	}

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
    	$m = '_'.$method;
    	return $i->__call($method, $params);
    }

    public function __call($method, $params)
	{
		$m = '_'.$method;
		$params[0] = (isset($this->_string)) ? $this->_string : $params[0];

		$output = call_user_func_array(array($this, $m), $params);
		return ((bool)$this->_chained) ? $output : (((bool)$this->_lv) ? array('string' => $params[0], 'comparison' => $params[1], 'distance' => $this->_levenshtein[0], 'percentage' => $this->_levenshtein[2]) : $this->_string);
	}

	private function _value()
	{
		return (isset($this) and isset($this->_string) and $this->_chained) ? 
			(( ! (bool)$this->_lv) ? $this->_string : array('string' => $this->_string, 'comparison' => $this->_levenshtein[1], 'distance' => $this->_levenshtein[0], 'percentage' => $this->_levenshtein[2])) : null;
	}

	private function _capitalize($str = null)
	{
		$this->_string = ucwords($str);
		return $this;
	}

	private function _swapCase($str = null)
	{
		$this->_string = preg_replace_callback('/[a-zA-Z]/', function($matches) { return (ctype_upper($matches[0])) ? strtolower($matches[0]) : strtoupper($matches[0]); }, $str);
		return $this;
	}

	private function _trim($str = null)
	{
		$this->_string = trim($str);
		return $this;

	}

	private function _clean($str = null)
	{
		$pattern = '/\s+/';

		$this->_string = trim(preg_replace($pattern, ' ', $str));
		return $this; 
	}

	private function _chop($str = null, $length = 1)
	{
		$this->_string = str_split($str, $length);
		return $this;
	}

	private function _chars($str = null)
	{
		return $this->chop($str);
	}

	private function _includes($haystack = null, $needle)
	{
		$this->_string = (strpos($haystack, $needle) !== false) ? true : false;

		return $this;
	}

	private function _numberFormat($number = null, $decimals = 0, $decimal_seperator = '.', $order_seperator = ',')
	{
		$this->_string = number_format($number, $decimals, $decimal_seperator, $order_seperator);
		return $this;
	}

	private function _levenshtein($str = null, $comparison, $percentage = false)
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

	private function _count()
	{

	}

	private function _escapeHTML()
	{

	}

	private function _unescapeHTML()
	{

	}

}