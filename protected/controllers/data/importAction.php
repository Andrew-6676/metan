<?php

class importAction extends CAction   /*DataController*/
{
	//private function update_id(){

	//}
/*--------------------------------------------------------------------------------------------------*/
	private function fk_key($fk_str){
		// echo $fk_str.'<br>';
		$reg = '/\[(.+)\/(.+)\]-(.+)\[fk=(.*)\]\/(.*)$/';
		if (!preg_match($reg, $fk_str)) {
			echo 'Строка не соответствует шаблону: [DATA,ND]-vgm_deliverynote[fk=doc_date,doc_num]/id=id_dnote';
			return false;
		}

		preg_match_all($reg, $fk_str, $fk_arr);
		// echo '<br>FK = ';
		// print_r($fk_arr);

		// echo '<br><b>fk_src</b> = ';
		// print_r(explode(',',$fk_arr[1][0]));

		// echo '<br><b>fk_dst_table</b> = ';
		// print_r($fk_arr[2][0]);

		// echo '<br><b>fk_dst</b> = ';
		// print_r(explode(',',$fk_arr[3][0]));
		// echo '<hr>';

		// echo '</pre>';
		// [2][0] - родительская таблица
		//print_r(array($fk_arr[3][0], array_combine(explode(',',$fk_arr[1][0]), explode(',',$fk_arr[4][0])), explode('=',$fk_arr[5][0]), array_combine(explode(',',$fk_arr[1][0]),explode(',',$fk_arr[2][0]) )));
		//exit;
		//return array($fk_arr[2][0], array_combine(explode(',',$fk_arr[1][0]), explode(',',$fk_arr[3][0])), explode('=',$fk_arr[4][0]));
		return array($fk_arr[3][0], array_combine(explode(',',$fk_arr[1][0]), explode(',',$fk_arr[4][0])), explode('=',$fk_arr[5][0]), array_combine(explode(',',$fk_arr[1][0]),explode(',',$fk_arr[2][0]) ));
	}
/*--------------------------------------------------------------------------------------------------*/
	private function getFKvalue($fk_str, $data) {
			/*
				$fk_str - строка из vgm_table, содержащая описание внешнего клюа
				$data   - текущая строка из DBF
			*/

			// выбираем значение внешнего ключа из внешней таблицы
		$arr = $this->fk_key($fk_str);
		// print_r($arr);
		$where = '';
			// условие для запроса с параметрами
		foreach ($arr[1] as $fs => $fd) {
			$where .= ' and '.$fd.'=:'.$fs;
		}
		$sql = 'SELECT '.$arr[2][0].' FROM '.$arr[0].' WHERE 1=1 '.$where;
		$select = Yii::app()->db->createCommand($sql);
			// присвоение значений параметрам
		foreach ($arr[1] as $fs => $fd) {
			//echo ":$fs=".$this->check_type($data[$fs],$arr[3][$fs])."  ---  ";
			//print_r($arr[3][$fs]);
			$select->bindValue(':'.$fs, $this->check_type($data[$fs],$arr[3][$fs]));
		}
		$id = $select->queryScalar();
		//echo '<br><br>'.$sql.'<br>'.$id;
		//exit;
		return $id;
	}
/*--------------------------------------------------------------------------------------------------*/
	private function check_type($val, $type) {
		//берём значение и его тип, приводим к нужному виду и возвращаем
		switch ($type) {
			case '':
				return $val;
				break;

			case 'date':
				//return '[date]';
				//date = 20140324
				return "'".trim($val)."'";
				break;
			case 'num':
			case 'int':
				return intval($val);
				break;

			case 'char':
				if (trim($val)!='') {
					return "".trim($val)."";
					//return $val;
				} else
					return "";
				break;
			case 'val':
				return $val;
				break;
			default:
				return $val;
				break;
		}

		//return $val;
	}

/*--------------------------------------------------------------------------------------------------*/
   	public function run()
	{
			// проверяем текущего пользователя
		if (Yii::app()->user->isGuest) {
			echo 'авторизуйтесь!';
			exit;
		} elseif (Yii::app()->user->id<0) {
			echo 'Данная операция невозможна под админом!';
			exit;
		}

		echo 'Импорт новых товаров и накладных<br><br>';
		DTimer::log('перед началом импорта');	// засекаем время выполнения

		$connection = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try
		{
				// Получаем путь импорта для текущего магазина
			$sql = 'select import_dir from vgi_import i where id_store='.Yii::app()->session['id_store'];
			$path = $connection->createCommand($sql)->queryScalar();
			echo 'Путь:  /var/www/metan_0.1/public'.$path.'<br>';

			echo '<br>Импортируем следующее:<br>';
				// запрос для  получения списка ТАБЛИЦ для импорта
			$sql = 'SELECT t.id, name, table_src, table_dst, mode, enabled, fk, filter, sql
					FROM vgi_tables t
						inner join vgi_imptabl it on t.id=it.id_table
						inner join vgi_import i on i.id=it.id_import
					where id_store = '.Yii::app()->session['id_store'].
					'order by sort';

			$tables = $connection->createCommand($sql)->queryAll();	// выполняем запрос
			// echo "<pre>";
			// print_r($tables);
			// echo "</pre>";
				//цикл по импортируем ТАБЛИЦАМ для текущего магазина
			foreach ($tables as $table)
			{
				echo '<br><br><hr><hr><br>';
				echo $table['name'].': <b>'.$table['table_src'].' -> '.$table['table_dst'].'</b> --  ('.$table['mode'].') '.$table['enabled'].'<br>';

					// если иморт текущей таблицы выключен - пропускаем её
				if ($table['enabled']!=1) {
					echo '<i>continue</i>';
					continue;
				}

					// путь к импотируемому файлу (dbf)
				if (preg_match('/(\.\.\/)/', $table['table_src'])) {
						// если в имени таблицы точки и/или слеши - корректируем путь
					$dbf_path = '/var/www/metan_0.1/public/dbf/'.preg_replace('/(\.\.\/)/', '', $table['table_src']).'.dbf';
				} else {
						// если в имени таблицы нету точек и слешей
					$dbf_path = '/var/www/metan_0.1/public'.$path.$table['table_src'].'.dbf';
				}

					// открываем dbf
				$dbf = new dbf($dbf_path);
				if ($dbf) 	// если файл открылся нормально
				{
					// echo 'all#[DATA]=20140401,[ND]=195702';
					// echo '<pre>';
					// print_r($dbf->getRows('dist#[DATA]=20140401,[ND]=195702'));
					// echo '</pre>';
					// exit;
					echo '<br><br> Открыт DBF-файл: <b>'.$dbf_path.'</b><br>';
					echo 'mode: <b>'.$table['mode'].'</b><br>';
					echo 'reccount: <b>'.$dbf->count().'</b><br>';

						// выбираем поля для импорта из настроек для текущей таблицы ($table[])
					$sql = 'SELECT *
							FROM vgi_fields f
							where id_table = '.$table['id'].' and (type!='."'var' and type!='const' or key)";
					$fields = $connection->createCommand($sql)->queryAll();

					$fd = array();	// поля таблицы назначения
					$fs = array();	// поля таблицы источника
					$fk = array();	// ключевые поля (для поиска дубликатов)
					$ft = array();	// типы полей
					$fp = array();	// параметры запроса
					$fpk= array(); 	//
					$ftp= array();	// параметры запроса
					$fp_fs = array();
					$fp_ch = array();// параметры запроса на проверку повторяемости
					$str = '1=1';

						//цикл по ПОЛЯМ импортируемой таблицы - формируем массивы
					$p = 0;
					foreach ($fields as $valf)
					{
							//если тип поля=var, пропускаем это поле
						if ($valf['type']!='var')
						{
							$ft[$valf['field_dst']] = $valf['type'];	// типы полей
							$fd[] = $valf['field_dst'];	// заполняем массив полей dst
							$fs[] = $valf['field_src'];	// заполняем массив полей src
							$fp[$p] = $valf['field_src'].'_'.$p;	// массив имён парамеров запроса
							$ftp[$fp[$p]] = $valf['type'];
							$fp_fs[$valf['field_src'].'_'.$p] = $valf['field_src'];
							echo '&nbsp&nbsp&nbsp&nbsp&nbsp'.$valf['field_src'].' -> '.$valf['field_dst'].'  -----  '.$ft[$valf['field_dst']].' ('.$fp[$p].')<br>';
						}
							// ключевые поля (для определения повторных записей)
						if ($valf['key']) {
							if ($valf['type']!='var') {
								$fk[$valf['field_src'].'_'.$p]=$valf['field_dst'];	// массив вида ('ND'=>'doc_num')
									// строка условия для запроса
								$str .= ' and '.$valf['field_dst'].'=:'.$valf['field_src'].'_'.$p;
							} else {
								$str .= ' and '.$valf['field_dst'].'='.Yii::app()->session[$valf['field_src']];
							}
						}

						if ($valf['type']!='var' || $valf['key']) {
							$p++;
						}
					}
					//echo '<br>'.implode(', ',$f);
					//echo '<br>:'.implode(', :',$f).'<br>';

					//echo '<pre>';
							// если есть внешний ключ
			 			echo '<pre>';
			 			//echo '<hr>';
			 			if ($table['fk']!='<none>') {
			 				// подготовка запроса на выборку из основной БД, для проверки наличия повторной записи
							/*
								Если $table['fk']!='<none>', то к выборке для проверки нужно ещё добавить поля из FK_arr,
								но эти поля могут и не вставлятсья в целевую таблицу
			 				*/
			 				$FK_arr = $this->fk_key($table['fk']);
			 				//print_r($FK_arr);
							$str_join = '';
							$fkeys = '';
								// цикл по  FK_arr[1] - поля из родительской таблицы
							foreach ($FK_arr[1] as $fkd=>$fks) {
							 	$str .= ' and '.$fks.'=:'.$fkd; //.'_'.$p;
							 	//$ftp[$fkd.'_'.($p++)] =
							 	//$fpk[] = $fkd.'_'.($p);
							 	//$p++;
							}
								//
							$sql_check = 'SELECT count(*) '."\n".
										   'FROM '.$table['table_dst'].' c '."\n".
							 			   		'inner join '.$FK_arr[0].' p on p.'.$FK_arr[2][0].'=c.'.$FK_arr[2][1]."\n".
							 			   'WHERE '.$str;
								// формируем запрос на вставку записи в основную БД
							$sql_i = 'INSERT INTO '.$table['table_dst'].' ('.$FK_arr[2][1].', '.implode(', ',$fd).') values (:'.$FK_arr[2][1].', :'.implode(', :',$fp).')';
			 			} else {	// если таблица не дочерняя (нет FK)
			 					// подготовка запроса на выборку из основной БД, для проверки наличия повторной записи
							$sql_check = 'SELECT count(*) FROM '.$table['table_dst'].' WHERE '.$str;
								// формируем запрос на вставку записи в основную БД
							$sql_i = 'INSERT INTO '.$table['table_dst'].' ('.implode(', ',$fd).') values (:'.implode(', :',$fp).')';
							echo '<br>';

			 			}	// if fk=<none>

						// echo '<pre>';

			 			/*-------------------------------------*/
			 				// запрос на обновление полей типа id_owner, id_store...
			 				// надо обновить значения полей id_store, id_owner и т.д.
							// выбираем перечень полей из БД (у которых type 'var' или 'const')
			 			$sql = 'SELECT *
								FROM vgi_fields f
								where id_table = '.$table['id'].' and (type='."'var' or type='const')";
						$val_fields = $connection->createCommand($sql)->queryAll();
						$update_id = false;
						if ($val_fields) {
							//print_r($val_fields);
							$set = array();
							foreach ($val_fields as $vf) {
								if ($vf['type']=='var' ) {
									$set[] = $vf['field_dst'].'='.Yii::app()->session[$vf['field_src']];
								} else {
									$set[] = $vf['field_dst'].'='.$vf['field_src'];
								}
							}
				 			$sql_u = 'UPDATE '.$table['table_dst'].' SET '.implode(',',$set).' WHERE id=:id';
				 			$update_id = true;
				 			$command_u = $connection->createCommand($sql_u);	// запрос для обновления
				 			echo $sql_u;
							echo "<br>";
						}
						/*------------------------------------*/

						$command_ch = $connection->createCommand($sql_check);	// запрос на выборку
						$command_i  = $connection->createCommand($sql_i);		// запрос для вставки

						echo $sql_check;
						echo '<br>&nbsp&nbsp&nbsp&nbsp&nbsp';
						echo $sql_i;
						echo "<br>";

						// echo 'table=';
						// print_r($table);
						// echo 'FK_Arr=';
						// print_r($FK_arr);
						// echo 'ft=';
						// print_r($ft);
						// echo 'fs=';
						// print_r($fs);
						// echo 'fd=';
						// print_r($fd);
						// echo '</pre>';
						//exit;
						//continue;

					$i = 0;
					// зедсь можно применить фильтр из $table['filter'] и пропустить обработку строки из DBF
					if (trim($table['filter']) != '') {
						echo '<br><b>Filter=<i>'.$table['filter'].'</i></b><br>';
						$dbf->setFilter($table['filter']);
					}
						// цикл по записям импортируемой таблицы

			 		while($row = $dbf->readRec()) {
//					    if ($row['deleted']) {
////							echo 'deleted';
////						    continue;
//						}
					    //print_r($dbf->getFields());
//					    print_r($row);
//					    echo '<br>'.$i++.')';
					    // print_r($ft); echo '<br>';
			 				// проверяем повторяется ли запись
			 			/* выбрать из целевой таблицы записи, значения key_field_dst (может быть несколько)
			 			равны значениям полей key_field_dst текущей записи DBF	(kfd1=kfs1 and kfd2=kfs2 ....)*/

//						continue;

			 		 	echo '<br><b>select  --- </b>';
			 			// echo '$fk='; print_r($fk);
			 			// echo '$fd='; print_r($fd);
			 			// echo '$fs='; print_r($fs);
			 			// echo '$fp='; print_r($fp);
			 			// echo '$ft='; print_r($ft);
			 			// echo '$ftp='; print_r($ftp);
			 			// echo $fs[$fd[array_search('id', $fd)]];
			 			// echo $fs[array_search('id', $fd)].'-';
						// echo $ftp['KM_1'];
			 			//exit;
						foreach ($fk as $src => $dst)	// цикл по ключевым полям и присвоение параметрам значений (для проверки на повтор записи)
					  	{
					  	//	echo $src.'-'.$dst.' --- ';
					  		$data_f = $fs[array_search($dst, $fd)];
				  			echo ":$src = ".$this->check_type(mb_convert_encoding($row[$data_f],'UTF-8','cp866'),$ftp[$src]).";  --  ";
				 			$command_ch->bindValue($src, $this->check_type(mb_convert_encoding($row[$data_f], "UTF-8", "cp866"),$ftp[$src]));
					  	}
					  	//exit;
						  		// если таблица дочерняя, то присваиваем дополнительные параметры
					  	if ($table['fk']!='<none>') {
					  		// 	echo '<br>$FK_ARR_1='; print_r($FK_arr[1]);
					  		// 	echo '<br>$FK_ARR_3='; print_r($FK_arr[3]);
					  		//	echo '$fk='; print_r($fk);
					 		//	echo '$fd='; print_r($fd);
					 		//	echo '$fs='; print_r($fs);
					 		//	echo '$fp='; print_r($fp);
					 		//	echo '$ft='; print_r($ft);
					 		//	echo '$ftp='; print_r($ftp);
					  		//exit;
					 		$fi = 0;
						  	foreach ($FK_arr[1] as $src => $dst)	// цикл по полям, определяющим внешний ключ
						  	{
						  		//$param = $src.'_'.($p-count($FK_arr[1])+$fi++);
						  		echo '::'.$src.' = '.$this->check_type(mb_convert_encoding($row[$src],'UTF-8','cp866'),$FK_arr[3][$src]).";  --  ";
						 		$command_ch->bindValue($src, $this->check_type(mb_convert_encoding($row[$src], "UTF-8", "cp866"),$FK_arr[3][$src]));
						 		//$command_ch->bindParam($param, $this->check_type(mb_convert_encoding($row[$src], "UTF-8", 'cp866'),$FK_arr[3][$src]));
						 		//$command_ch->bindParam($src, $this->check_type($row[$src],$ft[$src]));
						  	}
						  	//exit;
					  	}		// end if ($table['fk']!='<none>')
						  	//exit;
						$c = $command_ch->queryScalar();
			 			//$c = -1;
			 			echo ' ---- (count='.$c.')';
			 			//continue;
						if ($c > 0) 	// если добавляемая запись уже есть в целевой таблице
						{
							echo ' --- Запись <b>'./*$this->check_type(mb_convert_encoding($row[$src], "UTF-8", "cp866"),$ft[$src])*/''.'</b> уже существует.';
						}
						else 	// если запись всталвять нужно
						{
				 				// присваиваем параметры
							 //  echo '<br>$fp='; print_r($fp);
							 // // echo '<br>$fs='; print_r($fs);
							 //  echo '<br>$ft='; print_r($ft);
							 //  echo '<br>$ftp='; print_r($ftp);
							 //  echo '<br>$fd='; print_r($fd);
							 //  echo '<br>$fp_fs='; print_r($fp_fs);
							 // echo '<br>$row='; print_r($row);

							echo "<br> <b>insert  --#- </b> ";
							foreach ($fp as $key => $val)	// цикл по параметрам - присвоение параметрам запроса значений
						  	{
						  		//echo "$key - $val<br>";
						  		//echo $ftp[$val].'--';
						  		echo "$val-(".$ftp[$val].")= ".$this->check_type(mb_convert_encoding($row[$fp_fs[$val]], "UTF-8", "cp866"),$ftp[$val]).";   ";
						 		$command_i->bindValue($val, $this->check_type(mb_convert_encoding($row[$fp_fs[$val]], "UTF-8", "cp866"),$ftp[$val]));
						  	}
						 		// exit;
						  	//continue;
						  		// если таблица дочерняя - присваиваем значение внешнего ключа
						  	if ($table['fk']!='<none>') {
						  		// print_r($table);
						  		$id = $this->getFKvalue($table['fk'],$row);
						  		$command_i->bindParam(':'.$FK_arr[2][1],$id);
						  		echo '::'.$FK_arr[2][1].'='.$id;
						  	}
						  	//echo '<br>';
						  	// exit;
						  	try {
						  		// echo '################1';
						  		// print_r($command_i->text);
								$command_i->execute();	// добавляем запись
								// echo '################2';
								if ($update_id) {
									// присвоить значение параметру id
									$sql = "SELECT currval('seq_id_".preg_replace('/vgm_/', '', $table['table_dst'])."')";
									$id = $connection->createCommand($sql)->queryScalar();
									// echo '<br>---->'.$id.'<-----<br>';
									$command_u->bindParam('id',$id);
									$command_u->execute();	// обновляем запись
								}
						  	} catch(Exception $e) {
						  		echo ' ---<br>Ошибка импорта строки';
						  		echo "<br>###############################################################<br>";
						  		print_r($e->errorInfo);
						  		echo "###############################################################<br>";
						  		//echo ' --- Ошибка импорта строки<br>';
						  		//continue;
						  	}
						}	//if ($c > 0)  // конец вставка записи

			 		}	// цикл по записям DBF  while($row = $dbf->readRec())


				} 	// if ($dbf)
				else 	// если импортируемый файл отсутствует
				{
					echo 'Проверте наличие импортируемого файла и права на него';
				}	// if ($dbf)

					// выполнить запрос для всей таблицы, если есть в настройках
				if (trim($table['sql'])!='') {
					echo '<br>	after-INSERT: <b><i>'.$table['sql'].'</i></b><br>';
					$connection->createCommand($table['sql'])->execute();
				}

				DTimer::log($table['name']);
			}	//цикл по импортируем таблицам  foreach ($tables as $val)

			//$command->execute();

			$transaction->commit();
			DTimer::log('импорт завершён');		// засекаем время выполнения
				// перенаправить в случае удачного импорта
		}
		catch(Exception $e) // в случае возникновения ошибки при выполнении одного из запросов выбрасывается исключение
		{
			$transaction->rollback();
			echo 'error';
			echo "<pre>";
			echo "<br>###############################################################<br>";
			print_r($e->errorInfo);
			//print_r($e->errorInfo);
			echo "###############################################################<br>";
			echo "</pre>";
		}

		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<hr>";
		DTimer::show();
		//$this->controller->render('index');
	}
}