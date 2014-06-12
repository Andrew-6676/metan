<?php

/**
 * This is the model class for table "{{rest}}".
 *
 * The followings are the available columns in table '{{rest}}':
 * @property integer $id
 * @property integer $id_store
 * @property integer $id_goods
 * @property string $rest_date
 * @property double $quantity
 * @property integer $cost
 *
 * The followings are the available model relations:
 * @property Goods $idGoods
 * @property Store $idStore
 */
class Rest extends CActiveRecord
{
    /**
     * @return string the associated database table name
    **/
    public function tableName()
    {
        return '{{rest}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_goods, rest_date', 'required'),
            array('id_store, id_goods, cost', 'numerical', 'integerOnly'=>true),
            array('quantity', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_store, id_goods, rest_date, quantity, cost', 'safe', 'on'=>'search'),
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
            'Goods' => array(self::BELONGS_TO, 'Goods', 'id_goods'),
            'Store' => array(self::BELONGS_TO, 'Store', 'id_store'),
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
            'id_goods' => 'Id Goods',
            'rest_date' => 'Дата',
            'quantity' => 'Кол-во',
            'cost' => 'Стоимость',
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
        $criteria->compare('id_goods',$this->id_goods);
        $criteria->compare('rest_date',$this->rest_date,true);
        $criteria->compare('quantity',$this->quantity);
        $criteria->compare('cost',$this->cost);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rest the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}