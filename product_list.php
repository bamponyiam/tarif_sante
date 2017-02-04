<?php 
	include("header.php");
	include("sidebar.php");
	require_once("classes/Product.php");
	$product = Product::getInstance();
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-building-o fa-fw"></i> Products</h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                <?php
					$all = $product->getAllProduct();
					if(sizeof($all) > 0){ ?>
					
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Product name</th>
                                        <th width="10%">Currency</th>
                                        <th width="5%">LT</th>
                                        <th width="5%">NLT</th>
                                        <th width="10%">Marine Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $i = 1;
										 foreach($all as $p){ ?>
										 <tr class="odd">
											<td><a href="product-details?id=<?php echo $p['id_product'];?>"><?php echo $p['name_product']?></a></td>
											<td><?php echo $p['currency']?></td>
											<td><?php if($p['LT'] == 1){echo '<i class="fa fa-check green" aria-hidden="true"></i>';}else{ echo '<i class="fa fa-times red" aria-hidden="true"></i>';}?></td>
											<td><?php if($p['NLT'] == 1){echo '<i class="fa fa-check green" aria-hidden="true"></i>';}else{ echo '<i class="fa fa-times red" aria-hidden="true"></i>';}?></td>
											<td><?php if($p['marine'] == 1){echo '<i class="fa fa-check green" aria-hidden="true"></i>';}else{ echo '<i class="fa fa-times red" aria-hidden="true"></i>';}?></td>
										</tr>
											 
									<?php	$i++; }
									?>
                                    
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    

					</div>
						
				<?php } ?>
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>