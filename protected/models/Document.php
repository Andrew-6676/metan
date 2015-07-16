<?php
class Document extends CActiveRecord
{
        /* для вставки в подчинённую атблицу*/
    // public $id_doc;
    // // public $id_owner;
    // // public $id_editor;
    // // public $date_insert;
    // // public $date_edit;
    // public $id_goods;
    // public $cost;
    // public $markup;
    // public $vat;
    // public $quantity;
    // public $packages;
    // public $gross;
    // public $price;
        /*--------------------------------*/

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{document}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_owner, id_editor, id_storage', 'required'),
            array('id_store, id_owner, id_editor, doc_num2, id_contact, id_storage, id_operation', 'numerical', 'integerOnly'=>true),
            array('active','boolean'),
            array('doc_num', 'length', 'max'=>7),
            array('reason', 'length', 'max'=>50),
            array('date_insert, date_edit, doc_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('doc_num, doc_num2, doc_date', 'safe', 'on'=>'search'),
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
            'documentdata' => array(self::HAS_MANY, 'Documentdata', 'id_doc'),
            'idContact' => array(self::BELONGS_TO, 'Contact', 'id_contact'),
	        'contact' => array(self::BELONGS_TO, 'Contact', 'id_contact'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
            'idEditor' => array(self::BELONGS_TO, 'User', 'id_editor'),
            'idOwner' => array(self::BELONGS_TO, 'User', 'id_owner'),
	        'idOperation' => array(self::BELONGS_TO, 'Operation', 'id_operation'),
	        'operation' => array(self::BELONGS_TO, 'Operation', 'id_operation'),
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
            'id_owner' => 'Id Owner',
            'id_editor' => 'Id Editor',
            'date_insert' => 'Date Insert',
            'date_edit' => 'Date Edit',
            'doc_num' => '№ ТТН',
            'doc_num2' => 'Doc Num2',
            'doc_date' => 'Дата',
            'id_contact' => 'Id Contact',
            'id_storage' => 'Id Storage',
            'reason' => 'Основание',
            'id_operation' => 'Id Operation',
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

        $criteria->compare('doc_num',$this->doc_num,true);
        $criteria->compare('doc_num2',$this->doc_num2);
        $criteria->compare('doc_date',$this->doc_date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Deliverynote the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

/*--------------------------------------------------------------------------------------------*/
        /* после добавления в родительскую таблицу, добавляем в дочернюю*/
    // protected function afterSave() {
    //         parent::afterSave();
    //             // если добавлена новая
    //         if($this->isNewRecord){
    //             $doc_data = new Documentdata;

    //             $doc_data->id_doc       = $this->id;
    //             $doc_data->id_owner     = $this->id_owner;
    //             $doc_data->id_editor    = $this->id_editor;
    //             $doc_data->date_insert  = $this->date_insert;
    //             $doc_data->date_edit    = $this->date_edit;
    //             $doc_data->id_goods     = $this->id_goods;
    //             $doc_data->cost         = $this->cost;
    //             $doc_data->markup       = $this->markup;
    //             $doc_data->vat          = $this->vat;
    //             $doc_data->quantity     = $this->quantity;
    //             $doc_data->packages     = $this->packages;
    //             $doc_data->gross        = $this->gross;
    //             $doc_data->price        = $this->price;

    //             $doc_data->save();
    //         } else {     // иначе неободимо обновить данные в дочерней таблице

    //          // UserProfile::model()->updateAll(array( 'user_id' =>$this->id,
    //          //                                    'name' => $this->name,
    //          //                                    'first_name'=>$this->first_name,
    //          //                                    'description'=>$this->description
    //          //        ), 'user_id=:user_id', array(':user_id'=> $this->id));
    //         }
    //     }

    /*--------------------------------------------------*/

    public function add($data) {
            //$gr = $this->groups;
            //return ;
    }

    public function del($id) {
            //$gr = $this->groups;
            //return ;
    }

    // public function maxID() {

    // }
}

                // documentdata
            // 'id' => 'Код',
            // 'id_doc' => 'Id Doc',
            // 'id_owner' => 'Id Owner',
            // 'id_editor' => 'Id Editor',
            // 'date_insert' => 'Date Insert',
            // 'date_edit' => 'Date Edit',
            // 'id_goods' => 'Id Goods',
            // 'cost' => 'Цена поставщики',
            // 'markup' => 'Надбавка',
            // 'vat' => 'НДС',
            // 'quantity' => 'Кол-во',
            // 'packages' => 'Грузовых мест',
            // 'gross' => 'Брутто',
            // 'price' => 'Цена розничная',
