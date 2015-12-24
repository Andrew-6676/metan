<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 26.08.15
 * Time: 14:47
 */
?>
<?php
$this->addCSS('print/report.css');
$this->addCSS('print/cennik.css');

$rec_doc = $data['doc'];
$rec_doc_data = $data['details'];
// print_r($data);
?>

	<div class="rep_wrapper">
		<div class="page p">


				<?php

				$i = 0;
				foreach ($rec_doc_data as $row) {

					?>

					<div class="cennik ">
						<div class="mag">ПУ «Метан»<br></div>
						<div class="id_goods"><?php echo $row->idGoods->id; ?></div>
						<div class="ttn">
							ТТН № <?php echo $rec_doc->doc_num; ?> ОТ <?php echo Utils::format_date($rec_doc->doc_date); ?>г.
						</div>
						<?php
							$f=27;
							$sl = mb_strlen(trim($row->idGoods->name));

							if ($sl < 15) $f = 55;
							if ($sl >= 15 && $sl < 25) $f = 45;
							if ($sl >= 25 && $sl < 38) $f = 38;
							if ($sl >= 38 && $sl < 51) $f = 32;
						?>
						<div class="name f<?php echo $f; ?> "><?php echo trim($row->idGoods->name); ?></div>
						<div class="price">
							<?php echo number_format(($row->price),'0','.'," "); ?><span>РУБ</span>
						</div>
						<div class="producer">
							<?php
								if ($row->idGoods->producer) {
									echo "Производитель: ".$row->idGoods->producer;
								}
							?>
						</div>
					</div>


					<?php

					if (++$i==6) {
						echo '<div style="page-break-after: always;"></div>';
					}
				}
				?>





		</div>

	</div>




<?php



