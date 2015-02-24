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
 */
class Store extends CActiveRecord
{
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
            array('name', 'required'),
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
            'name' => 'Наименование',
            'fname' => 'Полное наименование',
            'address' => 'Адрес',
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
}