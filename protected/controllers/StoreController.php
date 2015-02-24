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
            'index'     => 'application.controllers.store.indexAction',
            'receipt'   => 'application.controllers.store.receiptAction',
            'expense_day'=> 'application.controllers.store.expense_dayAction',
            'expense'   => 'application.controllers.store.expenseAction',
            'return'    => 'application.controllers.store.returnAction',
            'rest'      => 'application.controllers.store.restAction',
            'restEdit'  => 'application.controllers.store.restEditAction',
            'restClose' => 'application.controllers.store.restCloseAction',
            'invoice'   => 'application.controllers.store.invoiceAction',
            'print'     => 'application.controllers.store.printAction',
        );
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
                'actions'=>array('receipt',
                                 'expense',
                                 'invoice',
                                 'rest',
                                 'restEdit',
                                 'restClose'),	       	// запреить всем доступ к "*"
                'users'=>array('?'),					// запрет должен стоять после разрешения
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