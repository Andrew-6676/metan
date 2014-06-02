<?php

class indexAction extends CAction   /*DirectoryController*/
{
   public function run()
	{
		$mess = '';
		$model = null;
		$columns = null;

		if (isset($_GET['dir'])) {
			$mess = '/dir/'.$_GET['dir'];
			switch ($_GET['dir']) {
				case 'operations':
					//$model = new Operations();
					//$res = Operations::model()->findAll('id > :id', array(':id'=>0));

					$model = new Operation();
					$model->unsetAttributes();
					//$model = Operations::model()->findAll();
					$columns = array('id', 'name', );

				break;

				case 'cont':
					// поставщики
					$model = new Contact();
					$columns = array('id', 'name', 'fname', 'rs', 'mfo', 'okpo',  'address');
				break;

				case 'users':
					// пользователи
					$model = new User();
					$columns = array('id', 'name', 'login', 'post', 'canlogin', );
				break;

				case 'unit':
					// пользователи
					$model = new Unit();
					$columns = array('id', 'name');
				break;

				default:
					$mess = 'Ошибка. По идее этого текста никогда недолжно быть видно';
				break;
				}

				$columns[] = array('class'=>'CButtonColumn',);
			}

		$this->controller->render('index', array(
										'mess'=>$mess,
										'model'=>$model,
										'columns'=>$columns,
								));
	}
}