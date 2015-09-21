<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 16.09.15
 * Time: 16:00
 */

class form_writeoff extends CFormModel
{
	public $nttn;
	public $date_ttn;
	public $n_pl;
	public $for;

	public function rules()
	{
		return array(
			array('nttn, date_ttn', 'required'),
//			array('timeToCall', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'nttn'=>'Номер ТН/ТТН',
			'date_ttn'=>'Дата ТН/ТТН',
			'n_pl'=>'Номер платёжного поручения',
			'for'=>'Товарооборот',
		);
	}
}
