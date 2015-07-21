<?php

/**
 * This is the model class for table "{{goods}}".
 *
 * The followings are the available columns in table '{{goods}}':
 * @property integer $id
 * @property string $name
 * @property integer $id_unit
 * @property string $producer
 * @property string $norder
 * @property integer $id_supplier
 * @property integer $id_goodsgroup
 * @property string $id_3torg
 *
 * The followings are the available model relations:
 * @property Rest[] $rests
 * @property Remains[] $remains
 * @property Unit $idUnit
 * @property Documentdata[] $documentdatas
 */
class Goods extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id_3torg, producer', 'required'),
			array('id_unit, id_supplier, id_goodsgroup', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('producer', 'length', 'max'=>150),
			array('norder', 'length', 'max'=>100),
			array('id_3torg', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, id_unit, producer, norder, id_supplier, id_goodsgroup, id_3torg', 'safe', 'on'=>'search'),
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
			'rests' => array(self::HAS_MANY, 'Rest', 'id_goods'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'id_unit'),
			'torg3' => array(self::BELONGS_TO, 'Torg3', 'id_3torg'),
			'supplier' => array(self::BELONGS_TO, 'Contact', 'id_supplier'),
			'contact' => array(self::BELONGS_TO, 'Contact', 'id_supplier'),
//			'documentdatas' => array(self::HAS_MANY, 'Documentdata', 'id_goods'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Код',
			'name' => 'Наименование',
			'id_unit' => 'Единица измерения',
			'unitname' => 'Единица измерения',
			'producer' => 'Производитель',
			'norder' => 'Norder',
			'id_supplier' => 'Поставщик',
			'suppliername' => 'Поставщик',
			'id_goodsgroup' => 'Группа',
			'id_3torg' => 'Группа 3-торг',
			'torg3name' => 'Группа 3-торг',

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
		$criteria->compare('gname',$this->name,true);
		$criteria->compare('id_unit',$this->id_unit);
		$criteria->compare('producer',$this->producer,true);
//		$criteria->compare('norder',$this->norder,true);
		$criteria->compare('id_supplier',$this->id_supplier);
//		$criteria->compare('supplier.name',$this->supplier);
		$criteria->compare('contact.name',$this->contactname);
		$criteria->compare('id_goodsgroup',$this->id_goodsgroup);
		$criteria->compare('id_3torg',$this->id_3torg,true);

		$criteria->with = array('unit','contact');

		$sort = new CSort();
		$sort->attributes = array(
			'id',
			'name',
			'unit.name',
			'unitname' ,
			'producer',
			'norder',
			'id_supplier',
			'contact.name',
			/*
			'id_goodsgroup',*/
			'id_3torg',
		);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => $sort,
			'pagination' => array('pageSize' => 50),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function checkRest($ids=array()) {
		$res = array('status'=>'ok', 'message'=>'не хвататет остатка');

		$connection = Yii::app()->db;
			// получаем остатки
		$sql_rest = "select gid as id, gname as name, price, sum(quantity)::real as rest
					from (
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, dd.quantity*o.operation as quantity, dd.price, 'd' as t
							from vgm_goods g
								inner join vgm_documentdata dd on g.id=dd.id_goods
								inner join vgm_document d on d.id=dd.id_doc
								inner join vgm_operation o on o.id=d.id_operation
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where d.doc_date<='".Yii::app()->session['workdate']."' and d.doc_date>='".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
								union
							select gg.id as ggid, gg.name as ggname, g.id as gid, g.name as gname, r.quantity, r.cost as price, 'r' as t
							from vgm_goods g
								inner join vgm_rest r on g.id=r.id_goods
								left join vgm_goodsgroup gg on gg.id=g.id_goodsgroup
							where r.rest_date::text like '".substr(Yii::app()->session['workdate'],0,7)."-01' and id_store=".Yii::app()->session['id_store']."
						 ) as motion
					group by ggid, ggname, gid, gname, price
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

	public function getUnitname() {
		if ($this->unit) {
			return (string)$this->unit->name;
		} else {
			return '';
		}
	}
	public function getTorg3name() {
		if ($this->torg3) {
			return (string)$this->torg3->name;
		} else {
			return '';
		}
	}
	public function getSuppliername() {
		if ($this->supplier) {
			return (string)$this->supplier->name;
		} else {
			return '';
		}
	}

	public function getContactname() {
		if ($this->contact) {
			return (string)$this->contact->name;
		} else {
			return '';
		}
	}

//	public function getRest() {
//		return 222;
//	}
}
