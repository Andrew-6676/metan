<?php

class SuperdocWidget extends CWidget
{
	public $data        = null;
	public $limit       = null;
	public $mode        = null;
	public $columns     = null;
	public $head        = null;
	public $group       = null;
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
		if (trim($val)=='' || trim($val)=='0') {
			return array('val' => $val, 'style' => 'r empty');
		}

		if (strpos($type, 'numeric') !== false) {
			$val = number_format($val, '2', '.', '&nbsp;');
			$style = 'r';
		}
		if (strpos($type, 'integer') !== false) {
			$val = number_format($val, '0', '.', '&nbsp;');
			$style = 'r';
		}
		if (strpos($type, 'character') !== false) {
//			$val = number_format($val,'0','.','&nbsp;');
			$style = 'l';
		}
		if (strpos($type, 'real') !== false) {
//			$val = number_format($val,'0','.','&nbsp;');
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

		/*
		структура документа:
		 - tr шапка документа (видимая)
		 - tr с таблицей (скрытая)
		   --- thead шапка документа + кнопки
		   --- tbody строки документа
		*/

		$for = array('-1'=>'-','1'=>'Общий товарооборот','2'=>'Розничный товарооборот','3'=>'Собственные нужды');

		$data_row->attributes[] = 'sum_cost';
		$data_row->attributes[] = 'sum_vat';
		$data_row->attributes[] = 'sum_price';
		$data_row->attributes[] = 'paymentorder';
		$data_row->attributes[] = 'prim';

		$data_arr = array();
		$type_arr = array();
		foreach ($this->data as $data_row) {
			$data_arr[$data_row->id] = $data_row->attributes;
			// типы плей в отдельный массив
			foreach ($data_row->attributes as $attr => $dr) {
				$type_arr[$attr] = Document::model()->tableSchema->getColumn($attr)->dbType;
			}
			$type_arr['sum_cost'] = 'integer';
			$type_arr['sum_vat'] = 'integer';
			$type_arr['sum_price'] = 'integer';
			$type_arr['paymentorder'] = 'character';
			$type_arr['prim'] = 'character';

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
		$gr = '';
		// вывод данных
		$cnt = 1;
		foreach ($this->data as $doc) {
			$hide = '';
			if ($this->limit!==null && $cnt++ > $this->limit) {
				$hide = 'hidden';
			}

				// группировка по месяцам
			if ($this->group) {
				$d = explode('-',$doc->{$this->group});
				if ($gr != $d[1].'.'.$d[0]) {
					$gr = $d[1] . '.' . $d[0];
					echo '<tr class="parent_group '.$hide.'"><td colspan="' . count($this->head) . '">' . Utils::getMonthName($d[1]) .' '.$d[0]. '</td></tr>';
				}
			}

			echo '<tr class="parent_row '.$hide.'" id="' . $doc->id . '"">';
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
				if ($col=='doc_num') {
					if ($doc->link>0) {
						$val = $doc->doc_num . ' <small>(' . $doc->doclink->doc_num . ')</small>';
						$type = 'character';
					}
				}

				$tmp = $this->format_type($val, $type);
				echo '<td class="'.$col.' '.$tmp['style'].'">' . $tmp['val'] . '</td>';
			}
			echo '</tr>';

			// вывод содержимого документа
			echo '<tr id="ch_' . $doc->id . '" class="child_row hidden">';
			echo '<td colspan="' . count($this->head) . '">';
			echo '<table class="child"><thead>';
			// подшапка
			$po = '';
			if ($doc->link>0) {
				$po = @Docaddition::model()->find('id_doc='.$doc->link)->payment_order;
			}
			echo '<tr id="doc_hat_' . $doc->id . '" class="doc_hat" payment_order="'.$doc->paymentorder.'" descr="'.$doc->prim.'" link_porder="'.$po.'">';
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
			foreach ($this->buttons as $button=>$title) {
				if ($button == 'ttn' && $doc->link>0) {
					echo "<button title='".$title."' class='" . $button . "_doc_button' link='".$doc->link."'>";
				} elseif ($button != 'ttn') {
					echo "<button title='".$title."' class='" . $button . "_doc_button'>";
				}
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
				$empty = '';
//				if ($docdata_row['quantity']==0) {
//					$empty = ' class="empty" ';
//				}
				echo '<tr '.$empty.'docdata_id="' . $docdata_row['id'] . '">';
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
						if ($dcol=='goods.name') {
							$val = CHtml::link($val, '#', array('class'=>'goodscart','gid'=>$docdata_row->id_goods) );
//							 CHtml::ajaxLink(
//								$val,
//								array('store/goodsCart/'.$docdata_row->id_goods),
//								array('update' => '#mainDialogArea'),
//								array('onclick' => '$("#mainDialog").dialog("open");')
//							);
						}
						$tmp = $this->format_type($val, $type);
//				                echo '<td class="cell c' . ++$c . ' ' . $tmp['style'] . '">' . $tmp['val'] . '</td>';
					}
						// костыль
					if (in_array($dcol, array('markup', 'vat'))) {
						$tmp['style'] = 'r';
					}
					echo '<td class="cell c' . ++$c . ' ' . $tmp['style'] . '" field="'.$dcol.'">' . $tmp['val'] . '</td>';
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

		if ($this->limit!==null && $cnt > $this->limit) {
			echo "<a id='show_more' href='#'>Показать все</a>";
		}

		parent::run();
		return;
		/*-------------------------------------------------------------------------------------*/
	}
}

