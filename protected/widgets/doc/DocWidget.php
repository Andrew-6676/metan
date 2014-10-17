<?php
class DocWidget extends CWidget
{
	public $data=null;
	public $mode=null;
	public $columns=null;
	public $cssFile=null;

    public function init()
    {
        	// этот метод будет вызван внутри CBaseController::beginWidget()
        // $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'delivery.css';
        $cssFile=Yii::app()->request->baseUrl.'/css/widgets/doc/'.'doc.css';
        $jsFile=Yii::app()->request->baseUrl.'/js/widgets/doc/'.'doc.js';
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
    	echo '<table id="table" class="parent">';
		echo '<tr class="parent_header">';
    		echo '<th>№ ТТН</th>';
    		echo '<th>Дата</th>';
    		echo '<th>Поставщик</th>';
    		echo '<th>&nbsp</th>';
    	echo '</tr>';
    	$caption1 = Document::model()->attributeLabels();
    	foreach ($this->data as $doc) {
    		$d = explode('-', $doc->doc_date);
			$doc_date = date('d.m.Y', mktime(0,0,0,$d[1],$d[2],$d[0]));
    		$j = 0;
    			// родительская таблица
    		echo '<tr class="parent_row" id="'.$doc->id.'"">';
    // 			echo '<td class="p_caption_'.$j.'">';
				// 	echo 'ТТН №:';
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
				// echo '<td class="p_caption_'.$j.'">';
				// 	echo 'Приход от:';
				// echo ' </td>';
				echo '<td class="p_cell_'.$j++.'">';
					echo $doc->idContact->name;
				echo ' </td>';
				echo '<td class="p_cell_'.$j++.'">&nbsp</td>';
    		echo '</tr>';

    			// подчинённаятаблица

    		$c = 0;
    		$caption2 = Documentdata::model()->attributeLabels();

    		echo '<tr id="ch_'.$doc->id.'" class="child_row hidden">';
    		echo '<td colspan="4">';
    		echo '<table  class="child">';
    		  echo '<thead>';
    			echo '<tr id="doc_hat_'.$doc->id.'" class="doc_hat">';
    				echo '<td colspan="10">';
	    				echo '<span class="capt">ТТН №:</span><span class="doc_num">'.$doc->doc_num.'</span>';
						echo '<br><span class="capt">Дата:</span><span class="doc_date">'.$doc_date.'</span>';
						echo '<br><span class="capt">Приход от:</span>'.$doc->idContact->name;
						echo "<div class='buttons' doc_id='".$doc->id."'><button class='del_doc_button'></button>"./*<button class='edit_doc_button'>edit_doc</button>*/"</div>";
					echo '</td>';
    			echo '</tr>';
	    		echo '<tr>';
						echo '<th class="caption_'.$c++.'">';
							echo '№<br>п.п.';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Код';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Наименование товара';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Оптовая<br>цена';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Наценка';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'НДС';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Розничная<br>цена';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Кол-во';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Сумма<br>опт';
						echo ' </th>';
						echo '<th class="caption_'.$c++.'">';
							echo 'Сумма<br>розница';
						echo ' </th>';
					echo '</tr>';
				echo '</thead>';
			$i = 0;
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
					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->cost,'0','.','`');
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->markup;
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->vat;
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->price,'0','.','`');
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo $dnotelist->quantity;
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->quantity*$dnotelist->cost,'0','.','`');
					echo ' </td>';
					echo '<td class="cell_'.$c++.'">';
						echo number_format($dnotelist->quantity*$dnotelist->price,'0','.','`');
					echo ' </td>';
				echo '</tr>';
			}
    		echo "</table></td></tr>";
    	}
		echo '</table>';
echo '<br>';
echo '<br>';
echo '<br>';
	//	print_r($this->data);

        parent::run();
    }
}
