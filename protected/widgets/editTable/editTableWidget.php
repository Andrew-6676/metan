<?php
class editTableWidget extends CWidget
{
	public $data=null;
	public $model=null;
    public $columns=null;
    public $edit=null;
    public $faccess=null;
	public $cssFile=null;

    public function init()
    {
        	// этот метод будет вызван внутри CBaseController::beginWidget()
        // $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'delivery.css';
        $cssFile = Yii::app()->getBaseUrl().'/css/widgets/editTable/editTable.css';
        $jsFile  = Yii::app()->getBaseUrl().'/js/widgets/editTable/editTable.js';
        // $this->cssFile=Yii::app()->getAssetManager()->publish($file);
        $cs=Yii::app()->clientScript;
        $cs->registerCssFile($cssFile);
        $cs->registerScriptFile($jsFile);
        parent::init();
    }

    public function run()
    {

        // этот метод будет вызван внутри CBaseController::endWidget()
    	// Utils::print_r($this->edit);
     //    exit;
        // echo Yii::app()->request->baseUrl."<br>";
         // echo $this->controller->createAbsoluteUrl('/');;
        //echo Yii::app()->getBaseUrl(true);
         // echo $this->controller->createAbsoluteUrl('');;
        if (sizeof($this->model) == 0) {
            echo "Нет данных.";
        } else {
//CPagination
            echo '<button id="save_all">Сохранить все изменения</button>';
            echo '<button id="cancel_all">Отменить все изменения</button>';
            echo '<table class="editRest" tname='.$this->model[0]->tableName().'>';
                    // цикл по строкам данных
                foreach ($this->model as $row) {
                    // $row = $this->model[0];
                    echo '<tr id="r_'.$row->id.'">';
                        // цикл по колонкам
                        // формируем строку типа 'row->subtable[->subtable2....]->field', для колонок из связанных моделей
                    foreach ($this->columns as $col) {
                        if (is_array($col)) {   // если колонка задана массивом
                            $f = 'echo $row';
                            foreach ($col as $key => $ff) {
                                $f .= '->$col['.$key.']';
                            }
                            // echo "{$row->$col[0]->$col[1]}";
                            // if ($row->model()->tableSchema->getColumn($col)->dbType=='integer' || $row->model()->tableSchema->getColumn($col)->dbType == 'real') {
                                    echo '<td>';
                            // }
                            eval($f.';'); // вывод значения в ячейку таблицы
                        } else {
                            echo '<td class=';
                                //если число в поле - выравнивание по правому краю
                            if ($row->model()->tableSchema->getColumn($col)->dbType=='integer' || $row->model()->tableSchema->getColumn($col)->dbType == 'real') {
                                echo '"r" ';
                            } else {
                                echo '"l" ';
                            }
                                // разрешено ли редактирование
                            echo 'ro=';
                            if (array_search($col, $this->edit)!==false) {
                                echo '"false" ';
                            } else {
                                echo '"true" ';
                            }
                            echo 'val="'."{$row->$col}".'" fname="'.$col.'">';
                            echo "{$row->$col}"; // вывод значения в ячейку таблицы
                            // echo ' ('.$row->model()->tableSchema->getColumn($col)->dbType.')';
                        }
                        echo '</td>';
                    }
                    echo '<td class="buttons">';
                        echo '<button class="save_row" row_id="'.$row->id.'"></button>';
                        echo '<button class="cancel_row" row_id="'.$row->id.'"></button>';
                    echo '</td>';
                    echo '</tr>';
                }
            echo '</table>';
            echo '<input id="edit">';
        }
        parent::run();
    }
}
