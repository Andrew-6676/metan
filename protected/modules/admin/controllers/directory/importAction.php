<?php

class importAction extends CAction   /* DirectoryController */
{
   public function run()
   {
        	// если форма отправлена ----------------------------------------------------
   		//if(Yii::app()->request->isAjaxRequest)
   		{
        if (isset($_POST['import']))
        {
        	Yii::app()->session['import'] = $_POST['import'];
        	// копируем данные из DBF в БД в соответствии с значениями в $_POST['import']
        	//if (isset())
        	echo '<pre>';
			print_r($_POST['import']);
			echo '</pre>';
			//echo '<br><br>';
			$arr = array();
			//preg_match('/(^vg.?_)(.*)/', $_POST['import']['new_tname'], $arr);
			//print_r($arr[2]);
			//echo '<br><br>';

			// начать транщакцию
			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			try
			{
			 		// создать новую таблицу с именем $_POST['import']['new_tname'] и полями из $_POST['import']['field_dst']
			 	if (isset($_POST['import']['create']) && $_POST['import']['create']=='on')
			 	{
			 		preg_match('/(^vg.?_)(.*)/', $_POST['import']['new_tname'], $arr);
			 		$sql_1 = 'create sequence seq_id_'.$arr[2].' INCREMENT 1 MINVALUE 0 START 0';
			 		$sql_2 = 'CREATE TABLE '.$_POST['import']['new_tname'].' ('."\n".
			 				'id integer DEFAULT nextval(\'seq_id_'.$arr[2].'\') PRIMARY KEY NOT NULL'.
			 				'{fields}'.
			 				')';
						// ---------------- цикл по $_POST['import']['field_dst'] ----------------- //
						/*   формируем запрос для создания таблицы (список полей)   */
					$f_str = '';
					foreach ($_POST['import']['field_dst'] as $key => $val) {
						//$ft = (empty($_POST['import']['field_dst_type'])) ? 'default' : $_POST['import']['field_dst_type'];
						if ($val != '') {
							$f_str .= ",\n".$val.' '.$_POST['import']['field_dst_type'][$key]."";
						}
					}
					$sql_2 = preg_replace('/\{.*\}/', $f_str, $sql_2);	// готовый запрос на создание таблицы
					echo '<pre>';
					echo $sql_1;
					echo '<br><br>';
					echo $sql_2;
					echo '<br><br></pre>';
					// 		$connection->createCommand($sql)->execute();
			 	}   /* if (isset($_POST['import']['create']) && $_POST['import']['create']=='on')
			 	{ */

			// -------------------- переносим записи из dbf в Postgres ------------------ //

			 		// если выбрано "очистить таблицу"
			 	//if ($_POST['import']['radio']=='replace')
			 	if (isset($_POST['import']['replace']) && $_POST['import']['replace']=='on')
			 	{
			 		$sql_del = 'truncate table '.$_POST['import']['tname'];
			 		//$connection->createCommand($sql_del)->execute();		// удаляем данные из ьаблицы
			 	}

			 	DTimer::log('перед началом импорта');	// засекаем время выполнения

			 	$dbf = new dbf($_POST['import']['path']);	// открываем файл *.dbf
			 	if ($dbf)
			 	{
			 			// ----------- подготовить список полей и параметров для запроса ------- //
					$f_arr = array();	// поля таблицы в которую вставляют
					$p_arr = array();	// параметры для вставки
					$v_arr = array();	// из каких полей брать значения
					$u_arr = array();	// для UPDATE

						// каждому полю из DST сопостовляем поле из SRC

					foreach ($_POST['import']['field_dst'] as $key => $val) {
						if ($val != '') {
							$f_arr[] = $val;
							$p_arr[] = ':'.$val;
							$v_arr[] = $_POST['import']['field_src'][$key];
							$u_arr[] = $val .'='.':'.$val;
						}
					}

			 			// ----------------- формируем текст запроса --------------------------------------- //
					//$sql_i="INSERT INTO ".$_POST['import']['tname']."({fields}) VALUES({values})";
							// запрос для добавления
					$sql_i="INSERT INTO ".$_POST['import']['tname']."(".implode(',',$f_arr).") VALUES(".implode(',',$p_arr).")";
							// запрос для обновления
					$sql_u="UPDATE ".$_POST['import']['tname']." SET \n".implode(",\n",$u_arr).' WHERE '.$_POST['import']['key_field_dst'].'=:'.$_POST['import']['key_field_src'];
//					echo $sql_u;

//				    return;
					echo "<pre>";
					// print_r($sql_del)."\n";
					print_r($sql_i)."\n<br>";
					print_r($sql_u)."\n";

					$command_i = $connection->createCommand($sql_i);	// запрос для вставки
					$command_u = $connection->createCommand($sql_u);	// запрос для обновления

			 		//цикл по всем записям в dbf
			 		$i = 0;
			 		while($row = $dbf->readRec())
			 		{
							// если выбрано ОБНОВИТЬ/ДОБАВИТЬ
			 			if (isset($_POST['import']['radio']) && $_POST['import']['radio']=='update')
			 			{
			 				// проверяем, есть ли нужная запись в БД
						    if (trim($row[$_POST['import']['key_field_src']])=='') {
							    echo "----continue----";
							    continue;
						    }
			 				$sql_tmp = 'SELECT count('.$_POST['import']['key_field_dst'].') as c from '.$_POST['import']['tname'].' WHERE '.$_POST['import']['key_field_dst'].'='.$row[$_POST['import']['key_field_src']];
							$r = $connection->createCommand($sql_tmp)->queryRow();

								//print_r($sql_tmp."\n ---r= ");
								//print_r($r['c']." -- \n");
								//print_r($sql_u."\n ---------------------- ");

			 				// если есть - выполняем запрос на обновление
							if ($r['c'] > 0)
							{
								//echo "\n";
									// присваиваем параметрам значения (цикл по масиву параметров)
					 			foreach ($p_arr as $key => $val)
					 			{

								    $str = trim($row[$v_arr[$key]]);
								    if (trim($row[$v_arr[$key]])=='') {$str = "0";}
//								    echo "-$str-";
								    echo $val.' --> '.mb_convert_encoding($str, "UTF-8", "cp866")."\n";
								    $command_u->bindParam($val, mb_convert_encoding($str, "UTF-8", "cp866"));
					 			}
					 			//echo ':KPO'.' --> '.mb_convert_encoding($row['KPO'], "UTF-8", "cp866")."\n";
//					 			$command_u->bindParam(':KPO', mb_convert_encoding($row['KPO'], "UTF-8", "cp866"));
								echo ':'.$_POST['import']['key_field_src'].' --> '.mb_convert_encoding($row[$_POST['import']['key_field_src']], "UTF-8", "cp866")."\n\n";
								$command_u->bindParam(':'.$_POST['import']['key_field_src'], mb_convert_encoding($row[$_POST['import']['key_field_src']], "UTF-8", "cp866"));
								$command_u->execute();	// обновляем запись

							} else {	// if $r['c']
								// если нечего обновлять - добавляем
								foreach ($p_arr as $key => $val)
					 			{
					 				$command_i->bindParam($val, mb_convert_encoding($row[$v_arr[$key]], "UTF-8", "cp866"));
					 			}
								$command_i->execute();	//добавляем запись
							} 		// if $r['c']
			 			} 	//if ($_POST['import']['radio']=='update')

			 		}   /*  while($row = $dbf->readRec()) */
			 	}  /* if($dbf)*/

				//echo "</pre>";
				DTimer::log('импорт завершён');		// засекаем время выполнения

					// устанавливаем значение счётчика id для текущей таблицы
				preg_match('/(^vg.?_)(.*)/', $_POST['import']['tname'], $arr);
				$sql_seq = "SELECT setval('public.seq_id_".$arr[2]."', (select max(id) from ".$_POST['import']['tname'].")+1, true)";
				$connection->createCommand($sql_seq)->execute();

			 		// если все запросы выполнились без ошибок - подтверждаем транзакцию
			    $transaction->commit();
			//	$transaction->rollback();
			    echo '<b>Success!</b>';
			   // echo 'Отработало за '.sprintf('%0.5f',Yii::getLogger()->getExecutionTime()).' с.';
			    DTimer::show();
			}
			catch(Exception $e) // в случае возникновения ошибки при выполнении одного из запросов выбрасывается исключение
			{
			    $transaction->rollback();
			    echo 'error';
			    echo "<pre>";
					print_r($e);
				echo "</pre>";
			}


        }   /* if isset(post[])*/
    	}	/* 	if(Yii::app()->request->isAjaxRequest) { */
		$this->controller->render('import', array(

								));
	}
}