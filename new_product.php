<?php include("header.php"); ?>
<?php 
	include("sidebar.php"); 
	require_once("classes/Currency.php");
	$currency = Currency::getInstance();
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-plus-square fa-fw"></i> New Product</h1>
                </div>
                <form method="post" action="new_product_add_process.php">
                <div class="col-lg-6">
               		<div class="col-lg-12">
                		<div class="form-group">
							<label >Product name</label>
							<input type="text" class="form-control" name="name_product" >
					  	</div>
						 <div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="location" type="checkbox" name="local" value="1">
							Local
						  </label>
						</div>
						<div class="form-group location" style="display: none;">
							<label >Select location</label>
							<select class="form-control" name="location">
								<option value="ALL">All Location</option>
								<option value="THA">Thailand</option>
								<option value="MMR">Myanmar</option>
								<option value="LAO">Laos</option>
								<option value="KHM">Cambodia</option>
							</select>
					  	</div>
						<div class="form-check">
						  <label class="form-check-label">
							<input class="form-check-input" id="discount" name="discount" type="checkbox" value="1">
							Discount option
						  </label>
						</div>
					</div>

					<div class="col-lg-6 discount" style="display: none;">
					<div class="form-group ">
						<label >Discount percent</label>
						<input type="text" class="form-control" name="discount_percent" >
					</div>
					</div>
					<div class="col-lg-6 discount" style="display: none;">
					<div class="form-group">
						<label >Minimun contract for discount</label>
						<input type="text" class="form-control" name="minimum_nb_contract" >
					</div>
					</div>
			   
				   <div class="col-lg-3">
				   <br />
				   <?php
					  $c = $currency->getAllCurrency(); 
					?>
					<div class="form-group">
						<label >Premium Currency</label>
						<select class="form-control" name="currency" >
							<?php
								foreach($c as $v){
									echo '<option value="'.$v['code'].'">'.$v['code'].'</option>';
								}
							?>
						
						</select>
					</div>
					<div class="form-group location" >
							<label >Available</label>
							<select class="form-control" name="available">
								<option value="ALL">All type</option>
								<option value="INDIV">Individual only</option>
								<option value="FAMILY">Family only</option>
							</select>
					  </div>
				  </div>
				  <div class="col-lg-12"></div>
               		<div class="col-lg-6">
						
						<div class="form-check">
					  <label >Lifetime option</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="lifetime_lt"  type="checkbox" value="1" checked> LT &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="lifetime_nlt" type="checkbox" value="1"> NLT
						  </label>
						</div>
					</div>
				<div class="col-lg-12"></div>
               		<div class="col-lg-6">
						
						<div class="form-check">
					  <label >Area</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="area_z1"  type="checkbox" value="1" checked> Z1 &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="area_z2" type="checkbox" value="1"> Z2
						  </label>
						</div>
					</div>
				  <div class="col-lg-12"></div>
               		<div class="col-lg-6">
						
						<div class="form-check">
					  <label >Marine Activity</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="marine" type="radio" value="1"> Yes &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="marine" type="radio" value="0" checked> No
						  </label>
						</div>
					</div>
               
                <div class="col-lg-12"></div>
               		<div class="col-lg-12">
						
						<div class="form-check">
					  <label >Type Calculation Age</label> : &nbsp;&nbsp;&nbsp;
						  <label class="form-check-label">
							<input class="form-check-input" name="type_age_cal"  type="radio" value="CY"> Current Year (CY) &nbsp;&nbsp;
						  </label>
						  <label class="form-check-label">
							<input class="form-check-input" name="type_age_cal" type="radio" value="CA" checked> Current Age (CA)
						  </label>
						</div>
					</div>
				<div class="col-lg-12"> <br /> <input type="submit" value=" Submit " class="btn btn-primary" /></div>
               </div>

                </form>
                
               
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>