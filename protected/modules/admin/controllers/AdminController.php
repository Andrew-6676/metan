<?php
class AdminController extends \Controller
{
     public $breadcrumbs = array();  // это необходимо (как стимул__)

    public function actionIndex()
    {


        $this->render('index');
    }
}