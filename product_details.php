<?php 
	include("header.php");
	include("sidebar.php");
	require_once("classes/Product.php");
	$product = Product::getInstance();
	$pro = $product->getProductById($_GET['id']);

?>


        <div id="page-wrapper">
           
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-building-o fa-fw"></i> <?php echo strtoupper($pro['name_product']); ?></h1>
                </div>
			</div>
			
			<div class="row">
				<div class="text-right">
				<a href="#" class="btn btn-info"> Save </a>
				<a href="add-plan?product=<?php echo $pro['id_product'];?>" class="btn btn-primary"> Add plan </a>
				<a href="#" class="btn btn-default"> Cancel </a>
				</div>
				<form action="product_details_edit_process.php" method="POST">
				<fieldset>
					<legend>Detail Product</legend>
					<div class="col-lg-8">
               		<div class="col-lg-12">
               			<div class="col-lg-6">
                		<div class="form-group">
							<label >Product name</label>
							<input type="text" class="form-control" name="name_product" value="<?php echo $pro['name_product']?>" >
							<input type="hidden" name="id_product" value="<?php echo $pro['id_product'];?>" />
					  	</div>
						</div>
						<div class="col-lg-3">
						<div class="form-group">
								<label >Premium Currency</label>
								<select class="form-control" name="currency" >
									<option value="USD" <?php if($pro['currency'] == "USD"){echo "selected";}?>>USD</option>
									<option value="THB" <?php if($pro['currency'] == "THB"){echo "selected";}?>>THB</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
						<div class="form-group location" >
							<label >Available</label>
							<select class="form-control" name="available">
								<option value="ALL" <?php if($pro['available'] == "ALL"){echo "selected";}?>>All type</option>
								<option value="INDIV" <?php if($pro['available'] == "INDIV"){echo "selected";}?>>Individual only</option>
								<option value="FAMILY" <?php if($pro['available'] == "FAMILY"){echo "selected";}?>>Family only</option>
							</select>
					  </div>
						</div>
						<div class="col-lg-12">
						<div class="form-check">
						  <label >Country available for sale</label> : &nbsp;&nbsp;&nbsp;
							  <label class="form-check-label">
								<input class="form-check-input" name="country_available[]"  type="checkbox" value="KHM" <?php if($product->ifCountryAvailable($pro['id_product'],'KHM')){echo "checked";} ?> > Cambodia &nbsp;&nbsp;
							  </label>
							  
							  <label class="form-check-label">
								<input class="form-check-input" name="country_available[]"  type="checkbox" value="THA" <?php if($product->ifCountryAvailable($pro['id_product'],'THA')){echo "checked";} ?>> Thailand &nbsp;&nbsp;
							  </label>
							  
							  <label class="form-check-label">
								<input class="form-check-input" name="country_available[]"  type="checkbox" value="MMR" <?php if($product->ifCountryAvailable($pro['id_product'],'MMR')){echo "checked";} ?>> Myanmar &nbsp;&nbsp;
							  </label>
							  
							  <label class="form-check-label">
								<input class="form-check-input" name="country_available[]"  type="checkbox" value="LAO" <?php if($product->ifCountryAvailable($pro['id_product'],'LAO')){echo "checked";} ?>> Laos &nbsp;&nbsp;
							  </label>
							  
							  <label class="form-check-label">
								<input class="form-check-input" name="country_available[]"  type="checkbox" value="VET" <?php if($product->ifCountryAvailable($pro['id_product'],'VET')){echo "checked";} ?>> Vietnam &nbsp;&nbsp;
							  </label>
							  
						</div>
						</div>
						
						<div class="col-lg-12">
						 <div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="location" type="checkbox" value="1" name="local" <?php if($pro['local'] == 1){echo "checked";}?>>
							Local
						  </label>
						</div>
						<div class="form-group location" <?php if($pro['local'] != 1){echo 'style="display: none;"';} ?>>
							<label >Select location</label>
							<select class="form-control" name="location">
								<option value="ALL" <?php if($pro['location'] != ""){ if($pro['location'] == "ALL"){echo "selected";}} ?>>All Location</option>
								<option value="THA" <?php if($pro['location'] != ""){ if($pro['location'] == "THA"){echo "selected";}} ?>>Thailand</option>
								<option value="MMR" <?php if($pro['location'] != ""){ if($pro['location'] == "MMR"){echo "selected";}} ?>>Myanmar</option>
								<option value="LAO" <?php if($pro['location'] != ""){ if($pro['location'] == "LAO"){echo "selected";}} ?>>Laos</option>
								<option value="KHM" <?php if($pro['location'] != ""){ if($pro['location'] == "KHM"){echo "selected";}} ?>>Cambodia</option>
							</select>
					  	</div>
					  	
					  	<div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="discount" name="discount" type="checkbox" value="1" <?php if($pro['discount'] == 1){echo "checked";}?>>
							Discount option
						  </label>
						</div>
						
						<div class="col-lg-4 discount" <?php if($pro['discount'] != 1){echo 'style="display: none;"';} ?>>
					<div class="form-group ">
						<label >Discount percent</label>
						<input type="text" class="form-control" name="discount_percent" placeholder="%" value="<?php echo $pro['discount_percent'] ?>" >
					</div>
					</div>
					<div class="col-lg-5 discount" <?php if($pro['discount'] != 1){echo 'style="display: none;"';} ?>>
					<div class="form-group">
						<label >Minimun contract for discount</label>
						<input type="text" class="form-control" name="minimum_nb_contract" value="<?php echo $pro['minimum_nb_contract'] ?>" >
					</div>
					</div>
					
						</div>
					<div class="col-lg-12">
					<div class="form-check">
					  <label >Lifetime option</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="lifetime_lt"  type="checkbox" value="1" <?php if($pro['LT'] == 1){echo "checked";}?> > LT &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="lifetime_nlt" type="checkbox" value="1" <?php if($pro['NLT'] == 1){echo "checked";}?>> NLT
						  </label>
					</div>
					<div class="form-check">
					  <label >Area</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="area_z1"  type="checkbox" value="1" <?php if($pro['Z1'] == 1){echo "checked";}?> > Z1 &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="area_z2" type="checkbox" value="1" <?php if($pro['Z2'] == 1){echo "checked";}?>> Z2
						  </label>
					</div>
					<div class="form-check">
					  <label >Marine Activity</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="marine" type="radio" value="1" <?php if($pro['marine'] == 1){echo "checked";}?>> Yes &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="marine" type="radio" value="0" <?php if($pro['marine'] == 0){echo "checked";}?>> No
						  </label>
						</div>
					<div class="form-check">
					  <label >Type Calculation Age</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="type_age_cal"  type="radio" value="CY" <?php if($pro['type_age_caculaion'] == "CY"){echo "checked";}?>> Current Year (CY) &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="type_age_cal" type="radio" value="CA" <?php if($pro['type_age_caculaion'] == "CA"){echo "checked";}?>> Current Age (CA)
						  </label>
						</div>
						
						</div>
						
					</div>		
					</div>
					<div class="col-lg-12 text-right">
              		<br /><input type="submit" value=" Submit Edit " class="btn btn-warning" />
              	</div>
				</fieldset>
				
				</form>
				<?php 
					$level = $product->getLevelByProduct($_GET['id']);
					if(sizeof($level) > 0){
					//
				
					 ?>
						<div class="col-lg-12">
						<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                       <tr>
                                            <th class="text-center" width="1%">Age</th>
                                            <?php 
											foreach($level as $l){
												echo '<th class="text-center head-plan" width="8%">'.$l['name_plan'].'<br /> ( '.$l['name_level'].' , '.$l['zone'].' , '.$l['lifetime_option'].' )';
												if($l['deductible'] != 0){echo '<br /> Deductible : '.$l['deductible'];}
												echo '<br /> Gender : '.$l['sex'];
												echo '<br /><a href="edit-plan?id='.$l['id_level'].'"> View / Edit plan </a></th>';
											}
						
											?>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
										/*foreach($level as $l){
											if($l['children'] == 1){
												echo '<tr>';
												echo '<td class="text-center"><b>Children 1</b></td>';
												
												echo '</tr>';
											}
										}*/

										for($i=0;$i<=83;$i++){
											echo '<tr>';
											echo '<td class="text-center"><b>'.$i.'</b></td>';
											foreach($level as $l){
												
												$pre = $product->getPremiumByAgeLevel($i,$l['id_level']);
												if(sizeof($pre) > 0){
													foreach($pre as $p){
													echo '<td>'.number_format($p['price']).'</td>';
												}
												}else{
													echo '<td></td>';
												}
												
												
											}
											echo '</tr>';
										}
										
										
										?>
                                    </tbody>
                                </table>
                            </div>
					</div>
					<?php } ?>
				
				
				

			
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>