<?php
class Utils{
	public static $ru_month = array('1'=>'январь',
							 '2'=>'февраль',
							 '3'=>'март',
							 '4'=>'апрель',
							 '5'=>'май',
							 '6'=>'июнь',
							 '7'=>'июль',
							 '8'=>'август',
							 '9'=>'сентябрь',
							 '10'=>'октябрь',
							 '11'=>'ноябрь',
							 '12'=>'декабрь');

/*------------------------------------------------------------------------*/
	public static function getMonthName($month)
	{
		return self::$ru_month[$month];
	}
/*------------------------------------------------------------------------*/
	public static function getMonthList()
	{
		return self::$ru_month;
	}
/*------------------------------------------------------------------------*/
	public static function print_r($var)
	{
		echo '<pre>'."\n";
		print_r($var);
		echo '</pre>';
	}
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
}