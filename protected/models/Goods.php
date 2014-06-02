<?php
class Goods extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{goods}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_unit, id_supplier', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>200),
            array('producer', 'length', 'max'=>150),
            array('norder', 'length', 'max'=>100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, producer, norder', 'safe', 'on'=>'search'),
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
            'deliverynotelists' => array(self::HAS_MANY, 'Deliverynotelist', 'id_goods'),
            'idUnit' => array(self::BELONGS_TO, 'Unit', 'id_unit'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Наименование',
            'producer' => 'Производитель',
            'norder' => '№ прик.',
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
        $criteria->compare('id_unit',$this->id_unit);
        $criteria->compare('producer',$this->producer,true);
        $criteria->compare('norder',$this->norder,true);
        $criteria->compare('id_supplier',$this->id_supplier);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Goods the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}