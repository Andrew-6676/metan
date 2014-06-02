<?php

class HelpController extends ControllerH
{
/* --------------------- список всех действий контроллера ---------------*/
	public function actions()
    {
        return array(
        	'index'=>'application.controllers.help.indexAction',
        );
    }

}