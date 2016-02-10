<?php

	/*$DBF = new dbf(Yii::app()->params['pathToDBF'].'f160005.dbf');

	if ($DBF) {
		$rc = $DBF->count();
		echo 'Записей: '.$rc.'<br>';

		for ($i=1;$i<=10;$i++) {
			$row = $DBF->readRec();
			echo $i.' - [';
			echo $row['KPO'].'] - ';
			echo mb_convert_encoding($row['NPO'], "UTF-8", "cp866").'<br>';
		}

	}*/

class dbf
{
	public $table = NULL;
	private $recNo = 0;
	private $filter = NULL;
	private $recCount = -1;

/*-----------------------------------------------------------------------------------*/
	public function __construct($file, $opt=0){
		$this->table = dbase_open($file, $opt);
		$this->recCount = dbase_numrecords($this->table);
	}
/*-----------------------------------------------------------------------------------*/
	public function readRec(){
			// проверяем, не достигнут ли конец файла
		if ($this->recNo != $this->count()) {
			$this->recNo += 1;
			//echo '/'.$this->recNo.'/' ;

				// считываем запись
			$rec = dbase_get_record_with_names($this->table, $this->recNo);
				// если она помечена на удаление - считываем следующую запись
			if ($rec['deleted']) {
				return $this->readRec();
			} else {
										if ($this->apply_filter($rec)) {
						//					echo '*';
											return $rec;
										} else {
											return $this->readRec();
										}
				return $rec;
			}

//			return $rec;
//			echo '%';
		} else {
			return false;
		}
	}
/*-----------------------------------------------------------------------------------*/
	public function getRec($recNo = -1) {
		if ($recNo < 0) { $recNo = $this->recNo; }
		return dbase_get_record_with_names($this->table,$recNo);
	}
/*-----------------------------------------------------------------------------------*/
	public function recNo($value=''){
		return $this->recNo;
	}
/*-----------------------------------------------------------------------------------*/
	public function count(){
		return $this->recCount;
	}
/*-----------------------------------------------------------------------------------*/
	public function go_to($rec){
		$this->recno = $rec;
	}
/*-----------------------------------------------------------------------------------*/
	public function go_top(){
		$this->recno = 0;
	}
/*-----------------------------------------------------------------------------------*/
	public function go_bottom(){
		$this->recno = $this->count()-1;
	}
/*-----------------------------------------------------------------------------------*/
	public function getFields() {
		//$str = '';
		$f = array();
		$row = dbase_get_record_with_names($this->table, 1);
		return array_keys($row);
		// foreach ($row as $key => $value) {
		// 	//$str .= $key.',';
		// 	$f[] = $key;
		// }
		// return	$f;
	}
/*-----------------------------------------------------------------------------------*/
	public function setFilter($filter) {
//		preg_match_all('/\[(\w+)\]=(\w+)/', $filter, $matches);
		preg_match_all('/\[(\w+)\]([<=>like ]+)(\w+)/', $filter, $matches);
//		$filter_a[] = array('f'=>$matches[1][0], 'r'=>$matches[2][0], 'p'=>$matches[3][0]);
		$filter_a[0] = array_combine($matches[1], $matches[3]);
		$filter_a[1] = array_combine($matches[1], $matches[2]);
		$this->filter = $filter_a;
		print_r($this->filter);
//		print_r($matches);
	}
/*-----------------------------------------------------------------------------------*/
	public function apply_filter_old($row) {
//		return false;
		if (!$this->filter) { return true;}

		$accept = true;
		// цикл по строкам фильтра
		foreach ($this->filter[0] as $f => $v) {
			// сравниваем поля с фильтром поочерёдно
			// $f - имя поля
			// $v - значение фильтра
			//echo "<br>$f:  <u>$row[$f]</u>  -  $v ";
			if ($row[$f]==$v) {
				$accept = true;
			//	echo " ---> true ";
			} else {
				$accept = false;
			//	echo " ---> false";
			}
		}

		return $accept;
	}
	/*-----------------------------------------------------------------------------------*/
/*  [KO]=00;[DATA]=20150801
	[DATA] like 201508;[KP]==1410
*/
	public function apply_filter($row) {
//		return false;
		if (!$this->filter) { return true;}

		$accept = true;
		// цикл по строкам фильтра
		foreach ($this->filter[0] as $f => $v) {
			// сравниваем поля с фильтром поочерёдно
			// filter[0][$f=>$v] - имя поля и значение фильтра
			// filter[1][$f] - операция сравнения
			//echo "<br>$f:  <u>$row[$f]</u>  -  $v ";
			if ($this->filter[1][$f]==' like ') {
//				substr_count
				$val = '$bool=strpos("'.$row[$f].'","'.$v.'");';
			} else {
				$val = '$bool=(' . $row[$f] . $this->filter[1][$f] . $v . ');';
			}
//			echo $val;

//			exit;

			eval($val);
//			var_dump($bool);
//			exit;

			if ($bool!==false) {
				$accept = true;
//					echo " ---> true ";
			} else {
//				$accept = false;
				return false;
//					echo " ---> false";
			}
		}

		return $accept;
	}
/*-----------------------------------------------------------------------------------*/
	public function getRows($filter) {
		/*
			$filter - строка вида "dist#[id]=34,[date]=20140430"
						(все записи или только уникальные - dist/all)#[поле]=значение
			пробегаеся по сем записям и запоминаем в возвращаемом масиве нужное
		*/
			// массив условий поиска
		//echo '<pre>';
		preg_match_all('/\[(\w+)\]=(\w+)/', $filter, $matches);
		//print_r($matches);
		//echo substr(string, start)
		//print_r(preg_match('/all#/', $filter));
		//echo '<br>';
		$filter_a = array_combine($matches[1], $matches[2]);
		//print_r($filter);

		//$f = array();
		$result = array();
		$i=0;
		while($row = $this->readRec())	// цмкл по записям
		{
			$accept = false;
				// цикл по строкам фильтра
			foreach ($filter_a as $f => $v) {
				// сравниваем поля с фильтром поочерёдно
				// $f - имя поля
				// $v - значение фильтра
				//echo "<br>$f:  <u>$row[$f]</u>  -  $v ";
				if ($row[$f]==$v) {
					$accept = true;
					//echo " ---> true ";
				} else {
					$accept = false;
					//echo " ---> false";
				}
			}
				// если запись удовлетворила всем
			if ($accept) {
				$result[] = $row;
				$i++;
				if (preg_match('/dist#/', $filter)) {
					return $result;
				};
				//echo ' ----------------- <b>ACCEPT</b>  <br>';
			} else {
				//echo ' ----------------- <i>cancel</i>  <br>';
			}
			//if ($i==10) {		return $result; }
		}
		//print_r($i);
		//echo '<br>';
		//print_r($result);

		//echo '</pre>';

		return $result;
	}
/*-----------------------------------------------------------------------------------*/
}