<?php

class SuperdocWidget extends CWidget
{
	public $data        = null;
	public $mode        = null;
	public $columns     = null;
	public $head        = null;
	public $sumcolumns  = null;
	public $sums        = null;
	public $buttons     = null;
	public $cssFile     = null;

	public function init()
	{
		// этот метод будет вызван внутри CBaseController::beginWidget()
		// $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'delivery.css';
		$cssFile = Yii::app()->request->baseUrl . '/css/widgets/superdoc/' . 'superdoc.css';
		$jsFile = Yii::app()->request->baseUrl . '/js/widgets/superdoc/' . 'superdoc.js';
		// $this->cssFile=Yii::app()->getAssetManager()->publish($file);
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($cssFile);
		$cs->registerScriptFile($jsFile);
		parent::init();
	}

	private function format_type($val, $type)
	{
		$style = '-';
//		var_dump(strpos($type, 'character'));
		if (trim($val)=='') {
			return array('val' => $val, 'style' => 'empty');
		}

		if (strpos($type, 'numeric') !== false) {
			$val = number_format($val, '0', '.', '`');
			$style = 'r';
		}
		if (strpos($type, 'integer') !== false) {
			$val = number_format($val, '0', '.', '`');
			$style = 'r';
		}
		if (strpos($type, 'character') !== false) {
//			$val = number_format($val,'0','.','`');
			$style = 'l';
		}
		if (strpos($type, 'real') !== false) {
//			$val = number_format($val,'0','.','`');
			$style = 'r';
		}
		if (strpos($type, 'date') !== false) {
			$d = explode('-', $val);
			$val = date('d.m.Y', mktime(0, 0, 0, $d[1], $d[2], $d[0]));
			$style = 'c';
		}
		return array('val' => $val, 'style' => $style);
	}

	private function formula($formula)
	{

	}

	/*------------------------------------------------------------------------*/
	public function run()
	{
		// этот метод будет вызван внутри CBaseController::endWidget()
		// print_r($this->data);
		// echo '<br>';
		//echo $this->items.'<br>';
		echo '<pre>';
//	    print_r($this->data[0]->attributes);
//	    print_r($this->data[0]->contact->attributes);
//	    print_r($this->data[0]->documentdata[0]->attributes);
//		print_r($this->head);
//	    print_r($this->columns);

		$for = array('-1'=>'-','1'=>'Общий товарооборот','2'=>'Розничный товарооборот','3'=>'Собственные нужды');

		$data_arr = array();
		$type_arr = array();
		foreach ($this->data as $data_row) {
			$data_arr[$data_row->id] = $data_row->attributes;
			// типы плей в отдельный массив
			foreach ($data_row->attributes as $attr => $dr) {
				$type_arr[$attr] = Document::model()->tableSchema->getColumn($attr)->dbType;
			}

			$data_arr[$data_row->id]['contact'] = $data_row->contact->attributes;
			// типы плей в отдельный массив
			foreach ($data_row->contact->attributes as $attr => $dr) {
				$type_arr['contact'][$attr] = Contact::model()->tableSchema->getColumn($attr)->dbType;
			}

			$data_arr[$data_row->id]['operation'] = $data_row->operation->attributes;
			// типы плей в отдельный массив
			foreach ($data_row->operation->attributes as $attr => $dr) {
				$type_arr['operation'][$attr] = Operation::model()->tableSchema->getColumn($attr)->dbType;
			}

//			$data_arr[$data_row->id]['docaddition'] = $data_row->docaddition->attributes;
			// типы плей в отдельный массив
//			foreach ($data_row->operation->attributes as $attr => $dr) {
//				$type_arr['operation'][$attr] = Operation::model()->tableSchema->getColumn($attr)->dbType;
//			}

			foreach ($data_row->documentdata as $documentdata_row) {
				$data_arr[$data_row->id]['documentdata'][$documentdata_row->id] = $documentdata_row->attributes;
				// типы плей в отдельный массив
				foreach ($documentdata_row->attributes as $attr => $dr) {
					$type_arr['documentdata'][$attr] = Documentdata::model()->tableSchema->getColumn($attr)->dbType;
				}
				$data_arr[$data_row->id]['documentdata'][$documentdata_row->id]['goods'] = $documentdata_row->goods->attributes;
				// типы плей в отдельный массив
				foreach ($documentdata_row->goods->attributes as $attr => $dr) {
					$type_arr['documentdata']['goods'][$attr] = Goods::model()->tableSchema->getColumn($attr)->dbType;
				}
			}
		}
//	    print_r($type_arr);
//		print_r(array_shift($data_arr));
//	    return;

		echo '</pre>';

		echo '<table id="table" class="parent">';
		// вывод главной шапки
		echo '<tr class="parent_header">';
		foreach ($this->head as $col => $title) {
			echo '<th>' . $title . '</th>';
		}
		echo '</tr>';
		// вывод данных
		foreach ($this->data as $doc) {
			echo '<tr class="parent_row" id="' . $doc->id . '"">';
			// вывод данных шапки
			foreach ($this->head as $col => $title) {
				$key = explode('.', $col);
				$estr = '$val = $doc["' . implode('"]["', $key) . '"];';
				eval($estr);
				$tstr = '$type = $type_arr["' . implode('"]["', $key) . '"];';
				eval($tstr);

				//костыль
				if ($col=='for') {
					$val = $for[$doc->for];
					$type = 'character';
				}
				echo '<td>' . $this->format_type($val, $type)['val'] . '</td>';
			}
			echo '</tr>';

			// вывод содержимого документа
			echo '<tr id="ch_' . $doc->id . '" class="child_row hidden">';
			echo '<td colspan="' . count($this->head) . '">';
			echo '<table class="child"><thead>';
			// подшапка
			echo '<tr id="doc_hat_' . $doc->id . '" class="doc_hat">';
			echo '<td colspan="' . (count($this->columns) + 1) . '">';
			$capt = Array();
			foreach ($this->head as $col => $title) {
				$key = explode('.', $col);
				$estr = '$val = $doc["' . implode('"]["', $key) . '"];';
				eval($estr);
				$tstr = '$type = $type_arr["' . implode('"]["', $key) . '"];';
				eval($tstr);
				$str = '';
				switch ($col) {
					case 'contact.name':
						$str = "id_contact=" . $doc->id_contact;
						break;
					case 'operation.name':
						$str = "id_operation=" . $doc->id_operation;
						break;
					case 'for':
						$str = 'id_for="'.$doc->for.'"';
						$val = $for[$doc->for];
						$type = 'character';
						break;
				}
				$capt[] = '<span  class="capt">' . $title . ':</span>' .
					'<span ' . $str . ' class="' . $col . '">' . $this->format_type($val, $type)['val'] . '</span>';
			}
			echo implode('<br>', $capt);
			echo "<div class='buttons' doc_id='" . $doc->id . "'>";
			foreach ($this->buttons as $button) {
				echo "<button class='" . $button . "_doc_button'>";
			}
			echo "</div>";
			echo '</td>';
			echo '</tr>';
			// заголовки столбцов табличной части
			echo '<tr>';
			echo '<th class="caption_">';
			echo '№<br>п.п.';
			echo ' </th>';
			foreach ($this->columns as $col => $title) {
				echo '<th>' . $title . '</th>';
			}
			echo ' </th>';
			echo '</tr>';
			echo '</thead>';

//			    echo '<tr>';
			$i = 0;
			// табличная часть (строки документа, данные)
			foreach ($doc['documentdata'] as $docdata_row) {
				echo '<tr docdata_id="' . $docdata_row['id'] . '">';
				$c = 0;
				echo '<td class="cell c' . ++$c . '">' . (++$i) . ' </td>';
				foreach ($this->columns as $dcol => $title) {
					// если написана формула - высчитвваем
					//
					if (strpos($dcol, '=') !== false) {
						$t = explode('*', substr($dcol, 1));
						$m = implode('*', $t);
						$val = $docdata_row[$t[0]] * $docdata_row[$t[1]];
						$tmp = $this->format_type($val, 'integer');
//				                echo '<td >'.$this->format_type($val,'integer')['val'].'</td>';
					} else {
						$key = explode('.', $dcol);
						$estr = '$val = $docdata_row["' . implode('"]["', $key) . '"];';
						eval($estr);
						$tstr = '$type = $type_arr["documentdata"]["' . implode('"]["', $key) . '"];';
						eval($tstr);
							// костыль - вывести код товара как строку, а не число
						if ($dcol=='id_goods') {$type = 'character';}
						$tmp = $this->format_type($val, $type);
//				                echo '<td class="cell c' . ++$c . ' ' . $tmp['style'] . '">' . $tmp['val'] . '</td>';
					}
					echo '<td class="cell c' . ++$c . ' ' . $tmp['style'] . '">' . $tmp['val'] . '</td>';
				}
				echo '</tr>';
			}
//					    echo '<td class="cell_">';
//					        echo '';
//					    echo ' </td>';

			echo '</tr>';

			echo '</table></td></tr>';
		}


		echo '</table>';

		parent::run();
		return;
		/*-------------------------------------------------------------------------------------*/

//		echo '<table id="table" class="parent">';
//
//		$caption1 = Document::model()->attributeLabels();
//		foreach ($this->data as $doc) {
//			$d = explode('-', $doc->doc_date);
//			$doc_date = date('d.m.Y', mktime(0, 0, 0, $d[1], $d[2], $d[0]));
//			$j = 0;
//			// родительская таблица
//			echo '<tr class="parent_row" id="' . $doc->id . '"">';
//			// 			echo '<td class="p_caption_'.$j.'">';
//			// 	echo 'ТТН №:';
//			// 	//echo $caption1['doc_num'].':';
//			// echo ' </td>';
//			echo '<td class="p_cell_' . $j++ . '">';
//			echo $doc->doc_num;
//			echo ' </td>';
//			// echo '<td class="p_caption_'.$j.'">';
//			// 	echo 'Дата:';
//			// echo ' </td>';
//			echo '<td class="p_cell_' . $j++ . '">';
//			echo $doc_date;
//			echo ' </td>';
//			// echo '<td class="p_caption_'.$j.'">';
//			// 	echo 'Приход от:';
//			// echo ' </td>';
//			echo '<td class="p_cell_' . $j++ . '">';
//			echo $doc->idContact->name;
//			echo ' </td>';
//			echo '<td class="p_cell_' . $j++ . '">&nbsp</td>';
//			echo '</tr>';
//
//			// подчинённаятаблица
//
//			$c = 0;
//			$caption2 = Documentdata::model()->attributeLabels();
//
//			echo '<tr id="ch_' . $doc->id . '" class="child_row hidden">';
//			echo '<td colspan="4">';
//			echo '<table  class="child">';
//			echo '<thead>';
//			echo '<tr id="doc_hat_' . $doc->id . '" class="doc_hat">';
//			echo '<td colspan="10">';
//			echo '<span class="capt">ТТН №:</span><span class="doc_num">' . $doc->doc_num . '</span>';
//			echo '<br><span class="capt">Дата:</span><span class="doc_date">' . $doc_date . '</span>';
//			echo '<br><span class="capt">Приход от:</span>' . $doc->idContact->name;
//			echo "<div class='buttons' doc_id='" . $doc->id . "'><button class='print_doc_button'></button><button class='del_doc_button'></button>" ./*<button class='edit_doc_button'>edit_doc</button>*/
//				"</div>";
//			echo '</td>';
//			echo '</tr>';
//			echo '<tr>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo '№<br>п.п.';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Код';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Наименование товара';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Оптовая<br>цена';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Наценка';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'НДС';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Розничная<br>цена';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Кол-во';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Сумма<br>опт';
//			echo ' </th>';
//			echo '<th class="caption_' . $c++ . '">';
//			echo 'Сумма<br>розница';
//			echo ' </th>';
//			echo '</tr>';
//			echo '</thead>';
//			$i = 0;
//			foreach ($doc->documentdata as $dnotelist) {
//				$c = 0;
//				echo '<tr>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo ++$i;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo $dnotelist->idGoods->id;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo $dnotelist->idGoods->name;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo number_format($dnotelist->cost, '0', '.', '`');
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo $dnotelist->markup;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo $dnotelist->vat;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo number_format($dnotelist->price, '0', '.', '`');
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo $dnotelist->quantity;
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo number_format($dnotelist->quantity * $dnotelist->cost, '0', '.', '`');
//				echo ' </td>';
//				echo '<td class="cell_' . $c++ . '">';
//				echo number_format($dnotelist->quantity * $dnotelist->price, '0', '.', '`');
//				echo ' </td>';
//				echo '</tr>';
//			}
//			echo "</table></td></tr>";
//		}
//		echo '</table>';
//		echo '<br>';
//		echo '<br>';
//		echo '<br>';
		//	print_r($this->data);

//		parent::run();
	}
}

