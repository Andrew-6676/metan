<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 14.09.15
 * Time: 14:46
 */

global $counter;
$counter = 0;
class customimportAction extends CAction   /*DataController*/
{
	public $tmp = array();
	/*--------------------------------------------------------------------------------------------------*/
	public function run()
	{
//exit;
		echo "<pre>";
//		echo "\nТовары:\n";

//		$dbf_path = '/var/www/metan_0.1/public/dbf/pereezd11/f160116.dbf';
//		$dbf2 = new dbf($dbf_path );
//
//		if ($dbf2) {
//			while ($row = $dbf2->readRec()) {   // готово
//				//if ($row['KM'] =='41930577') {
//					add_goods($row);
//				//}
//			}
//		}

		exit;

		echo "\nДокументы:\n";

		$dbf_path = '/var/www/metan_0.1/public/dbf/pereezd13/f3001_16.dbf';
		$dbf = new dbf($dbf_path );

		if ($dbf) {
			while($row = $dbf->readRec()) {

				//if (substr($row['DATA'], 0, 6) != '201602' || $row['DATA'] == '20160202' || $row['DATA'] == '20160201') {
				if ($row['DATA'] != '20160208') {
					echo "({$row['DATA']}) - skip ";
					continue;
				}

				switch ($row['KO']) {
					case '56':
							//карта
						echo "\n";
						store_56($row);
						break;
					case '54':
							//кредит
						echo "\n";
						//$this->store_54($row);
						break;
//					case '52':
//							// безнал
////						store_52($row);
//						break;
					case '51':
//							// наличка
						echo "\n";
						store_51($row); //готово
						break;
					case '00':
							// остатки
						echo "\n";
						//store_00($row); //готово
						break;
					case '02':
					case '03':
							// возврат
					echo "\n";
						//$this->store_0203($row); //готово
						break;
					default:
						break;
				}
			}
		} else {

		}


//		echo "\nСчёт-фактуры:\n";
//
//		$dbf_path = '/var/www/metan_0.1/public/dbf/pereezd5/F300107.DBF';
//		$dbf3 = new dbf($dbf_path );
//
//		if ($dbf3) {
//			while ($row = $dbf3->readRec()) {
////				if (strstr($row['DATA'],'201510')==false) {
////					//echo "({$row['DATA']})";
////					continue;
////				}
//				if ($row['DATA'] < '20151110') {
//					//echo "({$row['DATA']})";
//					continue;
//				}
//				$this->addInvoice($row);
//			}
//		}


		echo '</pre>';
	}

	/*------------------------------------------------------------------------*/
	// возврат
	public function store_0203($row) {
		$nttn = mb_convert_encoding($row['NTTN'], 'UTF-8', 'cp866');

		if (!isset($this->tmp['num']) || $this->tmp['num'] != $nttn) {
			echo "----Новый документ ";
			$this->tmp['num'] = $nttn;
			//$this->tmp['id_doc'] = 0;
			//Yii::app()->db->lastInsertID

			$doc = new Document();
			try {
				$doc->id_doctype = 4;
				$doc->id_store = Yii::app()->session['id_store'];
				$doc->id_storage = 2;
				$doc->doc_num = $nttn;
				$doc->doc_num2 = 0;
				$doc->doc_date = $row['DATA'];
				$doc->id_owner = Yii::app()->session['id_user'];
				$doc->id_editor = Yii::app()->session['id_user'];
				$doc->id_operation = $row['KO'];
//				$doc->for = -1;

				$doc->withDocdata = true;

				$doc->id_goods = $row['KM'];
				$doc->cost = $row['ZENO'];
				$doc->markup = $row['CO'];
				$doc->vat = $row['NAZ'];
				$doc->quantity = $row['KL'];

				$doc->price = $row['ZENR'];;

				//	Utils::print_r($doc);

				if (!$doc->save()) {
					var_dump($doc->getErrors());
				} else {
					global $counter;
					echo " -- ok  ".$counter++."-- \n";
					$this->tmp['lastID'] = $doc->id;
				}
			} catch (Exception $e) {
				echo " -- error\n";
				Utils::print_r($e);
			}

		} else {

			$doc_data = new Documentdata();

			$doc_data->id_doc       = $this->tmp['lastID'];
			$doc_data->id_owner     = Yii::app()->session['id_user'];
			$doc_data->id_editor    = Yii::app()->session['id_user'];
			$doc_data->id_goods     = $row['KM'];
			$doc_data->cost         = $row['ZENO'];
			$doc_data->markup       = $row['CO'];
			$doc_data->vat          = $row['NAZ'];
			$doc_data->quantity     = $row['KL'];
//				$doc_data->packages     = $this->packages;
//				$doc_data->gross        = $this->gross;
			$doc_data->price        = $row['ZENR'];
			if (!$doc_data->save()) {
				var_dump($doc_data->getErrors());
			} else {
				global $counter;
				echo " -- ok  ".$counter++."-- \n";
			}
		}

		echo "Возврат: {$row['KM']} - $nttn\n";

	}
	/*------------------------------------------------------------------------*/
	// кредит
	public function store_54($row) {


		$fio = mb_convert_encoding($row['FIO'], 'UTF-8', 'cp866');
		//echo "Кредит: {$row['KM']} - $fio\n";

		if (!isset($this->tmp['fio']) || $this->tmp['fio'] != $fio) {
			echo "----Новый документ ". $fio;

			$this->tmp['fio'] = $fio;
			//$this->tmp['id_doc'] = 0;
			//Yii::app()->db->lastInsertID

			$doc = new Document();
			try {
				$doc->id_doctype = 2;
				$doc->id_store = Yii::app()->session['id_store'];
				$doc->id_storage = 2;
				$doc->doc_num = '-';
				$doc->doc_num2 = 0;
				$doc->doc_date = $row['DATA'];
				$doc->id_owner = Yii::app()->session['id_user'];
				$doc->id_editor = Yii::app()->session['id_user'];
				$doc->id_operation = $row['KO'];
				$doc->id_contact = get_contact_id($fio);
//				$doc->for = -1;

				$doc->withDocdata = true;

				$doc->id_goods = $row['KM'];
				$doc->cost = $row['ZENO'];
				$doc->markup = $row['CO'];
				$doc->vat = $row['NAZ'];
				$doc->quantity = $row['KL'];

				$doc->price = $row['ZENR'];;

				//	Utils::print_r($doc);

				if (!$doc->save()) {
					var_dump($doc->getErrors());
				} else {
					global $counter;
					echo " -- ok  ".$counter++."-- \n";
					$this->tmp['lastID'] = $doc->id;
				}
			} catch (Exception $e) {
				echo " -- error\n";
				Utils::print_r($e);
			}
		} else {

			$doc_data = new Documentdata();

			$doc_data->id_doc       = $this->tmp['lastID'];
			$doc_data->id_owner     = Yii::app()->session['id_user'];
			$doc_data->id_editor    = Yii::app()->session['id_user'];
			$doc_data->id_goods     = $row['KM'];
			$doc_data->cost         = $row['ZENO'];
			$doc_data->markup       = $row['CO'];
			$doc_data->vat          = $row['NAZ'];
			$doc_data->quantity     = $row['KL'];
//				$doc_data->packages     = $this->packages;
//				$doc_data->gross        = $this->gross;
			$doc_data->price        = $row['ZENR'];
			if (!$doc_data->save()) {
				var_dump($doc_data->getErrors());
			} else {
				global $counter;
				echo " -- ok  ".$counter++."-- \n";
			}
		}


	}
	/*----------------------------------------------------*/
	 public function addInvoice($row) {
		 $nttn = mb_convert_encoding($row['NTTN'], 'UTF-8', 'cp866');

		 if (!isset($this->tmp['num']) || $this->tmp['num'] != $nttn) {
			 $this->tmp['num'] = $nttn;
			 echo "----Новый документ \n";
			 $id_contact = (int)$row['KPL'];
			 echo $nttn." --- $id_contact\n";


			 $doc = new Document();
			 try {
				 $doc->id_doctype = 3;
				 $doc->id_store = Yii::app()->session['id_store'];
				 $doc->id_storage = 2;
				 $doc->doc_num = $nttn;
				 $doc->doc_num2 = (int)$nttn;
				 $doc->doc_date = $row['DATA'];
				 $doc->id_owner = Yii::app()->session['id_user'];
				 $doc->id_editor = Yii::app()->session['id_user'];
				 $doc->id_operation = 1;

				 $doc->id_contact = $id_contact;


				 $doc->withDocdata = true;

				 $doc->id_goods = $row['KM'];
				 $doc->cost = $row['ZENO'];
				 $doc->markup = $row['NAZ'];
				 $doc->o_markup = $row['CO'];
				 $doc->vat = $row['NDS'];
				 $doc->quantity = $row['KL'];

				 $doc->price = $row['ZENR'];;

				 //	Utils::print_r($doc);

				 if (!$doc->save()) {
					 var_dump($doc->getErrors());
				 } else {
					 global $counter;
					 echo " -- ok  ".$counter++."-- \n";
					 $this->tmp['lastID'] = $doc->id;
				 }
			 } catch (Exception $e) {
				 echo " -- error\n";
				 Utils::print_r($e);
			 }


		 } else {
			 echo $nttn."\n";

			 $doc_data = new Documentdata();

			 $doc_data->id_doc       = $this->tmp['lastID'];
			 $doc_data->id_owner     = Yii::app()->session['id_user'];
			 $doc_data->id_editor    = Yii::app()->session['id_user'];
			 $doc_data->id_goods     = $row['KM'];
			 $doc_data->cost         = $row['ZENO'];
			 $doc_data->markup       = $row['NAZ'];
			 $doc_data->o_markup     = $row['CO'];
			 $doc_data->vat          = $row['NDS'];
			 $doc_data->quantity     = $row['KL'];
//				$doc_data->packages     = $this->packages;
//				$doc_data->gross        = $this->gross;
			 $doc_data->price        = $row['ZENR'];
			 if (!$doc_data->save()) {
				 var_dump($doc_data->getErrors());
			 } else {
				 global $counter;
				 echo " -- ok  ".$counter++."-- \n";
			 }


		 }
	 }

}
/*------------------------------------------------------------------------*/
/*------------------------------------------------------------------------*/
function add_goods($row) {
	if (trim($row['KM'])=='') {
		return;
	}

	$gch = Goods::model()->findByPK($row['KM']);
		// если товар уже есть в справочнике
	if ($gch) {
		//if (trim($gch->id_3torg)=='0')
		{
			echo "\nТакой товар уже есть!\n";
			//$gch->id_3torg=trim($row['GR']);

			$reg = '/(\d{2})(\d{2})(\d{2})(\d{3})/';
			preg_match($reg, $row['GR'], $arr);
			array_shift($arr);

			echo $row['KM'].'---';
			if (count($arr)>0 && $arr[3]=='000') {
				array_pop($arr);
			}
			echo implode('.',$arr)."\n";

			$gch->id_3torg  = implode('.',$arr);


			$gch->save();
			echo $row['KM']." -- ".$gch->id_3torg."---".$row['GR']."\n";
		}
		return;
	}

	$g = new Goods();

	$g->id  = $row['KM'];
	$g->name  = mb_convert_encoding($row['NM'], "UTF-8", "cp866");
	$g->id_unit  = trim($row['KEI']);


	if (trim($row['NZ'])!='') {
		$g->producer  = mb_convert_encoding($row['NZ'], "UTF-8", "cp866");
	} else {
		$g->producer = '';
	}


	$g->norder  = mb_convert_encoding($row['N_PR'], "UTF-8", "cp866");

	if (trim($row['KP'])!='') {
		$g->id_supplier = trim($row['KP']);
	} else {
		$g->id_supplier = -1;
	}

	$g->id_goodsgroup  = substr($row['KM'],0,4);


	$reg = '/(\d{2})(\d{2})(\d{2})(\d{3})/';
	preg_match($reg, $row['GR'], $arr);
	array_shift($arr);

	echo $row['KM'].'---';
	if (count($arr)>0 && $arr[3]=='000') {
		array_pop($arr);
	}
	echo implode('.',$arr)."\n";

	$g->id_3torg  = implode('.',$arr);


	if (!$g->save()) {
		print_r($g->getErrors());
		print_r($row);
	} else {
		echo " -- ok\n";
	}
}
/*------------------------------------------------------------------------*/
	// безнал
function store_52($row) {
	echo "Безнал: {$row['NTTN']} от {$row['DATA']} -- {$row['DATA']}\n";

		// не хватает информации для импорта
//	$doc = new Document();
//	Utils::print_r($row);
//
//	$doc->id_doctype=2;
//	$doc->id_store = Yii::app()->session['id_store'];
//	$doc->doc_num = $row['NTTN'];
//	$doc->doc_num2 = $row['NTTN'];
//	$doc->reason = $row['OSN'];
//	$doc->doc_date = $row['DATA'];
//	$doc->id_storage = $row['KSKL'];
//	$doc->id_owner = Yii::app()->session['id_user'];
//	$doc->id_editor =
//	$doc->id_contact = $row['KP'];
//	$doc->id_operation = $row['KO'];

	//mb_convert_encoding($row[$data_f], "UTF-8", "cp866")
}
/*------------------------------------------------------------------------*/
	// наличные
function store_51($row) {
	echo "Нал:  от {$row['DATA']} ";
	$doc = new Document();
	try {
		$doc->id_doctype = 2;
		$doc->id_store = Yii::app()->session['id_store'];
		$doc->id_storage = 2;
		$doc->doc_num = '0';
		$doc->doc_num2 = 0;
		$doc->doc_date = $row['DATA'];
		$doc->id_owner = Yii::app()->session['id_user'];
		$doc->id_editor = Yii::app()->session['id_user'];
		$doc->id_operation = $row['KO'];
		$doc->for = 2;

		$doc->withDocdata = true;
		$doc->id_goods = $row['KM'];
		$doc->cost = $row['ZENO'];
		$doc->markup = $row['CO'];
		$doc->vat = $row['NAZ'];
		$doc->quantity = $row['KL'];

		$doc->price = $row['ZENR'];;

		//	Utils::print_r($doc);

		if (!$doc->save()) {
			var_dump($doc->getErrors());
		} else {
			global $counter;
			echo " -- ok  ".$counter++."-- \n";
		}
	} catch (Exception $e) {
		echo " -- error\n";
		Utils::print_r($e);
	}

}

/*------------------------------------------------------------------------*/
	// карточка
function store_56($row) {
	echo "Карточка: {$row['ADR']}\n";

	$nttn = mb_convert_encoding($row['NTTN'], 'UTF-8', 'cp866');
	$doc = new Document();
	try {
		$doc->id_doctype = 2;
		$doc->id_store = Yii::app()->session['id_store'];
		$doc->id_storage = 2;
		$doc->doc_num = 0;
		$doc->doc_num2 = '0';
		$doc->doc_date = $row['DATA'];
		$doc->id_owner = Yii::app()->session['id_user'];
		$doc->id_editor = Yii::app()->session['id_user'];
		$doc->id_operation = $row['KO'];
		$doc->for = 2;
		$doc->payment_order = $row['ADR'];

		$doc->withDocdata = true;
		$doc->id_goods = $row['KM'];
		$doc->cost = $row['ZENO'];
		$doc->markup = $row['CO'];
		$doc->vat = $row['NAZ'];
		$doc->quantity = $row['KL'];

		$doc->price = $row['ZENR'];;

		//	Utils::print_r($doc);

		if (!$doc->save()) {
			var_dump($doc->getErrors());
		} else {
			echo " -- ok\n";
		}
	} catch (Exception $e) {
		echo " -- error\n";
		Utils::print_r($e);
	}
}

/*------------------------------------------------------------------------*/
	//остаток
function store_00($row) {
	echo "Остаток: {$row['KM']} - ".$row['DATA'];
	$doc = new Rest();
	try {

		$doc->id_store = Yii::app()->session['id_store'];
		$doc->id_goods = $row['KM'];
		$doc->rest_date = $row['DATA'];

		$doc->quantity = $row['KL'];
		$doc->cost = $row['ZENO'];
		$doc->vat = $row['NAZ'];
		$doc->markup = $row['CO'];

		$doc->price = $row['ZENR'];;

		if (!$doc->save()) {
			var_dump($doc->getErrors());
		} else {
			echo " -- ok\n";
		}
	} catch (Exception $e) {
		echo " -- error\n";
		Utils::print_r($e);

	}
}
/*------------------------------------------------------------------------*/
function get_contact_id($fio) {
	$criteria = new CDbCriteria;
	$criteria->addCondition('fname::text like \''.$fio.'\'');

	$cont = Contact::model()->find($criteria);
	if ($cont) {
		$id = $cont->id;
	} else {
		$cont = new Contact();
		$cont->name = $fio;
		$cont->fname = $fio;
		$cont->rs = '-';
		$cont->mfo = '-';
		$cont->unn = '-';
		$cont->parent = 3;

		$id = -1;
		if ($cont->save()) {
			$id = $cont->id;
		}
	}

	return $id;
}