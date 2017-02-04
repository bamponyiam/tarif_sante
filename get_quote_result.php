
<?php 
	include("header.php");
	include("sidebar.php");
	require_once("classes/Product.php");
	$product = Product::getInstance();
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-file-o fa-fw"></i> Quote result </h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                <?php
					
				$age_ca = 0;
				$age_cy = 0;

				if($_POST['type_con'] == "INDIV"){

					$a = explode("/",$_POST['dob_indiv']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($_POST['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					$all = $product->getAllProduct();
					if(sizeof($all) > 0){ ?>
					
					<div class="panel-body">
					<table width="100%" class="table table-bordered " id="dataTables-example">
						<thead>
							<tr style="background-color: #aaaaaa">
								<th width="8%">Level</th>
								<th>Product</th>
								<th>Plan</th>
								<th width="10%">Type Duration</th>
								<th width="7%">Zone</th>
								<th width="10%">Premium</th>
							</tr>
						</thead>
						<tbody>
					<?php
						foreach($all as $p){
							if($p['type_age_caculaion'] == "CY"){
								$product_available = $product->getProductDetailsByAgeByProductId($age_cy,$p['id_product']);
							}else{
								$product_available = $product->getProductDetailsByAgeByProductId($age_ca,$p['id_product']);
							}

							if(sizeof($product_available) > 0){ ?>
								<?php foreach($product_available as $av){ 
								//print_r($product_available);
								if($av['name_level'] == "M1"){ $color = "m1";}
								if($av['name_level'] == "M2"){ $color = "m2";}
								if($av['name_level'] == "M3"){ $color = "m3";}
								?>
								<tr class="<?php echo $color;?>">
									<?php 
										echo '<td >'.$av['name_level'].'</td>';
										echo '<td >'.$av['name_product'].'</td>';
										echo '<td >'.$av['name_plan'].'</td>';
										
										echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$av['zone'].'</td>';
										echo '<td class="text-right "><b>'.number_format($av['price']).' '.$av['currency'].'</b></td>';
									?>
								</tr>
								<?php }
							}

						}?>
								</tbody>
								</table>
								<!-- /.table-responsive -->
							</div>
					<?php }
				}		
				?>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>