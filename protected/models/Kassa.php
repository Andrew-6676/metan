<?php

/**
 * This is the model class for table "{{kassa}}".
 *
 * The followings are the available columns in table '{{kassa}}':
 * @property integer $id
 * @property string $kassa_date
 * @property integer $sum
 * @property integer $id_store
 */
class Kassa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{kassa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sum, id_store', 'numerical', 'integerOnly'=>true),
			array('kassa_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, kassa_date, sum, id_store', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'kassa_date' => 'Дата',
			'sum' => 'Остаок',
			'id_store' => 'Id Store',
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
		$criteria->compare('kassa_date',$this->kassa_date,true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('id_store',$this->id_store);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kassa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/*----------------------------------------------*/
	public static function getRest($date=0, $store=0){
		if ($date == 0 ) $date=Yii::app()->session['workdate'];
		if ($store == 0 ) $store=Yii::app()->session['id_store'];
		$criteria = new CDbCriteria;
		$criteria->addCondition("kassa_date='".$date."'");
		$criteria->addCondition("id_store=".$store);

		$r = Kassa::model()->find($criteria);
		if ($r) {
			return $r->getAttribute('sum');
		} else {
			return -1;
		}
	}
}
