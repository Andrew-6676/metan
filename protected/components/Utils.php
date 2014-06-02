<?php
class Utils {
	public static function getMonthName($month)
	{
		$ru_month = array('--','январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
		return $ru_month[$month];
	}
}