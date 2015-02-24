<?php
class Documentdata extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{documentdata}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_doc, id_owner, id_editor, id_goods', 'required'),
            array('id_doc, id_owner, id_editor, id_goods, cost, packages, gross, price', 'numerical', 'integerOnly'=>true),
            array('quantity', 'numerical'),
            array('markup, vat', 'length', 'max'=>2),
            array('date_insert, date_edit', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cost, quantity, price', 'safe', 'on'=>'search'),
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
            'idDocument' => array(self::BELONGS_TO, 'Document', 'id_doc'),
            'idGoods' => array(self::BELONGS_TO, 'Goods', 'id_goods'),
            'idEditor' => array(self::BELONGS_TO, 'User', 'id_editor'),
            'idOwner' => array(self::BELONGS_TO, 'User', 'id_owner'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Код',
            'id_doc' => 'Id Doc',
            'id_owner' => 'Id Owner',
            'id_editor' => 'Id Editor',
            'date_insert' => 'Date Insert',
            'date_edit' => 'Date Edit',
            'id_goods' => 'Id Goods',
            'cost' => 'Цена поставщики',
            'markup' => 'Надбавка',
            'vat' => 'НДС',
            'quantity' => 'Кол-во',
            'packages' => 'Грузовых мест',
            'gross' => 'Брутто',
            'price' => 'Цена розничная',
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

        $criteria->compare('cost',$this->cost);
        $criteria->compare('quantity',$this->quantity);
        $criteria->compare('price',$this->price);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Deliverynotelist the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
