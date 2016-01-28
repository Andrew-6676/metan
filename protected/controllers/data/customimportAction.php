<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 14.09.15
 * Time: 14:46
 */


class customimportAction extends CAction   /*DataController*/
{
	public $tmp = array();
	/*--------------------------------------------------------------------------------------------------*/
	public function run()
	{
//exit;
		echo "<pre>";
		echo "\nТовары:\n";

		$dbf_path = '/var/www/metan_0.1/public/dbf/pereezd11/f160116.dbf';
		$dbf2 = new dbf($dbf_path );

		if ($dbf2) {
			while ($row = $dbf2->readRec()) {   // готово
				//if ($row['KM'] =='41930577') {
					add_goods($row);
				//}
			}
		}

		//exit;

		echo "\nДокументы:\n";

		$dbf_path = '/var/www/metan_0.1/public/dbf/pereezd11/f3001_16.dbf';
		$dbf = new dbf($dbf_path );

		if ($dbf) {
			while($row = $dbf->readRec()) {

				if ($row['DATA'] < '20160101') {
					echo "({$row['DATA']}) - skip";
					continue;
				}

				switch ($row['KO']) {
					case '56':
							//карта
						store_56($row);
						break;
					case '54':
							//кредит
//						store_54($row);
						break;
//					case '52':
//							// безнал
////						store_52($row);
//						break;
					case '51':
//							// наличка
						store_51($row); //готово
						break;
					case '00':
							// остатки
						//store_00($row); //готово
						break;
					case '02':
							// возврат
						$this->store_02($row); //готово
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
	public function store_02($row) {
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
				$doc->cost = round($row['ZENO']);
				$doc->markup = $row['NAZ'];
				$doc->vat = $row['CO'];
				$doc->quantity = $row['KL'];

				$doc->price = $row['ZENR'];;

				//	Utils::print_r($doc);

				if (!$doc->save()) {
					var_dump($doc->getErrors());
				} else {
					echo " -- ok  -- \n";
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
			$doc_data->cost         = round($row['ZENO']);
			$doc_data->markup       = $row['NAZ'];
			$doc_data->vat          = $row['CO'];
			$doc_data->quantity     = $row['KL'];
//				$doc_data->packages     = $this->packages;
//				$doc_data->gross        = $this->gross;
			$doc_data->price        = $row['ZENR'];
			if (!$doc_data->save()) {
				var_dump($doc_data->getErrors());
			} else {
				echo " -- ok  -- \n";
			}
		}

		echo "Возврат: {$row['KM']} - $nttn\n";

	}

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
				 $doc->cost = round($row['ZENO']);
				 $doc->markup = $row['NAZ'];
				 $doc->o_markup = $row['CO'];
				 $doc->vat = $row['NDS'];
				 $doc->quantity = $row['KL'];

				 $doc->price = $row['ZENR'];;

				 //	Utils::print_r($doc);

				 if (!$doc->save()) {
					 var_dump($doc->getErrors());
				 } else {
					 echo " -- ok  -- \n";
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
			 $doc_data->cost         = round($row['ZENO']);
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
				 echo " -- ok  -- \n";
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
		$doc->cost = round($row['ZENO']);
		$doc->markup = $row['NAZ'];
		$doc->vat = $row['CO'];
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
	// кредит
function store_54($row) {
	$nttn = mb_convert_encoding($row['NTTN'], 'UTF-8', 'cp866');
	echo "Кредит: {$row['KM']} - $nttn\n";

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
		$doc->cost = round($row['ZENO']);
		$doc->markup = $row['NAZ'];
		$doc->vat = $row['CO'];
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
		$doc->cost = round($row['ZENO']);
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
