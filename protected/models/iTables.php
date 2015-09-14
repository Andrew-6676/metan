<?php

/**
 * This is the model class for table "vgi_tables".
 *
 * The followings are the available columns in table 'vgi_tables':
 * @property integer $id
 * @property string $table_src
 * @property string $table_dst
 * @property string $name
 * @property string $mode
 * @property boolean $enabled
 * @property string $fk
 * @property integer $sort
 * @property string $filter
 * @property string $sql
 */
class iTables extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vgi_tables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sort', 'numerical', 'integerOnly'=>true),
			array('table_src, fk', 'length', 'max'=>100),
			array('table_dst', 'length', 'max'=>20),
			array('name', 'length', 'max'=>50),
			array('mode', 'length', 'max'=>4),
			array('filter', 'length', 'max'=>255),
			array('enabled, sql', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, table_src, table_dst, name, mode, enabled, fk, sort, filter, sql', 'safe', 'on'=>'search'),
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
			//'idDocument' => array(self::BELONGS_TO, 'Document', 'id_doc'),
			'imptabl' => array(self::HAS_MANY, 'iImptabl', 'id_table'),
			'fields' => array(self::HAS_MANY, 'iFields', 'id_table'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'table_src' => 'Table Src',
			'table_dst' => 'Table Dst',
			'name' => 'Name',
			'mode' => 'all - все записи импортирова
one - только одну
diff - только разные',
			'enabled' => 'Enabled',
			'fk' => 'Fk',
			'sort' => 'Sort',
			'filter' => 'Filter',
			'sql' => 'Sql',
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
		$criteria->compare('table_src',$this->table_src,true);
		$criteria->compare('table_dst',$this->table_dst,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mode',$this->mode,true);
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('fk',$this->fk,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('filter',$this->filter,true);
		$criteria->compare('sql',$this->sql,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return iTables the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
