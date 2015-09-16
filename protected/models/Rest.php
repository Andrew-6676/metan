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
			array('id_store, id_goods, cost, markup, price', 'numerical', 'integerOnly'=>true),
			array('quantity, vat', 'numerical'),
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
	public static function getRestList($f, $term, $date, $store, $type='arr'){
		$connection = Yii::app()->db;

		//$sql_rest = "select gid as id, gname as name, price, sum(quantity)::real as rest
		$sql_rest = "select gid as id, gname as name, max(cost) as cost, max(markup) as markup, max(vat) as vat, price, sum(quantity)::real as rest
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
					--group by gid, gname, cost, markup, vat, price
					group by gid, gname, price
					having sum(quantity)!=0 and upper(".$f."::text) like upper('".$term."%')
					order by ".$f.", 1, 2";

		$rest = $connection->createCommand($sql_rest)->queryAll();

		if ($type=='json') {
			$res = json_encode($rest);
		} else {
			$res = $rest;
		}
		return $res;
	}
/*--------------------------------------------------------------------------------------------------------------------*/
	public static function get_Rest($date, $store){

		$connection = Yii::app()->db;

		$sql_rest = "select sum(quantity*price) as rest
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
					--group by gid, gname, cost, markup, vat, price";

		$rest = $connection->createCommand($sql_rest)->queryScalar();


//		$rest = $rest->rest;
		if ($rest) {
			return $rest;
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
