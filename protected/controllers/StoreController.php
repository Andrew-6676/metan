<?php
//  Yii::app()->session['user_id']
/**
 * SiteController is the default controller to handle user requests.
 */
class StoreController extends Controller
{
	//public id_store=-99;

	/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
	{
		return array(
//	        'getForm'   => 'application.controllers.store.getFormAction',
			'index' => 'application.controllers.store.indexAction',
			'store' => 'application.controllers.store.storeAction',
			'reports' => 'application.controllers.store.reportsAction',
			'dir' => 'application.controllers.store.dirAction',
			'kassa' => 'application.controllers.store.kassaAction',
			'receipt' => 'application.controllers.store.receiptAction',
			'expense_day' => 'application.controllers.store.expense_dayAction',
			'expense' => 'application.controllers.store.expenseAction',
			'kredit' => 'application.controllers.store.kreditAction',   // кредит
			'kredit2' => 'application.controllers.store.kredit2Action', //  рассрочка
			'return' => 'application.controllers.store.returnAction',
			'rest' => 'application.controllers.store.restAction',
			'restEdit' => 'application.controllers.store.restEditAction',
			'goodsCart' => 'application.controllers.store.goodsCartAction',
			'restClose' => 'application.controllers.store.restCloseAction',
			'invoice' => 'application.controllers.store.invoiceAction',
			'revaluation' => 'application.controllers.store.revaluationAction',
			'print' => 'application.controllers.store.printAction',
			'svodDay' => 'application.controllers.store.svodDayAction',
			'prepareGoodsreport' => 'application.controllers.store.prepareGoodsreportAction',
			'prepareGruntreport' => 'application.controllers.store.prepareGruntreportAction',
			'prepareDeliverynote' => 'application.controllers.store.prepareDeliverynoteAction',
			'prepareWriteoff' => 'application.controllers.store.prepareWriteoffAction',
		);
	}

	/*--------------------------*/
	public function actionGetform($form)
	{
		$this->renderPartial('forms/_' . $form);
	}

	/* ------------------------- фильтры -------------------------*/
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/* --------------------------- паравила доступа для контроллера ---------------*/
	public function accessRules()
	{
		return array(
			// правила просматриваются по порядку до первого совпадения
			// array('allow',
			//        'actions'=>array('receipt','expense','rest'),          	// только пользователи "prod, admin" получат доступ
			//        'users'=>array('prod', 'admin'),					// остальным выдаст ошибку
			//    ),
			array('deny',
//				'actions' => array('expense_day',
//					'print',
//					'return',
//					'receipt',
//					'expense',
//					'invoice',
//					'rest',
//					'restEdit',
//					'restClose',
//					'setGoodsreport'),            // запреить всем доступ к "*"
				'users' => array('?'),                    // запрет должен стоять после разрешения
			),
		);
	}

}

/*
*: любой пользователь, включая анонимного.
?: анонимный пользователь.
@: аутентифицированный пользователь.

ips: позволяет указать IP-адрес;
verbs: позволяет указать тип запросов (например, GET или POST). Сравнение регистронезависимо;
expression: позволяет указать выражение PHP, вычисление которого будет определять совпадение правила. Внутри выражения доступна переменная $user, указывающая на Yii::app()->user.

*/