<?php include("header.php"); ?>
<?php include("sidebar.php"); 
	require_once("classes/Product.php");
	$product = Product::getInstance();
	$pro = $product->getProductById($_GET['product']);

?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-plus-square fa-fw"></i> New plan for <?php echo $pro['name_product']?></h1>
                </div>
                <form method="post" action="product_add_plan_process.php">
                <div class="col-lg-12">
                	<div class="col-lg-3">
                		<div class="form-group">
							<label >Original Plan Name</label>
							<input type="text" class="form-control" name="name_plan" >
							<input type="hidden" class="form-control" name="id_product" value="<?php echo $_GET['product'];?>" >
					  	</div>
					</div>
              		<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex">
								<option value="ALL">ALL</option>
								<option value="F">F</option>
								<option value="M">M</option>
							</select>
					  	</div>
					</div>
               		<div class="col-lg-2">
                		<div class="form-group">
							<label >Level</label>
							<select class="form-control" name="name_level">
								<option value="M1">M1</option>
								<option value="M2">M2</option>
								<option value="M3">M3</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Zone</label>
							<select class="form-control" name="zone">
								<option value="Z1">Normal</option>
								<option value="Z2">Extended area</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Lifetime option</label>
							<select class="form-control" name="lifetime_option">
								<option value="LT">LT</option>
								<option value="NLT">NLT</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Marine</label>
							<select class="form-control" name="marine">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-3">
                		<div class="form-group">
							<label >Deductible</label>
							<input type="text" class="form-control" name="deductible" >
							
					  	</div>
					</div>
					<div class="col-lg-3">
                		<div class="form-group">
							<label >Amount Garanty</label>
							<input type="text" class="form-control" name="garanty" >
							
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Assistance Individual</label>
							<input type="text" class="form-control" name="assis_indiv" >
							
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Assistance Family</label>
							<input type="text" class="form-control" name="assis_family" >
							
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >Adhesion Fee Cie</label>
							<input type="text" class="form-control" name="adh_fee" >
							
					  	</div>
					</div>
					<div class="col-lg-4">
                		<div class="form-group">
							<label >Assistance rapatriation details</label>
							<input type="text" class="form-control" name="room_rate" >
							
					  	</div>
					</div>
					
					<div class="col-lg-4">
                		<div class="form-group">
							<label >Standard private room per day</label>
							<input type="text" class="form-control" name="room_rate" >
							
					  	</div>
					</div>
					<div class="col-lg-4">
                		<div class="form-group">
							<label >Consultations maxiumum</label>
							<input type="text" class="form-control" name="room_rate" >
							
					  	</div>
					</div>
					<div class="col-lg-4">
                		<div class="form-group">
							<label >Public Liability/ Legal Assistance</label>
							<input type="text" class="form-control" name="room_rate" >
							
					  	</div>
					</div>
					<div class="col-lg-4">
                		<div class="form-group">
							<label >Cash, Bank transfer or Credit card</label>
							<input type="text" class="form-control" name="room_rate" >
							
					  	</div>
					</div>
					<div class="col-lg-12">
						<div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="children" type="checkbox" value="1" name="children" >
							Children option
						  </label>
						</div>
					</div>
					<div class="children" style="display: none;">
					<div class="col-lg-2">
                		<div class="form-group">
							<label >1 Children</label>
							<input type="text" class="form-control" name="1_children" >
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >2 Children</label>
							<input type="text" class="form-control" name="2_children">
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >3 Children</label>
							<input type="text" class="form-control" name="3_children">
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >4 Children</label>
							<input type="text" class="form-control" name="4_children">
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >5 Children</label>
							<input type="text" class="form-control" name="5_children">
					  	</div>
					</div>
					<div class="col-lg-2">
                		<div class="form-group">
							<label >6 Children</label>
							<input type="text" class="form-control" name="6_children">
					  	</div>
					</div>
					</div>
					<div class="col-lg-12">
						<div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="family_option" type="checkbox" value="1" name="family_option" >
							Family pack
						  </label>
						</div>
					</div>
					<br />
					<div class="family_option" style="display: none;">
						<div class="col-lg-2">
                		<div class="form-group">
							<label >Minimum contract for family pack</label>
							<input type="text" class="form-control" name="minimum_nb_family">
					  	</div>
					</div>
					<div>
						<div class="col-lg-2">
                		<div class="form-group">
							<label >Family pack price</label>
							<input type="text" class="form-control" name="family_price">
					  	</div>
					</div>
					</div>
					</div>
					<div class="col-lg-12"></div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Note (FR)</label>
							<textarea class="form-control" name="note_fr" rows="5"></textarea>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Note (EN)</label>
							<textarea class="form-control" name="note_en" rows="5"></textarea>
						</div>
					</div>
					<div class="col-lg-12"><hr /></div>

					<div class="col-lg-3">
						<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Age (Year old)</th>
                                            <th>Premium</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
										for($i=0;$i<=20;$i++){
											echo '<tr>
													<td class="text-center">'.$i.'</td>
													<td><input type="text" class="form-control" name="premium_'.$i.'" /></td>
												 </tr>';
										}
										?>
                                    </tbody>
                                </table>
                            </div>
					</div>
					
					<div class="col-lg-3">
						<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Age (Year old)</th>
                                            <th>Premium</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
										for($i=21;$i<=41;$i++){
											echo '<tr>
													<td class="text-center">'.$i.'</td>
													<td><input type="text" class="form-control" name="premium_'.$i.'" /></td>
												 </tr>';
										}
										?>
                                    </tbody>
                                </table>
                            </div>
					</div>
					<div class="col-lg-3">
						<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Age (Year old)</th>
                                            <th>Premium</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
										for($i=42;$i<=62;$i++){
											echo '<tr>
													<td class="text-center">'.$i.'</td>
													<td><input type="text" class="form-control" name="premium_'.$i.'" /></td>
												 </tr>';
										}
										?>
                                    </tbody>
                                </table>
                            </div>
					</div>
					<div class="col-lg-3">
						<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Age (Year old)</th>
                                            <th>Premium</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
										for($i=63;$i<=83;$i++){
											echo '<tr>
													<td class="text-center">'.$i.'</td>
													<td><input type="text" class="form-control" name="premium_'.$i.'" /></td>
												 </tr>';
										}
										?>
                                    </tbody>
                                </table>
                            </div>
					</div>

				<div class="col-lg-12">
              		<br /><input type="submit" value=" Submit " class="btn btn-primary" />
              	</div>
               </div>

                </form>
                
               
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>