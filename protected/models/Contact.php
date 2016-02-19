<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $id
 * @property string $name
 * @property string $fname
 * @property string $rs
 * @property string $mfo
 * @property string $okpo
 * @property string $unn
 * @property string $address
 * @property string $kpo
 * @property integer $parent
 * @property string $bank
 * @property string $agreement
 *
 * The followings are the available model relations:
 * @property Document[] $documents
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, fname, unn, rs, mfo', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>80),
			array('fname, address, agreement', 'length', 'max'=>255),
			array('rs', 'length', 'max'=>15),
			array('mfo', 'length', 'max'=>9),
			array('okpo', 'length', 'max'=>20),
			array('unn', 'length', 'max'=>10),
			array('kpo', 'length', 'max'=>5),
			array('bank', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, rs, mfo, okpo, unn, address, bank, agreement', 'safe', 'on'=>'search'),
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
			'documents' => array(self::HAS_MANY, 'Document', 'id_contact'),
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
			'fname' => 'Полное наименование',
			'rs' => 'Рассчётный счёт',
			'mfo' => 'МФО',
			'okpo' => 'ОКПО',
			'unn' => 'УНН',
			'address' => 'Адрес',
			'kpo' => 'для совместимости',
			'parent' => 'Parent',
			'bank' => 'Банк',
			'agreement' => 'Договор',
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
		$criteria->compare('name',$this->name,true);
		//$criteria->compare('fname',$this->fname,true);
		$criteria->compare('rs',$this->rs,true);
		$criteria->compare('mfo',$this->mfo,true);
		$criteria->compare('okpo',$this->okpo,true);
		$criteria->compare('unn',$this->unn,true);
		$criteria->compare('address',$this->address,true);
		//$criteria->compare('kpo',$this->kpo,true);
		//$criteria->compare('parent',$this->parent);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('agreement',$this->agreement,true);

		//$criteria->addCondition('parent=2');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
/*--------------------------------------------------------------------------------------------------------------------*/
	public function edit($new_contact) {
		return $this->add($new_contact);
	}
	public function add($new_contact) {
//		print_r($new_contact);
		$res = array('status'=>'','id'=>'-1');
		$this->parent   = 2;
		$this->attributes = $new_contact;

		if ($this->save()) {
			$res['status'] = 'ok';
			$res['id'] = $this->id;
		} else {
			$res['status'] = 'error!';
		};

		return $res;
	}

}
