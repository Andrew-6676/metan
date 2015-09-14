<?php

/**
 * This is the model class for table "vgi_import".
 *
 * The followings are the available columns in table 'vgi_import':
 * @property integer $id
 * @property integer $id_store
 * @property string $kp
 * @property string $import_dir
 */
class iImport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vgi_import';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_store', 'numerical', 'integerOnly'=>true),
			array('kp', 'length', 'max'=>4),
			array('import_dir', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_store, kp, import_dir', 'safe', 'on'=>'search'),
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
			//'fields' => array(self::HAS_MANY, 'iFields', 'id_table'),
			'imptabl' => array(self::HAS_MANY, 'iImptabl', 'id_import'),
			'store' => array(self::BELONGS_TO, 'Store', 'id_store'),
//			'tables' => array(self::HAS_MANY, 'iTables', 'id_import', 'throught'=>'imptabl'),
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
			'kp' => 'Kp',
			'import_dir' => 'Import Dir',
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
		$criteria->compare('kp',$this->kp,true);
		$criteria->compare('import_dir',$this->import_dir,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return iImport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
