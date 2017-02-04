<?php 
	include("header.php");
	include("sidebar.php");
	require_once("classes/Currency.php");
	$currency = Currency::getInstance();
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-usd fa-fw"></i> Currency </h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                <?php
					$all = $currency->getAllCurrency();
					if(sizeof($all) > 0){ ?>
					
                        <!-- /.panel-heading -->
                        <div class="panel-body col-lg-6">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Currency</th>
                                        <th>Name</th>
                                        <th>Exchange Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $i = 1;
										 foreach($all as $p){ ?>
										 <tr class="odd">
											<td><?php echo $p['code']?></td>
											<td><?php echo $p['name']?></td>
											<td>
											<span id="lib_<?php echo $p['code']?>"><?php echo $p['rate']?></span>
											<span style="float: right"><a class="edit_rate" href="#rate_<?php echo $p['code']?>"><i class="fa fa-edit fa-fw"></i> Edit rate</a></span>
											<div class="rate_edit" id="rate_<?php echo $p['code']?>" >
											<br />
												<input type="text" id="val_rate_<?php echo $p['code']?>" class="form-control" value="<?php echo $p['rate']?>" /> <button class="btn btn-primary confirm_edit_rate" id="<?php echo $p['code']?>">Confirm Edit</button>
											</div>
											</td>
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