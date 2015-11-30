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
//			array('name, id_3torg, producer', 'required'),
			array('name', 'required'),
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
		$date = substr(Yii::app()->session['workdate'],0,7).'-01';
		return array(
			'rests' => array(self::HAS_MANY, 'Rest', 'id_goods'),
			'rest0' => array(self::STAT, 'Rest', 'id_goods', 'select'=>'sum(quantity)','condition'=>'rest_date=\''.$date.'\'', /*'order'=>'rest_date desc',*/ 'defaultValue'=>0),
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
/*---------------------------------------------------------------------*/
	public function getPrice_prev() {

		$criteria = new CDbCriteria;
		$criteria->addCondition("id_goods=" . $this->id);


		$r = Rest::model()->find($criteria);
		if ($r) {
			return $r->price; //->getAttribute('price');
		} else {
			$r = Documentdata::model()->find($criteria);
			if ($r) {
				return $r->price;
			} else {
				return 0;
			}
		}
	}
/*---------------------------------------------------------------------*/
	public function getPrice() {

		$criteria = new CDbCriteria;
		$criteria->addCondition("id_goods=" . $this->id);
		$criteria->addCondition("idDocument.id_doctype=1");

		$r = Documentdata::model()->with('idDocument')->find($criteria);
		if ($r) {
			return $r->price; //->getAttribute('price');
		} else {
			$criteria->condition = '';
			$criteria->addCondition("id_goods=" . $this->id);
			$r = Rest::model()->find($criteria);
			if ($r) {
				return $r->price;
			} else {
				return 0;
			}
		}
	}
	/*---------------------------------------------------------------------*/
	public function getCost() {

		$criteria = new CDbCriteria;
		$criteria->addCondition("id_goods=" . $this->id);

		$r = Documentdata::model()->find($criteria);
		if ($r) {
			return $r->cost; //->getAttribute('price');
		} else {
			return -1;
		}
	}
	/*---------------------------------------------------------------------*/
	public function getMarkup() {
		$criteria = new CDbCriteria;
		$criteria->addCondition("id_goods=" . $this->id);

		$r = Documentdata::model()->find($criteria);
		if ($r) {
			return $r->markup; //->getAttribute('price');
		} else {
			return -1;
		}
	}
	/*--------------------------------------------------------------------*/
	public function getSamegoods() {
		$n = $this->name;
			// разбиваем наименование на слова
//		$n = explode(' ', $n);
//		$n = preg_split("/[\s,]+/", $n);
		$n = preg_split("/([\s,-\.\/])+/", $n, -1, PREG_SPLIT_DELIM_CAPTURE);
			// делаем пустую модель
//		$res = Goods::model()->findAll('id<0');
		$arr = array();

		$criteria = new CDbCriteria;

		//if (count($n) == 1)
		{
			$str = implode('', $n);
//			$arr[] = $str;
			$criteria->distinct=array('id_3torg');
			$criteria->select = "id_3torg";
			$criteria->addCondition('name like \''.$str.'%\'');
			$criteria->addCondition('id_3torg<>\'0\' and id_3torg<>\'\' ');
			$res = Goods::model()->findAll($criteria);
		} /*else*/ {
			while (!$res && count($n)>1) {
				array_pop($n);
				array_pop($n);
				//  склеивать строку пробелами - неправильно!
				$str = implode('', $n);
				$criteria->condition = '';
				$criteria->distinct=array('id_3torg');
				$criteria->select = "id_3torg";
				$criteria->addCondition('name like \''.$str.'%\'');
				$criteria->addCondition('id_3torg<>\'0\' and id_3torg<>\'\' ');
				$res = Goods::model()->findAll($criteria);
			}
		}


			// формируем массив из модели
		foreach ($res as $r) {
			$torg = Torg3::model()->findByPK($r->id_3torg);
			$arr[] = '<li tid="'.$r->id_3torg.'" title="'.$torg['descr'].'">['.$r->id_3torg.'] ' .$torg['name'].'</li>';
		}
		return array('count' => count($arr), 'data' => '<ul gid="'.$this->id.'" class="lst">'.implode('',$arr).'</ul>');
	}

//	public function getRest() {
//		if ($this->rests) {
////			Yii::app()->session['workdate']
//			return $this->rests;
//		} else {
//			return 0;
//		}
//	}
//	public function getRest() {
//		return 222;
//	}
}
