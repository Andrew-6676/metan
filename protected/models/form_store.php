<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 28.08.15
 * Time: 9:40
 */

class form_store extends CFormModel{
	public $name;
	public $fname;

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
			'name'      =>'Название',
			'fname'     =>'Нименование (для документов)',

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
			'address'   =>'Адрес'
		);
	}
}
