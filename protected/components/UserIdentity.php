<?php
class UserIdentity extends CUserIdentity
{
    private $_id;
    public function authenticate()      // проверка введённых пользователем данных
    {
    		// выбираем из базы пользователя по имени
    		// $this->username и $this->password - берутся из конструктора
        $record=User::model()->findByAttributes(array('login'=>$this->username));


        if ($record != null && $record->pass == $this->password) {  // если пользователь и парль верные
            if (!$record->canlogin){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
                $this->errorMessage = 'Вход пользователю <span class="wrong_uname"><u>"'.$record->login.'</u>"('.$record->name.')</span> запрещён Администратором!';
            } else {
                $this->_id=$record->id;
                //$this->setState('title', $record->title);
                $this->errorCode=self::ERROR_NONE;
            }
        } else {    // если неверный парль или пользователь
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = 'Неверный логин или пароль!';
        }

/*
        if($record===null) {
        		// если нет такого пользователя
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage = 'Неправильное имя пользователя.';
        } else {   // если логин есть - проверяем пароль
            if ($record->canlogin){     // если пользователю разрешён вход, то проверяем пароль
                if($this->password=$record->pass){
                        // если пароль верный
                    $this->_id=$record->id;
                    //$this->setState('title', $record->title);
                    $this->errorCode=self::ERROR_NONE;
                } else {    // если парль не верный
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                    $this->errorMessage = 'Неверный пароль!';
                }
            } else {    // если доступ пользователю закрыт, пароль можно не проверять
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
                $this->errorMessage = 'Вход пользователю <span class="wrong_uname">"'.$record->name.'"</span> запрещён Администратором!';
            }
        }*/

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}