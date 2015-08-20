<?php

/**
 * This is the model class for table "{{storepassport}}".
 *
 * The followings are the available columns in table '{{storepassport}}':
 * @property integer $id
 * @property integer $id_store
 * @property string $fio
 * @property string $phone
 * @property string $account
 * @property string $mfo
 * @property string $bank
 * @property string $fio_mpu
 * @property string $unn
 * @property string $okpo
 * @property string $lic
 * @property string $dov
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Store $idStore
 */
class Storepassport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{storepassport}}';
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
			array('fio, fio_mpu', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('account', 'length', 'max'=>13),
			array('mfo, unn', 'length', 'max'=>9),
			array('bank', 'length', 'max'=>200),
			array('okpo', 'length', 'max'=>8),
			array('lic, dov', 'length', 'max'=>30),
			array('address', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_store, fio, phone, account, mfo, bank, fio_mpu, unn, okpo, lic, dov, address', 'safe', 'on'=>'search'),
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
			'store' => array(self::BELONGS_TO, 'Store', 'id_store'),
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
			'fio' => 'Fio',
			'phone' => 'Phone',
			'account' => 'Account',
			'mfo' => 'Mfo',
			'bank' => 'Bank',
			'fio_mpu' => 'Fio Mpu',
			'unn' => 'Unn',
			'okpo' => 'Okpo',
			'lic' => 'Lic',
			'dov' => 'Dov',
			'address' => 'Address',
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
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('mfo',$this->mfo,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('fio_mpu',$this->fio_mpu,true);
		$criteria->compare('unn',$this->unn,true);
		$criteria->compare('okpo',$this->okpo,true);
		$criteria->compare('lic',$this->lic,true);
		$criteria->compare('dov',$this->dov,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Storepassport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
