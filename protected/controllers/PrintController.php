<?php
//  Yii::app()->session['user_id']
/**
 * SiteController is the default controller to handle user requests.
 */
class PrintController extends Controller {
	public $layout = '//layouts/print';
	//public id_store=-99;

/* --------------------- инициализация печати------------ ---------------*/
	public function actionIndex($report, $orient='L', $format='pdf') {
//		if ($report=='Deliverynote') {
//			 $m = array(20,15,5,5,0,0);
//		}
		if (isset($_GET['m'])) {
			$m = $_GET['m'];
		} else {
			$m = array(20,5,5,5,0,0);
		}
		$printer = new PrintPDF('A4', $orient, $m);
		// echo $report;
		// Utils::print_r($_GET);
		// echo http_build_query($_GET);
		// echo 'http://localhost/metan_0.1/print/print'.$report.'?'.http_build_query($_GET).'&id_store='.Yii::app()->session['id_store'].'&workdate='.Yii::app()->session['workdate'];

			// вызываем нужный Action и передаём ему параметры
		switch ($format) {
			case 'pdf':
				echo $printer->printFromURL('http://'.Yii::app()->request->ServerName.Yii::app()->params['rootFolder'].'/print/print' . $report . '?' . http_build_query($_GET) . '&id_store=' . Yii::app()->session['id_store'] . '&workdate=' . Yii::app()->session['workdate']. '&u=' . Yii::app()->session['id_user']);
				break;
			case 'html':
				$this->redirect('http://'.Yii::app()->request->ServerName.Yii::app()->params['rootFolder'].'/print/print' . $report . '?' . http_build_query($_GET) . '&id_store=' . Yii::app()->session['id_store'] . '&workdate=' . Yii::app()->session['workdate']);
				break;
			default:
				echo "Указан неверный формат";

		}


		// echo(Yii::app()->session['id_store']);
		// echo 'http://localhost/metan_0.1/print/print'.$report.'?id_store='.Yii::app()->session['id_store'].'&workdate='.Yii::app()->session['workdate'];
		//       echo $printer->getInfo();
		// switch ($report) {
		//     case 'rest':
		//         // echo 'http://localhost/metan_0.1/print/printRest?id_store='.Yii::app()->session['id_store'].'&workdate='.Yii::app()->session['workdate'];

		//         break;

		//     default:
		//         echo 'Не указан отчёт!';
		//         break;
		// }

	}
/* --------------------- список всех действий контроллера ---------------*/
	public function actions() {
		return array(
			'printKredit' => 'application.controllers.print.printKreditAction',
			'printRest' => 'application.controllers.print.printRestAction',
			'printReceipt' => 'application.controllers.print.printReceiptAction',
			'printPricelabel' => 'application.controllers.print.printPricelabelAction',
			'printInvoice' => 'application.controllers.print.printInvoiceAction',
			'printExpenceday' => 'application.controllers.print.printExpencedayAction',
			'printDeliverynote' => 'application.controllers.print.printDeliverynoteAction',
			'printGoodsreport' => 'application.controllers.print.printGoodsreportAction',
			'pr' => 'application.controllers.print.prAction',
			'torg6' => 'application.controllers.print.printTorg6Action',
		);
	}

/* ------------------------- фильтры -------------------------*
public function filters()
{
return array(
'accessControl',
);
}
/* --------------------------- паравила доступа для контроллера ---------------*
public function accessRules()
{
return array(
// правила просматриваются по порядку до первого совпадения
// array('allow',
//        'actions'=>array('receipt','expense','rest'),          	// только пользователи "prod, admin" получат доступ
//        'users'=>array('prod', 'admin'),					// остальным выдаст ошибку
//    ),
array('deny',
'actions'=>array('receipt','expense','rest'),	       	// запреить всем доступ к "*"
'users'=>array('?'),					// запрет должен стоять после разрешения
),
);
}*/

}

/*
 *: любой пользователь, включая анонимного.
?: анонимный пользователь.
@: аутентифицированный пользователь.

ips: позволяет указать IP-адрес;
verbs: позволяет указать тип запросов (например, GET или POST). Сравнение регистронезависимо;
expression: позволяет указать выражение PHP, вычисление которого будет определять совпадение правила. Внутри выражения доступна переменная $user, указывающая на Yii::app()->user.

 */