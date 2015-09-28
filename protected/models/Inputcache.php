<?php

/**
 * This is the model class for table "vg_inputcache".
 *
 * The followings are the available columns in table 'vg_inputcache':
 * @property integer $id
 * @property integer $id_store
 * @property string $input
 * @property string $str
 *
 * The followings are the available model relations:
 * @property VgmStore $idStore
 */
class Inputcache extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vg_inputcache';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_store', 'required'),
			array('id_store', 'numerical', 'integerOnly'=>true),
			array('input', 'length', 'max'=>50),
			array('str', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_store, input, str', 'safe', 'on'=>'search'),
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
			'idStore' => array(self::BELONGS_TO, 'VgmStore', 'id_store'),
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
			'input' => 'Input',
			'str' => 'Str',
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
		$criteria->compare('input',$this->input,true);
		$criteria->compare('str',$this->str,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inputcache the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getList($input) {
		$list = self::model()->findAll("input='".$input."'");
//		return $list[0]->getAttribute('str');
		return $list;
	}


	/*--------------------------------------------------------------------------------------------*/
	public function init() {
		$this->id_store  = Yii::app()->session['id_store'];
	}

	/*--------------------------------------------------------------------------------------------*/
	public static function addstr($arr) {

		// перебираем массив $arr и если нету соотв. записи в таблице - заносим

//		foreach

		return true;
	}
}
