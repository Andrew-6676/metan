<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.07.15
 * Time: 11:58
 */
class form_ttn extends CFormModel
{
	public $addr1;
	public $otpusk;
	public $sdal;
	public $car;
	public $driver;

//	public function rules()
//	{
//		return array(
//			array('name, phone', 'required'),
//			array('timeToCall', 'safe'),
//		);
//	}

	public function attributeLabels()
	{
		return array(
			'addr1'=>'Адрес разгрузки',
			'otpusk'=>'Отпуск разрешил',
			'sdal'=>'Сдал',
			'car'=>'Автомобиль',
			'driver'=>'Водитель',
		);
	}
}
