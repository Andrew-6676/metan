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
	public $dover;
	public $osnovanie;
	public $p_razgruz;
	public $vladelec;
	public $zakazchik;

	public $fields = array(
		'addr1',
		'otpusk',
		'sdal',
		'car',
		'driver',
		'dover',
		'osnovanie',
		'p_razgruz',
		'vladelec',
		'zakazchik',
	);

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
			'addr1'     =>'Адрес разгрузки',
			'otpusk'    =>'Отпуск разрешил',
			'sdal'      =>'Сдал',
			'car'       =>'Автомобиль',
			'driver'    =>'Водитель',
			'dover'     =>'Доверенность',
			'osnovanie' =>'Основание для отпуска',
			'p_razgruz' =>'Пункт разгрузки',
			'vladelec'  =>'Владелец транспрорта',
			'zakazchik' =>'Заказчик перевозки',
		);
	}
}
