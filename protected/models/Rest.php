<?php

/**
 * This is the model class for table "{{rest}}".
 *
 * The followings are the available columns in table '{{rest}}':
 * @property integer $id
 * @property integer $id_store
 * @property integer $id_goods
 * @property string $rest_date
 * @property double $quantity
 * @property integer $cost
 * @property integer $markup
 * @property double $vat
 * @property integer $price
 */
class Rest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rest}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_goods, rest_date', 'required'),
			array('id_store, id_goods', 'numerical', 'integerOnly'=>true),
			array('quantity, markup, cost, price, vat', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_store, id_goods, rest_date, quantity, cost, markup, vat, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Goods' => array(self::BELONGS_TO, 'Goods', 'id_goods'),
			'goods' => array(self::BELONGS_TO, 'Goods', 'id_goods'),
			'Store' => array(self::BELONGS_TO, 'Store', 'id_store'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_store' => 'Id Store',
			'id_goods' => 'Id Goods',
			'rest_date' => 'Дата',
			'quantity' => 'Количество',
			'cost' => 'Cost',
			'markup' => 'Markup',
			'vat' => 'Vat',
			'price' => 'Цена',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_store',$this->id_store);
		$criteria->compare('id_goods',$this->id_goods);
		$criteria->compare('rest_date',$this->rest_date,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('markup',$this->markup);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**----------------------------------------------
	 * $f    - поле для фильтра (код, наименование)
	 * $term - значение фильтра
	*/
	public static function getRestList_old($f, $term, $date, $store, $type='arr'){
		$connection = Yii::app()->db;

		// в предыдущем запросе не учитывалось то, что товар мог был оплачен двумя суммами (часть нал, часть безнал)
		// часть товара оплаченная налом помечена в поле partof - в количество такой товар считать не надо, цену надо брать из прихода
		//TODO: цену выбрать только из прихода и остатков (никаких счёт-фактур)
		$sql_rest = "select gid as id, gname as name, max(cost) as cost, max(markup) as markup, max(vat) as vat,
						COALESCE((select price from {{rest}} where id_goods=gid and rest_date='".substr($date,0,7)."-01' order by rest_date desc limit 1), (select price from {{documentdata}} dd inner join {{document}} d on d.id=dd.id_doc where id_goods=gid and (id_operation in(2,3,33)) and doc_date<='".$date."' and doc_date>='".substr($date,0,7)."-01' order by d.id desc limit 1)) as price,
						 sum(quantity)::real as rest,
						(select COALESCE(sum(quantity), 0)
						from vgm_documentdata dd
							inner join vgm_document d on d.id=dd.id_doc
						where d.id_doctype=3 and id_goods=gid and  d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store." and link<0) as inv
					from (
						select g.id as gid, g.name as gname, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, 'd' as t
						from vgm_goods g
						  inner join vgm_documentdata dd on g.id=dd.id_goods and dd.partof<0
						  inner join vgm_document d on d.id=dd.id_doc and d.active
						  inner join vgm_operation o on o.id=d.id_operation
						where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store."
						group by gid, gname, cost

							union

						select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, 'r' as t
						from vgm_goods g
						  inner join vgm_rest r on g.id=r.id_goods
						where r.rest_date='".substr($date,0,7)."-01' and id_store=".$store."
					) as motion
					group by gid, gname, price
					--having sum(quantity)!=0 and upper(".$f."::text) like upper('".$term."%')
					having upper(".$f."::text) like upper('".$term."%')
					order by ".$f.", 1, 2";

		$inv_start_date = '2016-01-01'; // как далеко в прошлое лезть за счетами фактуры
			// добавлены колонки прихода и расхода
		$sql_rest2 = "select
							gid as id,
							gname as name,
							max(cost) as cost,
							max(markup) as markup,
							max(vat) as vat,
							--price as price_1,
							(select price from vgm_rest where id_goods=gid and rest_date='2016-03-01' order by rest_date desc limit 1) as price_from_rest,
							(select price from vgm_documentdata dd inner join vgm_document d on d.id=dd.id_doc where id_goods=gid and (id_operation in(2,3,33)) and doc_date<='2016-03-31' and doc_date>='2016-03-01' order by d.id desc limit 1) as price_from_doc,
							COALESCE((select price from {{rest}} where id_goods=gid and rest_date='".substr($date,0,7)."-01' order by rest_date desc limit 1), (select price from {{documentdata}} dd inner join {{document}} d on d.id=dd.id_doc where id_goods=gid and (id_operation in(2,3,33)) and doc_date<='".$date."' and doc_date>='".substr($date,0,7)."-01' order by d.id desc limit 1)) as price,
							sum(quantity_rest)::real as rest_begin,
							sum(quantity_receipt)::real as receipt,
							sum(quantity_expence)::real as expence,
							sum(quantity_rest+quantity_receipt-quantity_expence)::real as rest,
							(select COALESCE(sum(quantity), 0)
							from vgm_documentdata dd
								inner join vgm_document d on d.id=dd.id_doc
							where d.id_doctype=3 and id_goods=gid and  d.doc_date<='".$date."' and d.doc_date>='".$inv_start_date."' and id_store=".$store." and link<0) as inv
					from (
						select
							g.id as gid,
							g.name as gname,
							dd.cost as cost,
							dd.price as price,
							max(dd.markup) as markup,
							max(vat) as vat,
							0 as quantity_rest,
							sum(dd.quantity) as quantity_receipt,
							0 as quantity_expence,
							'p' as t
						from vgm_goods g
						  inner join vgm_documentdata dd on g.id=dd.id_goods and dd.partof<0
						  inner join vgm_document d on d.id=dd.id_doc and d.active
						  inner join vgm_operation o on o.id=d.id_operation
						where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store." and o.operation>0
						group by gid, gname, cost, price

							union

						select
							g.id as gid,
							g.name as gname,
							dd.cost as cost,
							dd.price as price,
							max(dd.markup) as markup,
							max(vat) as vat,
							0 as quantity_rest,
							0 as quantity_receipt,
							sum(dd.quantity) as quantity_expence,
							'r' as t
						from vgm_goods g
						  inner join vgm_documentdata dd on g.id=dd.id_goods and dd.partof<0
						  inner join vgm_document d on d.id=dd.id_doc and d.active
						  inner join vgm_operation o on o.id=d.id_operation
						where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store." and o.operation<0
						group by gid, gname, cost, price

							union

						select
							g.id as gid,
							g.name as gname,
							r.cost as cost,
							r.price as price,
							r.markup as markup,
							r.vat as vat,
							r.quantity as quantity_rest,
							0 as quantity_receipt,
							0 as quantity_expence,
							'o' as t
						from vgm_goods g
						  inner join vgm_rest r on g.id=r.id_goods
						where r.rest_date='".substr($date,0,7)."-01' and id_store=".$store."
					) as motion
					group by gid, gname, price
					--having sum(quantity)!=0 and upper(".$f."::text) like upper('".$term."%')
					having upper(".$f."::text) like upper('".$term."%')
					order by ".$f.", 1, 2";

		$rest = $connection->createCommand($sql_rest2)->queryAll();
		//echo '<pre>'.$sql_rest2.'</pre>';

		if ($type=='json') {
			$res = json_encode($rest);
		} else {
			$res = $rest;
		}
		return $res;
	}

	/**----------------------------------------------
	 * $f    - поле для фильтра (код, наименование)
	 * $term - значение фильтра
	 */
	public static function getRestList_new($f, $term, $date, $store, $type='arr') {
		$inv_start_date = '2016-06-01';
		/* надо вернуть:
		id
		name
		cost
		markup
		vat
		price
		price_from_doc
		price_from_rest
		rest_begin
		receipt
		expence
		inv
		rest
*/
			// 1. выбираем остаток на начало
		$criteria_1 = new CDbCriteria;
		$criteria_1->order ='id_goods';
		$criteria_1->with = array('goods');
		$criteria_1->addCondition('rest_date = \''.substr($date,0,7).'-01\'');
		$criteria_1->addCondition('id_store='.$store);
		$criteria_1->addCondition('upper(goods.'.$f.'::text) like upper(\''.$term.'%\')');

		$model_1 = Rest::model()->findAll($criteria_1);
		$rest_arr = $model_1;

			// 2. выбираем движение товара за месяц
		$criteria_2 = new CDbCriteria;
		$criteria_2->with = array('documentdata', 'sum_cost', 'operation', 'documentdata.goods');
		$criteria_2->addCondition('id_doctype<>3');
		//$criteria_2->addCondition('id_operation!=61');
		$criteria_2->addCondition('doc_date<=\''.$date.'\'');
		$criteria_2->addCondition('doc_date::text like \''.substr($date,0,7).'%\'');
		$criteria_2->addCondition('id_store='.$store);
		$criteria_2->addCondition('upper(goods.'.$f.'::text) like upper(\''.$term.'%\')');

		$model_2 = Document::model()->findAll($criteria_2);
		$doc_arr = $model_2;

			// 3. выбираем счета-фактуры за последние 4-5 месяцев
		$criteria_3 = new CDbCriteria;
		$criteria_3->with = array('documentdata', 'sum_cost', 'operation', 'documentdata.goods');
		$criteria_3->addCondition('id_doctype=3');
		$criteria_3->addCondition('doc_date<=\''.$date.'\'');
		$criteria_3->addCondition("doc_date>='".$inv_start_date."'");
		$criteria_3->addCondition('id_store='.$store);
		$criteria_3->addCondition('link<0');
		$criteria_3->addCondition('upper(goods.'.$f.'::text) like upper(\''.$term.'%\')');

		$model_3 = Document::model()->findAll($criteria_3);
		$inv_arr = $model_3;


			// заносим в результирующий массив остатки на начало месяца
		$res = [];
		foreach ($rest_arr as $item) {
			$res[$item->id_goods] = [];
			$res[$item->id_goods]['id'] = $item->id_goods;
			$res[$item->id_goods]['name'] = $item->Goods->name;
			$res[$item->id_goods]['cost'] = $item->cost;
			$res[$item->id_goods]['markup'] = $item->markup;
			$res[$item->id_goods]['vat'] = $item->vat;
			$res[$item->id_goods]['price'] = $item->price;
			$res[$item->id_goods]['price_list'][$item->price] = 0;
			$res[$item->id_goods]['price_from_rest'] = $item->price;
			$res[$item->id_goods]['price_from_doc'] = $item->price;
			$res[$item->id_goods]['rest_begin'] = $item->quantity;
			$res[$item->id_goods]['receipt'] = 0;
			$res[$item->id_goods]['expence'] = 0;
			$res[$item->id_goods]['inv'] = 0;
			$res[$item->id_goods]['rest'] = (real)$item->quantity;
		}

			// добавляем в результирующий массив движение товаров (приход, расход...)
		foreach ($doc_arr as $doc) {
			foreach ($doc->documentdata as $row) {
				//echo $doc->operation->operation.'-'.$row->quantity.';';
				//$res[] = $row->id_goods;
				if (!array_key_exists($row->id_goods, $res)) {

					$receipt = $doc->operation->operation > 0 ? $row->quantity : 0;
					if ($row->partof>0) {
						$expence = 0;
						$rest = 0;
					} else {
						$expence = $doc->operation->operation < 0 ? $row->quantity : 0;
						$rest = $row->quantity*$doc->operation->operation;
					}

					$res[$row->id_goods] = [];
					$res[$row->id_goods]['id'] = $row->goods->id;
					$res[$row->id_goods]['name'] = $row->goods->name;
					$res[$row->id_goods]['cost'] = $row->cost;
					$res[$row->id_goods]['markup'] = $row->markup;
					$res[$row->id_goods]['vat'] = $row->vat;
					$res[$row->id_goods]['price'] = $row->price;
					$res[$row->id_goods]['price_list'][$row->price] = 0;
					$res[$row->id_goods]['price_from_doc'] = $doc->id_doctype==1 ? $row->price : 0;
					//$res[$row->id_goods]['price_from_rest'] = -1,
					$res[$row->id_goods]['rest_begin'] = 0;
					$res[$row->id_goods]['receipt'] = $receipt;
					$res[$row->id_goods]['expence'] = $expence;
					$res[$row->id_goods]['inv'] = 0;
					$res[$row->id_goods]['rest'] = (real)$rest;
				} else {
					$receipt = $doc->operation->operation > 0 ? $res[$row->id_goods]['receipt']+$row->quantity : $res[$row->id_goods]['receipt'];
					if ($row->partof>0) {
						$expence = $res[$row->id_goods]['expence'];
						$rest = $res[$row->id_goods]['rest'];
					} else {
						$expence = $doc->operation->operation < 0 ? $res[$row->id_goods]['expence']+$row->quantity : $res[$row->id_goods]['expence'];
						$rest = $res[$row->id_goods]['rest'] + $row->quantity*$doc->operation->operation;
					}


					// $res[$row->id_goods]['id'] = -1;
					// $res[$row->id_goods]['name'] = $row->goods->name;
					// $res[$row->id_goods]['cost'] = 0;
					// $res[$row->id_goods]['markup'] = 0;
					// $res[$row->id_goods]['vat'] = 0;
					 $res[$row->id_goods]['price_list'][$row->price] = 0;
					// $res[$row->id_goods]['price_from_doc'] = 0;
					// $res[$row->id_goods]['price_from_rest'] = 0;
					// $res[$row->id_goods]['rest_begin'] = 0;
					$res[$row->id_goods]['receipt'] = $receipt;
					$res[$row->id_goods]['expence'] = $expence;
					//$res[$row->id_goods]['inv'] = $doc->operation->operation == 0 ? $res[$row->id_goods]['inv'] + $row->quantity : $res[$row->id_goods]['inv'];
					$res[$row->id_goods]['rest'] = (real)$rest;
				}
			}
		}

			// добавляем в результирующий массив количество по счетам-фактурам
		foreach ($inv_arr as $doc) {

			foreach ($doc->documentdata as $row) {
//				if ($row->id_goods==43930495) {
//					print_r($doc);
//				}
				if (!array_key_exists($row->id_goods, $res)) {
//					$res[$row->id_goods] = [];
//					$res[$row->id_goods]['id'] = -1;
//					$res[$row->id_goods]['name'] = $row->goods->name;
//					$res[$row->id_goods]['cost'] = $row->cost;
//					$res[$row->id_goods]['markup'] = $row->markup;
//					$res[$row->id_goods]['vat'] = $row->vat;
//					//$res[$row->id_goods]['price'] = -1,
//					$res[$row->id_goods]['price_from_doc'] = $row->price;
//					//$res[$row->id_goods]['price_from_rest'] = -1,
//					$res[$row->id_goods]['rest_begin'] = 0;
//					$res[$row->id_goods]['receipt'] = $doc->operation->operation > 0 ? $row->quantity : 0;
//					$res[$row->id_goods]['expence'] = $doc->operation->operation < 0 ? $row->quantity : 0;
//					$res[$row->id_goods]['inv'] = $row->quantity;
//					$res[$row->id_goods]['rest'] = $row->quantity*$doc->operation->operation;
				} else {
					// $res[$row->id_goods]['id'] = -1;
					// $res[$row->id_goods]['name'] = $row->goods->name;
					// $res[$row->id_goods]['cost'] = 0;
					// $res[$row->id_goods]['markup'] = 0;
					// $res[$row->id_goods]['vat'] = 0;
					// $res[$row->id_goods]['price'] = 0;
					// $res[$row->id_goods]['price_from_doc'] = 0;
					// $res[$row->id_goods]['price_from_rest'] = 0;
					// $res[$row->id_goods]['rest_begin'] = 0;
					// $res[$row->id_goods]['receipt'] = $doc->operation->operation > 0 ? $res[$row->id_goods]['receipt']+$row->quantity : $res[$row->id_goods]['receipt'];
					// $res[$row->id_goods]['expence'] = $doc->operation->operation < 0 ? $res[$row->id_goods]['expence']+$row->quantity : $res[$row->id_goods]['expence'];
					$res[$row->id_goods]['inv'] = $res[$row->id_goods]['inv'] + $row->quantity;
					// $res[$row->id_goods]['rest'] = $res[$row->id_goods]['rest'] + $row->quantity*$doc->operation->operation;
				}
			}
		}

		if ($type=='json') {
			$rest = json_encode($res);
		} else {
			$rest = $res;
		}

		return $rest;
	}
/*--------------------------------------------------------------------------------------------------------------------*/
	public static function closeMonth($m, $y, $store) {

		$connection = Yii::app()->db;
		$o = '';
		$o1 = '';
		// добавлять ли 0 перед номером месяца
		if ($m < 9) {
			$o = '0';
		}
		if ($m < 10) {
			$o1 = '0';
		}
		// дата нового месяца
		if ($_POST['month'] < 12) {
			$date = $y.'-'.$o.($m+1).'-01';
		} else {
			$date = ($y+1).'-01-01';
		}
		// месяц из которого брать
		$month = $y.'-'.$o1.$m.'-%';

		$store = Yii::app()->session['id_store'];
		$sql_del_rest = "delete from {{rest}} where rest_date='".$date."' and id_store=".$store;
		// предыдущий запрос терял повторяющиеся строки

		$sql_rest = "SELECT	$store as id_store,
						gid as id,
						'$date' as rest_date,
						sum(quantity)::real as rest,
						max(cost) as cost,
						max(markup) as markup,
						max(vat) as vat,
						--COALESCE((select price from {{rest}} where id_goods=gid order by rest_date desc limit 1), (select price from {{documentdata}} dd inner join {{document}} d on d.id=dd.id_doc where id_goods=gid and (id_operation in(2,3,33)) order by d.id desc limit 1)) as price
						COALESCE((select price from {{rest}} where id_goods=gid and rest_date='".substr($month,0,7)."-01' order by rest_date desc limit 1), (select price from {{documentdata}} dd inner join {{document}} d on d.id=dd.id_doc where id_goods=gid and (id_operation in(2,3,33)) and doc_date::text like '".$month."' order by d.id desc limit 1)) as price

					FROM (
						select g.id as gid, g.name as gname, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, 'd' as t
						from vgm_goods g
						  inner join vgm_documentdata dd on g.id=dd.id_goods and dd.partof<0
						  inner join vgm_document d on d.id=dd.id_doc and d.active
						  inner join vgm_operation o on o.id=d.id_operation
						where d.doc_date::text like '".$month."' and id_store=".$store."
						group by gid, gname, cost

							union

						select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, 'r' as t
						from vgm_goods g
						  inner join vgm_rest r on g.id=r.id_goods
						where r.rest_date='".substr($month,0,7)."-01' and id_store=".$store."
					) as motion
					group by gid, gname, price
					having sum(quantity)!=0
					order by 1, 2";

		$sql_add_rest ="insert into {{rest}} (id_store, id_goods, rest_date, quantity, cost, markup, vat, price)"
							.$sql_rest;
								/*."select
									".Yii::app()->session['id_store']." as id_store,
									gid as id,
									'".$date."' as rest_date,
									sum(quantity)::real as quantity,
									max(cost) as cost,
									max(markup) as markup,
									max(vat) as vat,
									price
								from (
									select g.id as gid, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, dd.price, 'd' as t
									from vgm_goods g
									  inner join vgm_documentdata dd on g.id=dd.id_goods
									  inner join vgm_document d on d.id=dd.id_doc
									  inner join vgm_operation o on o.id=d.id_operation
									where d.doc_date<='".$date."' and d.doc_date::text like'".$month."' and id_store=".$store."
									group by gid, cost, price

										union

									select g.id as gid, r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, r.price as price, 'r' as t
									from vgm_goods g
									  inner join vgm_rest r on g.id=r.id_goods
									where r.rest_date::text like '".$month."' and id_store=".$store."
									     ) as motion
									group by gid, price
									having sum(quantity)!=0
									order by 1";*/

		$sql_kassa_del = "delete from {{kassa}} where kassa_date='".$date."' and id_store=".Yii::app()->session['id_store'];

		$sql_kassa_add = "insert into vgm_kassa (kassa_date, sum, id_store)
									(select '".$date."'::date, sum, id_store
									from vgm_kassa
									where id_store=".Yii::app()->session['id_store']." and kassa_date::text like '".$month."'
									order by kassa_date desc
									limit 1)";
		// echo '<pre>'.$sql_add_rest.'</pre>';

		$res = array('status'=>'unknown', 'data'=>array());

		$transaction = $connection->beginTransaction();
		try {
			$connection->createCommand($sql_del_rest)->execute();
			$connection->createCommand($sql_add_rest)->execute();
			$connection->createCommand($sql_kassa_del)->execute();
			$connection->createCommand($sql_kassa_add)->execute();
			$transaction->commit();
			$res['status'] = 'ok';
			$res['data']['post'] = $_POST;
			$res['data']['sql1'] = $sql_del_rest;
			$res['data']['sql2'] = $sql_add_rest;
			$res['data']['sql3'] = $sql_kassa_del;
			$res['data']['sql4'] = $sql_kassa_add;
		} catch (Exception $e) {
			$transaction->rollback();
			$res['status'] = 'error';
			$res['data']['err'] = $e->errorInfo;
		}

		return $res;
	}
/*--------------------------------------------------------------------------------------------------------------------*/
	public static function get_Rest($date, $store, $x=0){

			// отнимаем день
		$d = explode('-', $date);

		if ($x<0 && $d[2]!=1) {
			$lastday = mktime(0, 0, 0, $d[1], $d[2]-1, $d[0]);
			$date = date('Y-m-d', $lastday);
		}


		$connection = Yii::app()->db;

		if ($d[2]==1) {
			//Utils::print_r(substr($date,0,7)."-01'");
			$sql_rest = "select sum(quantity*price) as rest
						from vgm_rest
						where rest_date='".substr($date,0,7)."-01'";
			$sql_rest2 = "select 0";
		} else {
			$sql_rest = "select sum(quantity*price) as rest
					from (
							select g.id as gid, g.name as gname, dd.cost as cost, max(dd.markup) as markup, max(vat) as vat, sum(dd.quantity*o.operation) as quantity, dd.price, 'd' as t
							from vgm_goods g
								inner join vgm_documentdata dd on g.id=dd.id_goods
								inner join vgm_document d on d.id=dd.id_doc and d.active
								inner join vgm_operation o on o.id=d.id_operation
							where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store."
							group by gid, gname, cost, price

								union

							select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, r.price as price, 'r' as t
							from vgm_goods g
								inner join vgm_rest r on g.id=r.id_goods
							where r.rest_date='".substr($date,0,7)."-01' and id_store=".$store."
						 ) as motion
					--group by gid, gname, cost, markup, vat, price";
			$sql_rest2 = "select sum(price) as rest
						 from vgm_document d inner join vgm_documentdata dd on dd.id_doc=d.id
						 where d.id_operation=61 and d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store;
		}


		$rest = $connection->createCommand($sql_rest)->queryScalar();
		$rest2 = $connection->createCommand($sql_rest2)->queryScalar();


//		$rest = $rest->rest;
		if ($rest) {
			return $rest+$rest2;
		} else {
			return -1;
		}
	}

	/*--------------------------------------------------------------------*/

	public function checkRest($ids=array()) {
		$res = array('status'=>'ok', 'message'=>'не хвататет остатка');

		$connection = Yii::app()->db;
		// получаем остатки
//		$sql_rest = "select gid as id, gname as name, price, sum(quantity)::real as rest
//					from (
//							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, dd.quantity*o.operation as quantity, dd.price, 'd' as t
//							from vgm_goods g
//								inner join vgm_documentdata dd on g.id=dd.id_goods
//								inner join vgm_document d on d.id=dd.id_doc
//								inner join vgm_operation o on o.id=d.id_operation
//								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
//							where d.doc_date<='".Yii::app()->session['workdate']."' and d.doc_date>='".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//								union
//							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, r.quantity, r.cost as price, 'r' as t
//							from vgm_goods g
//								inner join vgm_rest r on g.id=r.id_goods
//								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
//							where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
//						 ) as motion
//					group by ggid, ggname, gid, gname, price
//					having sum(quantity)!=0 and gid in (".implode(',', array_keys($ids)).")
//					order by 4";

		$date = Yii::app()->session['workdate'];
		$store = Yii::app()->session['id_store'];
		$sql_rest = "select gid as id, trim(gname) as name, price, sum(quantity)::real as rest
					 from (
							select g.id as gid, g.name as gname, dd.cost as cost, dd.markup as markup, vat, dd.quantity*o.operation as quantity, dd.price, 'd' as t
							from vgm_goods g
								inner join vgm_documentdata dd on g.id=dd.id_goods
								inner join vgm_document d on d.id=dd.id_doc
								inner join vgm_operation o on o.id=d.id_operation
							where d.doc_date<='".$date."' and d.doc_date>='".substr($date,0,7)."-01' and id_store=".$store."
								union
							select g.id as gid, g.name as gname,  r.cost as cost, r.markup as markup, r.vat as vat, r.quantity, r.price as price, 'r' as t
							from vgm_goods g
								inner join vgm_rest r on g.id=r.id_goods
							where r.rest_date::text like '".substr($date,0,7)."-01' and id_store=".$store."
						 ) as motion
					group by gid, gname, price
					having sum(quantity)!=0 and gid in (".implode(',', array_keys($ids)).")
					order by 4";


		$rest = $connection->createCommand($sql_rest)->queryAll();

		// смотрим, что берётся больше возможного
		foreach ($rest as $r) {
			if ($r['rest'] - $ids[$r['id']] < 0) {
				$res['status'] = 'err';
				$res['no_rest'][] = array('name'=>$r['name'], 'quantity'=>$r['rest']);
			}
		}

		return $res;
	}

	/*-------------------------------------------------------*/


}

function toArray($ar_arr, $index_column=null) {
	$res = [];
	foreach ($ar_arr as $item) {
		if ($index_column==null) {
			$res[] = $item->getAttributes();
		} else {
			$res[$item[$index_column]] = $item->getAttributes();
		}

	}
	return $res;
}