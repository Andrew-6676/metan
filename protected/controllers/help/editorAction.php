<?php

class editorAction extends CAction   /*HelpController*/
{
   public function run($c='0', $a='0', $i='0')
	{

		if(Yii::app()->request->isAjaxRequest) {
			$h = Help::model()->findByPK($_POST['id']);

			$h->title = $_POST['name'];
			$h->text = $_POST['text'];

			if ($h->save()) {
				echo "ok";
			} else {
				echo "err: ".print_r($h->getErrors(), true);
			}
			Yii::app()->end();
		}

//		$criteria = new CDbCriteria;
//    	// $criteria->order ='sort, id';
//    	$criteria->addCondition('controller=\''.$c.'\'');
//    	$criteria->addCondition('action=\''.$a.'\'');
//    	$criteria->addCondition('index=\''.$i.'\'');
		$data = Help::model()->findByPK($_GET['id']); //($criteria);
		$menuTmp=Help::model()->findAll();
		
		foreach ($menuTmp as $key => $value) {
			$this->controller->menu[] = array('label'=>$value->title, 'url'=>array('help/index/c/'.$value->controller.'/a/'.$value->action.'/i/'.$value->index),'itemOptions'=>array('class'=>'leftmenu_li'),'linkOptions'=>array('class'=>'leftmenu_li_a'));
		}

		$this->controller->render('editor', array(
			'data'=>$data,
			));
	}
}