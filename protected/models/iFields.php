<?php

/**
 * This is the model class for table "vgi_fields".
 *
 * The followings are the available columns in table 'vgi_fields':
 * @property integer $id
 * @property integer $id_table
 * @property string $field_src
 * @property string $field_dst
 * @property boolean $key
 * @property string $type
 */
class iFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vgi_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_table', 'required'),
			array('id_table', 'numerical', 'integerOnly'=>true),
			array('field_src, field_dst', 'length', 'max'=>20),
			array('type', 'length', 'max'=>30),
			array('key', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_table, field_src, field_dst, key, type', 'safe', 'on'=>'search'),
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
			'table' => array(self::BELONGS_TO, 'iTables', 'id_table'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_table' => 'Id Table',
			'field_src' => 'Field Src',
			'field_dst' => 'Field Dst',
			'key' => 'Key',
			'type' => 'Type',
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
		$criteria->compare('id_table',$this->id_table);
		$criteria->compare('field_src',$this->field_src,true);
		$criteria->compare('field_dst',$this->field_dst,true);
		$criteria->compare('key',$this->key);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return iFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
