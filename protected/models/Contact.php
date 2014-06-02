<?php

/**
 * This is the model class for table "{{plpost}}".
 *
 * The followings are the available columns in table '{{plpost}}':
 * @property integer $id
 * @property string $name
 * @property string $fname
 * @property string $rs
 * @property string $mfo
 * @property string $okpo
 * @property string $unn
 * @property string $address
 * @property string $kpo
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
            array('name', 'length', 'max'=>80),
            array('fname, address', 'length', 'max'=>255),
            array('rs', 'length', 'max'=>15),
            array('mfo', 'length', 'max'=>9),
            array('okpo', 'length', 'max'=>20),
            array('unn', 'length', 'max'=>10),
            array('kpo', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, fname, rs, mfo, okpo, unn, address, kpo', 'safe', 'on'=>'search'),
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
            'name' => 'Наименование',
            'fname' => 'Полное наименование',
            'rs' => 'Расчётный счёт',
            'mfo' => 'МФО',
            'okpo' => 'ОКПО',
            'unn' => 'УНН',
            'address' => 'Адрес',
            'kpo' => 'KPO(для совместимости)',
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
        $criteria->compare('fname',$this->fname,true);
        $criteria->compare('rs',$this->rs,true);
        $criteria->compare('mfo',$this->mfo,true);
        $criteria->compare('okpo',$this->okpo,true);
        $criteria->compare('unn',$this->unn,true);
        $criteria->compare('address',$this->address,true);
        $criteria->compare('kpo',$this->kpo,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Plpost the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}