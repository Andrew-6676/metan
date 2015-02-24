<?php
class InvoiceWidget extends CWidget
{
	public $data=null;
	public $mode=null;
	public $columns=null;
	public $cssFile=null;

    public function init()
    {
        	// этот метод будет вызван внутри CBaseController::beginWidget()
        // $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'delivery.css';
        $cssFile=Yii::app()->request->baseUrl.'/css/widgets/invoice/'.'doc.css';
        $jsFile=Yii::app()->request->baseUrl.'/js/widgets/invoice/'.'doc.js';
        // $this->cssFile=Yii::app()->getAssetManager()->publish($file);
        $cs=Yii::app()->clientScript;
        $cs->registerCssFile($cssFile);
        $cs->registerScriptFile($jsFile);
        parent::init();
    }

    public function run()
    {
        // этот метод будет вызван внутри CBaseController::endWidget()
        // print_r($this->data);
        // echo '<br>';
        //echo $this->items.'<br>';
        	// начало таблицы расхода
    	echo '<table id="table" class="parent">';
    	echo '<tr class="parent_header">';
    		echo '<th>№ документа</th>';
    		echo '<th>Дата</th>';
    		echo '<th>Потребитель</th>';
    		echo '<th>&nbsp</th>';
    	echo '</tr>';
    	$caption1 = Document::model()->attributeLabels();	// массив заголовков таблицы
    		// цикл по данным
    	foreach ($this->data as $doc) {
    		$d = explode('-', $doc->doc_date);
			$doc_date = date('d.m.Y', mktime(0,0,0,$d[1],$d[2],$d[0]));
    		$j = 0;
    			// родительская таблица (шапка документа 1)
    		echo '<tr class="parent_row" id="'.$doc->id.'"">';
    // 			echo '<td class="p_caption_'.$j.'">';
				// 	echo 'Документ №:';
				// 	//echo $caption1['doc_num'].':';
				// echo ' </td>';
    			echo '<td class="p_cell_'.$j++.'">';
					echo $doc->doc_num;
				echo ' </td>';
				// echo '<td class="p_caption_'.$j.'">';
				// 	echo 'Дата:';
				// echo ' </td>';
    			echo '<td class="p_cell_'.$j++.'">';
					echo $doc_date;
				echo ' </td>';
				echo '<td class="p_cell_'.$j++.'">';
					// echo '('.$doc->idOperation->name.')';
					echo '('.$doc->idContact->name.')';
				echo ' </td>';
				echo '<td class="p_cell_'.$j++.'">&nbsp</td>';

    		echo '</tr>';

    			// подчинённаятаблица
    		$c = 0;
    		$caption2 = Documentdata::model()->attributeLabels();
    			// строка .child_row содержит таблицу .child со строками документа
    		echo '<tr class="child_row hidden" id="ch_'.$doc->id.'"><td colspan="4"><table  class="child">';
    		echo '<thead>';
    			echo '<tr id="doc_hat_'.$doc->id.'" class="doc_hat">';
    				// шапка документа 2 (невидимая сразу, показывается по клику вместо первой)
    				echo '<td colspan="10">';
		    			echo '<span class="capt">Документ №:</span><span class="doc_num">'.$doc->doc_num.'</span>';
						echo '<br><span class="capt">Дата:</span><span class="doc_date">'.$doc_date.'</span>';
						echo '<br><span class="capt">Потребитель:</span><span  id_contact="'.$doc->id_contact.'">'.$doc->idContact->name.'</span>';
						//echo '<br><span>Приход от:</span>'.$doc->idContact->name;
						echo "<div class='buttons' doc_id='".$doc->id."'>
							<button class='write_off_button' title='Списать товары'></button>
                                                                                                <button class='print_doc_button' title='Напечатать счёт-фактуру'></button>
							<button class='edit_doc_button' title='Изменить документ'></button>
							<button class='del_doc_button' title='Удалить документ'></button>
							</div>";
	    			echo '</td>';
    			echo '</tr>';
    			// заголовки таблицы строк документа
    			echo '<tr class="child_caption">';
					echo '<th class="caption_'.$c++.'">';
						echo '№<br>п.п.';
					echo ' </th>';
					echo '<th class="caption_'.$c++.'">';
						echo 'Код';
					echo ' </th>';
					echo '<th class="caption_'.$c++.'">';
						echo 'Наименование товара';
					echo ' </th>';

					// echo '<th class="caption_'.$c++.'">';
					// 	echo 'Оптовая<br>цена';
					// echo ' </th>';
					// echo '<th class="caption_'.$c++.'">';
					// 	echo 'Наценка';
					// echo ' </th>';
					// echo '<th class="caption_'.$c++.'">';
					// 	echo 'НДС';
					// echo ' </th>';

					echo '<th class="caption_'.$c++.'">';
						echo 'Кол-во';
					echo ' </th>';

					echo '<th class="caption_'.$c++.'">';
						echo 'НДС';
					echo ' </th>';

					echo '<th class="caption_'.$c++.'">';
						echo 'Розничная<br>цена';
					echo ' </th>';

					// echo '<th class="caption_'.$c++.'">';
					// 	echo 'Сумма<br>опт';
					// echo ' </th>';

					echo '<th class="caption_'.$c++.'">';
						echo 'Сумма<br>розница';
					echo ' </th>';
				echo '</tr>';
			echo '</thead>';
			$i = 0;
				// цикл по строкам документа - вывод данных в таблицу
			foreach ($doc->documentdata as $dnotelist) {
				$c = 0;
				echo '<tr>';
					echo '<td class="cell_'.$c++.'">';
						echo ++$i;
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->idGoods->id;
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->idGoods->name;
					echo ' </td>';

					// echo '<td class="cell_'.$c++.'">';
					// 	echo number_format($dnotelist->cost,'0','.','`');
					// echo ' </td>';
					// echo '<td class="cell_'.$c++.'">';
					// 	echo $dnotelist->markup;
					// echo ' </td>';

					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->quantity;
					echo ' </td>';

					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->vat;
					echo ' </td>';

					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->price,'0','.','`');
					echo ' </td>';

					// echo '<td class="cell_'.$c++.'">';
					// 	echo number_format($dnotelist->quantity*$dnotelist->cost,'0','.','`');
					// echo ' </td>';

					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->quantity*$dnotelist->price,'0','.','`');
					echo ' </td>';
				echo '</tr>';
			}
    		echo "</table></td></tr>";
    	}
		echo '</table>';
// echo '<br>';
// echo '<br>';
// echo '<br>';
	//	print_r($this->data);

        parent::run();
    }
}
