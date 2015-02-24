<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property integer $id_store
 * @property integer $id_group
 * @property string $name
 * @property string $login
 * @property string $pass
 * @property string $post
 *
 * The followings are the available model relations:
 * @property Group $idGroup
 * @property Store $idStore
 */
class User extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_store, id_group, name, login, pass', 'required'),
            array('id_store, id_group', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>150),
            array('login', 'length', 'max'=>20),
            array('pass', 'length', 'max'=>64),
            array('post', 'length', 'max'=>200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_store, id_group, name, login, pass, post', 'safe', 'on'=>'search'),
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
            'idGroup' => array(self::BELONGS_TO, 'Group', 'id_group'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
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
            'id_group' => 'Id Group',
            'name' => 'ФИО',
            'login' => 'Логин',
            'pass' => 'Пароль',
            'post' => 'Должность',
            'canlogin' => 'Доступ',
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
        $criteria->compare('id_group',$this->id_group);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('login',$this->login,true);
        $criteria->compare('pass',$this->pass,true);
        $criteria->compare('post',$this->post,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}