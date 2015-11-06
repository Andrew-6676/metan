<?php

/**
 * This is the model class for table "{{store}}".
 *
 * The followings are the available columns in table '{{store}}':
 * @property integer $id
 * @property string $name
 * @property string $fname
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Storepassport[] $storepassports
 * @property User[] $users
 * @property Document[] $documents
 * @property Remains[] $remains
 * @property Rest[] $rests
 *
 */
class Store extends CActiveRecord
{
	public $fio;
	public $phone;
	public $account;
	public $mfo;
	public $bank;
	public $fio_mpu;
	public $unn;
	public $okpo;
	public $lic;
	public $dov;
	public $address;
	public $pname;

//	public $tmp;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, fname, address, account', 'required'),
            array('name, fname', 'length', 'max'=>50),
            array('address', 'length', 'max'=>100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, fname, address', 'safe', 'on'=>'search'),
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
            'storepassports' => array(self::HAS_MANY, 'Storepassport', 'id_store'),
            // 'users' => array(self::HAS_MANY, 'User', 'id_store'),
            // 'documents' => array(self::HAS_MANY, 'Document', 'id_store'),
            // 'remains' => array(self::HAS_MANY, 'Remains', 'id_store'),
            // 'rests' => array(self::HAS_MANY, 'Rest', 'id_store'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'fname' => 'Полное наименование',

	        'fio'       =>'ФИО',
	        'phone'     =>'Телефон',
	        'account'   =>'Рассчётный счёт',
	        'mfo'       =>'МФО',
	        'bank'      =>'Банк',
	        'fio_mpu'   =>'ФИО2',
	        'unn'       =>'УНН',
	        'okpo'      =>'ОКПО',
	        'lic'       =>'Лицензия',
	        'dov'       =>'Доверенность',
	        'address'   =>'Адрес',
	        'pname'     =>'Полное наим',
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

        // $criteria->compare('id',$this->id);
        // $criteria->compare('name',$this->name,true);
        $criteria->compare('fname',$this->fname,true);
        // $criteria->compare('address',$this->address,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Store the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	protected function afterFind()
	{
		parent::afterFind();

		$tmp = Storepassport::model()->find('id_store='.$this->id);
//		$this->attributes = $tmp->attributes;
		if ($tmp) {
			$this->fio = $tmp->fio;
			$this->phone = $tmp->phone;
			$this->account = $tmp->account;
			$this->mfo = $tmp->mfo;
			$this->bank = $tmp->bank;
			$this->fio_mpu = $tmp->fio_mpu;
			$this->unn = $tmp->unn;
			$this->okpo = $tmp->okpo;
			$this->lic = $tmp->lic;
			$this->dov = $tmp->dov;
			$this->address = $tmp->address;
			$this->pname = $tmp->name;
		}
	}
	/*--------------------------------------------------------------------------------------*/
	protected function afterSave()
	{
		parent::afterSave();
		//             // если добавлена новая
		if ($this->isNewRecord) {
//			// сохранение дополнительных данных
//			if ($this->payment_order) {
//				$da = new Docaddition();
//				$da->id_doc = $this->id;
//				$da->payment_order = $this->payment_order;
//				$da->save();
//			}
		} else {
			$tmp = Storepassport::model()->find('id_store='.$this->id);

			$tmp->fio       = $this->fio;
			$tmp->phone     = $this->phone;
			$tmp->account   = $this->account;
			$tmp->mfo       = $this->mfo;
			$tmp->bank      = $this->bank;
			$tmp->fio_mpu   = $this->fio_mpu;
			$tmp->unn       = $this->unn;
			$tmp->okpo      = $this->okpo;
			$tmp->lic       = $this->lic;
			$tmp->dov       = $this->dov;
			$tmp->address   = $this->address;
			$tmp->name      = $this->pname;

			if ($tmp->save()) {
//				echo 'sssave';
				return true;
			}
		}
	}
}