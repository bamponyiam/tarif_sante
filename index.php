<?php

include("header.php"); 
include("sidebar.php");
require_once("classes/Currency.php");
$currency = Currency::getInstance();
require_once("classes/Location.php");
$location = Location::getInstance();
require_once("classes/Country.php");
$country = Country::getInstance();
$all_c = $country->getAllCountry();
require_once("classes/Product.php");
$product = Product::getInstance();

$data = array();

?>

<?php
if(isset($_POST["type_con"])){?>
  
   <script>$('html, body').animate({scrollTop: $("#dataTables-example_wrapper").offset().top}, 2000);</script>
    
<?php } ?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-file-o fa-fw"></i> New Quote </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
               <form method="post" action="" id="search-form">
                <div class="col-lg-12">
                		<div class="form-group">
							<label> Level : </label>
							<label class="checkbox-inline">
								<input type="checkbox" name="level_M1" <?php if(isset($_POST['level_M1'])){echo "checked"; $data['M1'] = 1;}else{$data['M1'] = 0;}?> value="1"> M1
							</label>
							<label class="checkbox-inline">
								<input type="checkbox" name="level_M2" <?php if(isset($_POST['level_M2'])){echo "checked"; $data['M2'] = 1;}else{$data['M2'] = 0;}?> value="1"> M2
							</label>
							<label class="checkbox-inline">
								<input type="checkbox" name="level_M3" <?php if(isset($_POST['level_M3'])){echo "checked"; $data['M3'] = 1;}else{$data['M3'] = 0;}?> value="1"> M3
							</label>
						</div>
				</div>
          		<div class="col-lg-2">
                		<div class="form-group">
							<label >Year effective</label>
							<input type="text" class="form-control" name="year_effective" value="<?php if(isset($_POST['year_effective'])){echo $_POST['year_effective'];$data['year_effective'] = $_POST['year_effective'];}else{echo date('Y');}?>"/>
					  	</div>
					</div>
           		<div class="col-lg-2">
					<?php
					  $c = $currency->getAllCurrency(); 
					?>
					<div class="form-group">
						<label >Currency</label>
						<select class="form-control" name="currency" >
							<?php
								foreach($c as $v){
									if(isset($_POST['currency'])){
										if($_POST['currency'] == $v['code']){
											echo '<option value="'.$v['code'].'" selected>'.$v['code'].'</option>';
										}else{
											echo '<option value="'.$v['code'].'">'.$v['code'].'</option>';	
										}
										$data['currency'] = $_POST['currency'];
									}else{
										if($u['office'] == 'THA'){
											if($v['code'] == "THB"){
												echo '<option value="'.$v['code'].'" selected>'.$v['code'].'</option>';
											}else{
												echo '<option value="'.$v['code'].'">'.$v['code'].'</option>';
											}
										}else{
											if($v['code'] == "USD"){
												echo '<option value="'.$v['code'].'" selected>'.$v['code'].'</option>';
											}else{
												echo '<option value="'.$v['code'].'">'.$v['code'].'</option>';
											}
										}
									}	
								}
							?>
						
						</select>
					</div>
				</div>
           		<div class="col-lg-3">
					<div class="form-group">
						<label >Location</label>
						<select class="form-control" name="location">
						
						<?php
							$loc = $location->getAllLocation();
							foreach($loc as $locat){
								if(isset($_POST[location])){
									if($_POST['location'] == $locat['id_location']){
										echo '<option value="'.$locat['id_location'].'" selected>'.$locat['name_location'].'</option>';
									}else{
										echo '<option value="'.$locat['id_location'].'">'.$locat['name_location'].'</option>';
									}
									$data['location'] = $_POST['location'];
								}else{
									if($u['office'] == $locat['id_location']){
										echo '<option value="'.$locat['id_location'].'" selected>'.$locat['name_location'].'</option>';
									}else{
										echo '<option value="'.$locat['id_location'].'">'.$locat['name_location'].'</option>';
									}
								}
								
							}
						?>
						</select>
					</div>
				</div>
         		
          		<div class="col-lg-4">
           		<div class="form-group">
					<label></label>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="local" value="1" <?php if(isset($_POST['local'])){echo "checked";$data['local'] = 1;}else{$data['local'] = 0;}?>>Local national</b>
						</label> &nbsp;&nbsp;&nbsp;
						<label>
							<input type="checkbox" name="lifetime" value="LT" <?php if(isset($_POST['lifetime'])){echo "checked";$data['lifetime'] = 1;}else{$data['lifetime'] = 0;}?>><b>Lifetime</b>
						</label>&nbsp;&nbsp;&nbsp;
						<label>
							<input type="checkbox" name="extended_area" value="Z2" <?php if(isset($_POST['extended_area'])){echo "checked";$data['extended_area'] = 1;}else{$data['extended_area'] = 0;}?>><b>Extended Area</b>
						</label>
					</div>
				</div>
           		</div>
           		<div class="col-lg-12">
                		<div class="form-group">
							<label> Type of contract : </label>
							<label class="checkbox-inline">
								<input type="radio" class="type_con" name="type_con" value="INDIV" <?php if(isset($_POST['type_con'])){if($_POST['type_con'] == "INDIV"){ echo "checked";}}else{echo "checked";} ?>> Individual
							</label>
							<label class="checkbox-inline">
								<input type="radio" class="type_con" name="type_con" value="FAMILY" <?php if(isset($_POST['type_con'])){if($_POST['type_con'] == "FAMILY"){ echo "checked";}} ?>> Family
							</label>
						</div>
				</div>

				<fieldset class="individual" <?php if(isset($_POST['type_con'])){ if($_POST['type_con'] != "INDIV"){echo 'style="display:none;"';}} ?>>
           			<legend> <i class="fa fa-user" aria-hidden="true"></i> Individual </legend>
           			<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_indiv">
								<option value="NONE" <?php if(isset($_POST['sex_indiv'])){if($_POST['sex_indiv'] == "NONE"){echo "selected";$data['sex'] = "NONE";}} ?>>NONE</option>
								<option value="F" <?php if(isset($_POST['sex_indiv'])){if($_POST['sex_indiv'] == "F"){echo "selected";$data['sex'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_indiv'])){if($_POST['sex_indiv'] == "M"){echo "selected";$data['sex'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_indiv" name="dob_indiv" <?php if(isset($_POST['dob_indiv'])){ echo 'value="'.$_POST['dob_indiv'].'"';} ?> />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
         			
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_indiv" name="age_indiv" 
							<?php 
								if(isset($_POST['age_indiv'])){
									if($_POST['age_indiv'] != ""){
										if(isset($_POST['dob_indiv'])){
											if($_POST['dob_indiv'] != ""){
												$a = explode("/",$_POST['dob_indiv']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_indiv'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_indiv'])){
											if($_POST['dob_indiv'] != ""){
												$a = explode("/",$_POST['dob_indiv']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_indiv" <?php if(isset($_POST['firstname_indiv'])){ echo 'value="'.$_POST['firstname_indiv'].'"';} ?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_indiv" <?php if(isset($_POST['lastname_indiv'])){ echo 'value="'.$_POST['lastname_indiv'].'"';} ?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_indiv">
							<option value="NONE">NONE</option>
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_indiv'])){
										if($_POST['nationality_indiv'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>
						</div>
					</div>
       				
      			<div class="col-lg-2">
          			<div class="form-group">
					<label></label>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="marine_indiv" value="1" <?php if(isset($_POST['marine_indiv'])){echo "checked";$data['marine'] = 1;}else{$data['marine'] = 0;}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
	
          		<div class="col-lg-12"></div>
				<div class="col-lg-4">
					<div class="form-group">
						<label >Company name (optional)</label>
						<input type="text" class="form-control" name="company_indiv" <?php if(isset($_POST['company_indiv'])){ echo 'value="'.$_POST['company_indiv'].'"';} ?> />
					</div>
					<div class="form-group">
						<label >Email (optional)</label>
						<input type="text" class="form-control" name="email_indiv" <?php if(isset($_POST['email_indiv'])){ echo 'value="'.$_POST['email_indiv'].'"';} ?> />
					</div>
				</div>
         		<div class="col-lg-4">
					<div class="form-group">
						<label >Address (optional)</label>
						<textarea class="form-control" rows="5" name="address_indiv"><?php if(isset($_POST['address_indiv'])){ echo $_POST['address_indiv'];} ?></textarea>
					</div>
				</div>
         		<div class="col-lg-2">
					<div class="form-group">
						<label >Phone number (optional)</label>
						<input type="text" class="form-control" name="phone_indiv" <?php if(isset($_POST['phone_indiv'])){ echo 'value="'.$_POST['phone_indiv'].'"';} ?> />
					</div>
					
				</div>
       		<div class="col-lg-2">
        		<div class="form-group">
						<label >Country Of Residence (optional)</label>
						<input type="text" class="form-control" name="country_indiv" <?php if(isset($_POST['country_indiv'])){ echo 'value="'.$_POST['country_indiv'].'"';} ?> />
					</div>
				</div>
         		<div class="col-lg-4">
						<div class="form-group">
							<label >Profession (optional)</label>
							<input type="text" class="form-control" name="profession_indiv" <?php if(isset($_POST['profession_indiv'])){ echo 'value="'.$_POST['profession_indiv'].'"';} ?> />
						</div>
					</div>
          		
           		</fieldset>
           		<fieldset class="family" <?php if(isset($_POST['type_con'])){ if($_POST['type_con'] != "FAMILY"){echo 'style="display:none;"';}}else{echo 'style="display:none;"';} ?>>
           			<legend> <i class="fa fa-home" aria-hidden="true"></i> Family </legend>
           		
           			<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_1st_family">
								<option value="F" <?php if(isset($_POST['sex_1st_family'])){if($_POST['sex_1st_family'] == "F"){echo "selected";$data['sex_1st_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_1st_family'])){if($_POST['sex_1st_family'] == "M"){echo "selected";$data['sex_1st_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_1st_family" name="dob_1st_family" value="<?php if(isset($_POST['dob_1st_family'])){echo $_POST['dob_1st_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_1st_family" name="age_1st_family" 
							<?php 
								if(isset($_POST['age_1st_family'])){
									if($_POST['age_1st_family'] != ""){
										if(isset($_POST['dob_1st_family'])){
											if($_POST['dob_1st_family'] != ""){
												$a = explode("/",$_POST['dob_1st_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_1st_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_1st_family'])){
											if($_POST['dob_1st_family'] != ""){
												$a = explode("/",$_POST['dob_1st_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_1st_family" value="<?php if(isset($_POST['firstname_1st_family'])){echo $_POST['firstname_1st_family'];}?>"/>
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_1st_family" value="<?php if(isset($_POST['lastname_1st_family'])){echo $_POST['lastname_1st_family'];}?>"/>
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_1st_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_1st_family'])){
										if($_POST['nationality_1st_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>

						</div>
					</div>
         			<div class="col-lg-2">
          			<div class="form-group">
					<label></label>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="marine_1st_family" value="1" <?php if(isset($_POST['marine_1st_family'])){echo "checked";$data['marine_1st_family'] = 1;}else{$data['marine_1st_family'] = 0;}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
          		<div class="col-lg-12"></div>
          		<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_2nd_family">
								<option value="F" <?php if(isset($_POST['sex_2nd_family'])){if($_POST['sex_2nd_family'] == "F"){echo "selected";$data['sex_2nd_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_2nd_family'])){if($_POST['sex_2nd_family'] == "M"){echo "selected";$data['sex_2nd_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_2nd_family" name="dob_2nd_family" value="<?php if(isset($_POST['dob_2nd_family'])){echo $_POST['dob_2nd_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_2nd_family" name="age_2nd_family" 
							<?php 
								if(isset($_POST['age_2nd_family'])){
									if($_POST['age_2nd_family'] != ""){
										if(isset($_POST['dob_2nd_family'])){
											if($_POST['dob_2nd_family'] != ""){
												$a = explode("/",$_POST['dob_2nd_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_2nd_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_2nd_family'])){
											if($_POST['dob_2nd_family'] != ""){
												$a = explode("/",$_POST['dob_2nd_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_2nd_family" value="<?php if(isset($_POST['firstname_2nd_family'])){echo $_POST['firstname_2nd_family'];}?>"/>
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_2nd_family" value="<?php if(isset($_POST['lastname_2nd_family'])){echo $_POST['lastname_2nd_family'];}?>"/>
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_2nd_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_2nd_family'])){
										if($_POST['nationality_2nd_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>

						</div>
					</div>
         			<div class="col-lg-2">
          			<div class="form-group">
					<label></label>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="marine_2nd_family" value="1" <?php if(isset($_POST['marine_2nd_family'])){echo "checked";$data['marine_2nd_family'] = 1;}else{$data['marine_2nd_family'] = 0;}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
					<div class="col-lg-12"></div>
          		<fieldset>
          			<legend> <i class="fa fa-users" aria-hidden="true"></i> Children </legend>
          			<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_1_child_family" >
								<option value="F" <?php if(isset($_POST['sex_1_child_family'])){if($_POST['sex_1_child_family'] == "F"){echo "selected";$data['sex_1_child_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_1_child_family'])){if($_POST['sex_1_child_family'] == "M"){echo "selected";$data['sex_1_child_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_1_child_family" name="dob_1_child_family" value="<?php if(isset($_POST['dob_1_child_family'])){echo $_POST['dob_1_child_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_1_child_family" name="age_1_child_family" 
							<?php 
								if(isset($_POST['age_1_child_family'])){
									if($_POST['age_1_child_family'] != ""){
										if(isset($_POST['dob_1_child_family'])){
											if($_POST['dob_1_child_family'] != ""){
												$a = explode("/",$_POST['dob_1_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_1_child_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_1_child_family'])){
											if($_POST['dob_1_child_family'] != ""){
												$a = explode("/",$_POST['dob_1_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_1_child_family" value="<?php if(isset($_POST['firstname_1_child_family'])){echo $_POST['firstname_1_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_1_child_family" value="<?php if(isset($_POST['lastname_1_child_family'])){echo $_POST['lastname_1_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_1_child_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_1_child_family'])){
										if($_POST['nationality_1_child_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>
						</div>
					</div>
         			<div class="col-lg-12"></div>
         			<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_2_child_family" >
								<option value="F" <?php if(isset($_POST['sex_2_child_family'])){if($_POST['sex_2_child_family'] == "F"){echo "selected";$data['sex_2_child_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_2_child_family'])){if($_POST['sex_2_child_family'] == "M"){echo "selected";$data['sex_2_child_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_2_child_family" name="dob_2_child_family" value="<?php if(isset($_POST['dob_2_child_family'])){echo $_POST['dob_2_child_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_2_child_family" name="age_2_child_family" 
							<?php 
								if(isset($_POST['age_2_child_family'])){
									if($_POST['age_2_child_family'] != ""){
										if(isset($_POST['dob_2_child_family'])){
											if($_POST['dob_2_child_family'] != ""){
												$a = explode("/",$_POST['dob_2_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_2_child_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_2_child_family'])){
											if($_POST['dob_2_child_family'] != ""){
												$a = explode("/",$_POST['dob_2_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_2_child_family" value="<?php if(isset($_POST['firstname_2_child_family'])){echo $_POST['firstname_2_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_2_child_family" value="<?php if(isset($_POST['lastname_2_child_family'])){echo $_POST['lastname_2_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_2_child_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_2_child_family'])){
										if($_POST['nationality_2_child_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>
						</div>
					</div>
         		<div class="col-lg-12"></div>
         		<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_3_child_family" >
								<option value="F" <?php if(isset($_POST['sex_3_child_family'])){if($_POST['sex_3_child_family'] == "F"){echo "selected";$data['sex_3_child_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_3_child_family'])){if($_POST['sex_3_child_family'] == "M"){echo "selected";$data['sex_3_child_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_3_child_family" name="dob_3_child_family" value="<?php if(isset($_POST['dob_3_child_family'])){echo $_POST['dob_3_child_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_3_child_family" name="age_3_child_family" 
							<?php 
								if(isset($_POST['age_3_child_family'])){
									if($_POST['age_3_child_family'] != ""){
										if(isset($_POST['dob_3_child_family'])){
											if($_POST['dob_3_child_family'] != ""){
												$a = explode("/",$_POST['dob_3_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_3_child_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_3_child_family'])){
											if($_POST['dob_3_child_family'] != ""){
												$a = explode("/",$_POST['dob_3_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_3_child_family" value="<?php if(isset($_POST['firstname_3_child_family'])){echo $_POST['firstname_3_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_3_child_family" value="<?php if(isset($_POST['lastname_3_child_family'])){echo $_POST['lastname_3_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_3_child_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_3_child_family'])){
										if($_POST['nationality_3_child_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>
						</div>
					</div>
         		<div class="col-lg-12"></div>
         		<div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_4_child_family" >
								<option value="F" <?php if(isset($_POST['sex_4_child_family'])){if($_POST['sex_4_child_family'] == "F"){echo "selected";$data['sex_4_child_family'] = "F";}} ?>>F</option>
								<option value="M" <?php if(isset($_POST['sex_4_child_family'])){if($_POST['sex_4_child_family'] == "M"){echo "selected";$data['sex_4_child_family'] = "M";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control datetimepicker1" id="dob_4_child_family" name="dob_4_child_family" value="<?php if(isset($_POST['dob_4_child_family'])){echo $_POST['dob_4_child_family'];}?>"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" id="age_4_child_family" name="age_4_child_family" 
							<?php 
								if(isset($_POST['age_4_child_family'])){
									if($_POST['age_4_child_family'] != ""){
										if(isset($_POST['dob_4_child_family'])){
											if($_POST['dob_4_child_family'] != ""){
												$a = explode("/",$_POST['dob_4_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}else{
											echo 'value="'.$_POST['age_4_child_family'].'"';
										}
										}
										
									}else{
										if(isset($_POST['dob_4_child_family'])){
											if($_POST['dob_4_child_family'] != ""){
												$a = explode("/",$_POST['dob_4_child_family']);
												$dob= $a[2].'-'.$a[1].'-'.$a[0];
												$from = new DateTime($dob);
												$to   = new DateTime('today');
												$age_ca = $from->diff($to)->y;
												echo 'value="'.$age_ca.'"';
											}
										}
									}
								}   
							?> />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_4_child_family" value="<?php if(isset($_POST['firstname_4_child_family'])){echo $_POST['firstname_4_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_4_child_family" value="<?php if(isset($_POST['lastname_4_child_family'])){echo $_POST['lastname_4_child_family'];}?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_4_child_family">
								<?php 
								foreach($all_c as $c){
									if(isset($_POST['nationality_4_child_family'])){
										if($_POST['nationality_4_child_family'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}else{
										echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
									}
									
								}
								?>
							</select>
						</div>
					</div>
          		</fieldset>
          		<div class="col-lg-12"></div>
				<div class="col-lg-4">
					<div class="form-group">
						<label >Company name (optional)</label>
						<input type="text" class="form-control" name="company_family" <?php if(isset($_POST['company_family'])){ echo 'value="'.$_POST['company_family'].'"';} ?> />
					</div>
					<div class="form-group">
						<label >Email (optional)</label>
						<input type="text" class="form-control" name="email_family" <?php if(isset($_POST['email_family'])){ echo 'value="'.$_POST['email_family'].'"';} ?>/>
					</div>
				</div>
         		<div class="col-lg-4">
					<div class="form-group">
						<label >Address (optional)</label>
						<textarea class="form-control" rows="5" name="address_family"><?php if(isset($_POST['address_family'])){ echo $_POST['address_family'];} ?></textarea>
					</div>
				</div>
         		<div class="col-lg-2">
					<div class="form-group">
						<label >Phone number (optional)</label>
						<input type="text" class="form-control" name="phone_family" <?php if(isset($_POST['phone_family'])){ echo 'value="'.$_POST['phone_family'].'"';} ?>/>
					</div>
				</div>
        		<div class="col-lg-2">
         		<div class="form-group">
						<label >Country Of Residence (optional)</label>
						<input type="text" class="form-control" name="country_family" <?php if(isset($_POST['country_family'])){ echo 'value="'.$_POST['country_family'].'"';} ?>/>
					</div>
					</div>
          		<div class="col-lg-4">
						<div class="form-group">
							<label >Profession (optional)</label>
							<input type="text" class="form-control" name="profession_family" <?php if(isset($_POST['profession_family'])){ echo 'value="'.$_POST['profession_family'].'"';} ?> />
						</div>
					</div>
           		</fieldset>
				
				<div class="col-lg-12 text-center">
					<br />

					<button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-file-o fa-fw"></i> Find Quote </button>
					<button type="reset" class="btn btn-default btn-lg"><i class="fa fa-magic" aria-hidden="true"></i> Reset </button>
					<br />
				</div>
           </form>
           
           <?php
				if(isset($_POST['type_con'])){
					if($_POST['type_con'] == "INDIV"){
						
						if($_POST['dob_indiv'] != ""){
							$a = explode("/",$_POST['dob_indiv']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca = $from->diff($to)->y;
						}else{
							if($_POST['age_indiv'] != ""){
								$age_cy = $_POST['age_indiv'];
								$age_ca = $_POST['age_indiv'];
							}
						}
						
						$all = $product->getAllProduct();
						
						
						
						if(sizeof($all) > 0){
							echo '<div class="panel-body">
								<form method="POST" action="save_quote_indiv.php" id="quote_indiv">
								
									<input type="hidden" name="sex_indiv" value="'.$_POST['sex_indiv'].'" />
									<input type="hidden" name="dob_indiv" value="'.$_POST['dob_indiv'].'" />
									<input type="hidden" name="age_indiv" value="'.$_POST['age_indiv'].'" />
									<input type="hidden" name="firstname_indiv" value="'.$_POST['firstname_indiv'].'" />
									<input type="hidden" name="lastname_indiv" value="'.$_POST['lastname_indiv'].'" />
									<input type="hidden" name="nationality_indiv" value="'.$_POST['nationality_indiv'].'" />';
							
									if(!isset($_POST['marine_indiv'])){
										echo '<input type="hidden" name="marine_indiv" value="0" />';
									}else{
										echo '<input type="hidden" name="marine_indiv" value="1" />';
									}
									if(!isset($_POST['level_M1'])){
										echo '<input type="hidden" name="M1" value="0" />';
									}else{
										echo '<input type="hidden" name="M1" value="1" />';
									}
									if(!isset($_POST['level_M2'])){
										echo '<input type="hidden" name="M2" value="0" />';
									}else{
										echo '<input type="hidden" name="M2" value="1" />';
									}
									if(!isset($_POST['level_M3'])){
										echo '<input type="hidden" name="M3" value="0" />';
									}else{
										echo '<input type="hidden" name="M3" value="1" />';
									}
									if(!isset($_POST['extended_area'])){
										echo '<input type="hidden" name="extended_area" value="0" />';
									}else{
										echo '<input type="hidden" name="extended_area" value="1" />';
									}
									if(!isset($_POST['local'])){
										echo '<input type="hidden" name="local" value="0" />';
									}else{
										echo '<input type="hidden" name="local" value="1" />';
									}
									if(!isset($_POST['lifetime'])){
										echo '<input type="hidden" name="lifetime" value="0" />';
									}else{
										echo '<input type="hidden" name="lifetime" value="1" />';
									}
							
								
									echo '<input type="hidden" name="company_indiv" value="'.$_POST['company_indiv'].'" />
									<input type="hidden" name="email_indiv" value="'.$_POST['email_indiv'].'" />
									<input type="hidden" name="address_indiv" value="'.$_POST['address_indiv'].'" />
									<input type="hidden" name="phone_indiv" value="'.$_POST['phone_indiv'].'" />
									<input type="hidden" name="country_indiv" value="'.$_POST['country_indiv'].'" />
									<input type="hidden" name="currency" value="'.$_POST['currency'].'" />
									<input type="hidden" name="profession_indiv" value="'.$_POST['profession_indiv'].'" />
									
									<input type="hidden" name="year_effective" value="'.$_POST['year_effective'].'" />
									<input type="hidden" name="location" value="'.$_POST['location'].'" />
									<input type="hidden" name="type_con" value="'.$_POST['type_con'].'" />
								
									
									<table width="100%" class="table table-bordered " id="dataTables-plan">
										<thead>
											<tr style="background-color: #aaaaaa">
												<th></th>
												<th width="8%">Level</th>
												<th>Product</th>
												<th>Plan</th>
												<th width="5%">Age</th>
												<th width="10%">Deductible</th>
												<th width="10%">Type Duration</th>
												<th width="7%">Zone</th>
												<th width="10%">Premium</th>
											</tr>
										</thead>
										<tbody>';
							
							foreach($all as $p){
								
								if($p['type_age_caculaion'] == "CY"){
									$data['age'] = $age_cy;
									$data['type_age_caculaion'] = "CY";
								}else{
									$data['age'] = $age_ca;
									$data['type_age_caculaion'] = "CA";
								}
								
								$data['id_product'] = $p['id_product'];
								
								$product_available = $product->getProductSearch($data);
								if(sizeof($product_available) > 0){ ?>
								<?php foreach($product_available as $av){ 
									
								if(!isset($_POST['lifetime'])){
									if(($av['NLT'] == 1) AND ($av['LT'] == 1)){
										if($av['lifetime_option'] == 'NLT' ){
											
										if(!isset($_POST['extended_area'])){
											if(($av['Z1'] == 1) AND ($av['Z2'] == 1)){
												if($av['zone'] == 'Z1' ){
													//print_r($product_available);
													if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
													
												}
											}else{
												//print_r($product_available);
												if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
											}
										}else{
											//print_r($product_available);
											if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
										}
								 }}else{
										if(!isset($_POST['extended_area'])){
											if(($av['Z1'] == 1) AND ($av['Z2'] == 1)){
												if($av['zone'] == 'Z1' ){
													//print_r($product_available);
													if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
													
												}
											}else{
												//print_r($product_available);
												if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
											}
										}else{
											//print_r($product_available);
											if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
										}
								}}else{
										if(!isset($_POST['extended_area'])){
											if(($av['Z1'] == 1) AND ($av['Z2'] == 1)){
												if($av['zone'] == 'Z1' ){
													//print_r($product_available);
													if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
													
												}
											}else{
												//print_r($product_available);
												if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
											}
										}else{
											//print_r($product_available);
											if($av['name_level'] == "M1"){ $color = "m1";}
													if($av['name_level'] == "M2"){ $color = "m2";}
													if($av['name_level'] == "M3"){ $color = "m3";}
													if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
														$not_eligible = true;
													}else{
														$not_eligible = false;
													}
													$realprice_indiv = $av['price']+$av['assis_indiv'] + $av['adh_fee'];
													$rate = 1;

													if($av['currency'] != $_POST['currency']){
														$curr = $currency->getCurrenyById($av['currency']);
														$rate = $curr['rate'];

													}
													?>

													<?php if($not_eligible){
														echo "<tr class='".$color."' style='opacity:0.5'>";
													}else{
														echo "<tr class='".$color."'>";
													}?>
														<?php 
														if(!$not_eligible){
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'"/></td>';
														}else{
															echo '<td class=" text-center"><input type="checkbox" name="selected_indiv[]" value="'.$av['id_premium'].'" disabled/></td>';
														}
															echo '<td >'.$av['name_level'].'</td>';
															echo '<td >'.$av['name_product'].'</td>';
														if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
															echo '<td >'.$av['name_plan'].'<span class="red" style="float:right;">
															<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
															</td>';
														}else{
															
															echo '<td >'.$av['name_plan'].'</td>';
														}

															echo '<td class=" text-center">'.$av['age'].'</td>';
														if($av['deductible'] != 0){
															echo '<td class=" text-center">'.$av['deductible'].'</td>';
														}else{
															echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
														}


															echo '<td class=" text-center">'.$av['lifetime_option'].'</td>';
															echo '<td class=" text-center">'.$av['zone'].'</td>';
													
															
															
															
															echo '<td class="text-right "><b>'.number_format(floor($realprice_indiv * $rate)).'</b></td>';
															
														echo '</tr>';
										}
								}}
										
									
							}
							}
							echo '		</tbody>
									</table>
									<center>
									<input type="submit" class="btn btn-primary btn-lg" value=" Save Quote "/>
									</center>
									</form>
								</div>';
						}
					}else{
						/* 1st insured */
						if($_POST['dob_1st_family'] != ""){
							$a = explode("/",$_POST['dob_1st_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_1st = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_1st = $from->diff($to)->y;
						}else{
							if($_POST['age_1st_family'] != ""){
								$age_cy_1st = $_POST['age_1st_family'];
								$age_ca_1st = $_POST['age_1st_family'];
							}
						}
						
						/* 2nd insured */
						if($_POST['dob_2nd_family'] != ""){
							$a = explode("/",$_POST['dob_2nd_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_2nd = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_2nd = $from->diff($to)->y;
						}else{
							if($_POST['age_2nd_family'] != ""){
								$age_cy_2nd = $_POST['age_2nd_family'];
								$age_ca_2nd = $_POST['age_2nd_family'];
							}else{
								$age_cy_2nd = 0;
								$age_ca_2nd = 0;
							}
						}
						
						/* 1 children insured */
						if($_POST['dob_1_child_family'] != ""){
							$a = explode("/",$_POST['dob_1_child_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_1_child = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_1_child = $from->diff($to)->y;
						}else{
							if($_POST['age_1_child_family'] != ""){
								$age_cy_1_child = $_POST['age_1_child_family'];
								$age_ca_1_child = $_POST['age_1_child_family'];
							}else{
								$age_cy_1_child = 0;
								$age_ca_1_child = 0;
							}
						}
						
						/* 2 children insured */
						if($_POST['dob_2_child_family'] != ""){
							$a = explode("/",$_POST['dob_2_child_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_2_child = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_2_child = $from->diff($to)->y;
						}else{
							if($_POST['age_2_child_family'] != ""){
								$age_cy_2_child = $_POST['age_2_child_family'];
								$age_ca_2_child = $_POST['age_2_child_family'];
							}else{
								$age_cy_2_child = 0;
								$age_ca_2_child = 0;
							}
						}
						
						/* 3 children insured */
						if($_POST['dob_3_child_family'] != ""){
							$a = explode("/",$_POST['dob_3_child_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_3_child = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_3_child = $from->diff($to)->y;
						}else{
							if($_POST['age_3_child_family'] != ""){
								$age_cy_3_child = $_POST['age_3_child_family'];
								$age_ca_3_child = $_POST['age_3_child_family'];
							}else{
								$age_cy_3_child = 0;
								$age_ca_3_child = 0;
							}
						}
						
						/* 4 children insured */
						if($_POST['dob_4_child_family'] != ""){
							$a = explode("/",$_POST['dob_4_child_family']);
							$dob= $a[2].'-'.$a[1].'-'.$a[0];
							$age_cy_4_child = ($_POST['year_effective'] - date('Y',strtotime($dob)));
							$from = new DateTime($dob);
							$to   = new DateTime('today');
							$age_ca_4_child = $from->diff($to)->y;
						}else{
							if($_POST['age_4_child_family'] != ""){
								$age_cy_4_child = $_POST['age_4_child_family'];
								$age_ca_4_child = $_POST['age_4_child_family'];
							}else{
								$age_cy_4_child = 0;
								$age_ca_4_child = 0;
							}
						}
						
						
						
						$all = $product->getAllProduct();
						
						if(sizeof($all) > 0){
							echo '<div class="panel-body">
									<form method="POST" action="save_quote_family.php" id="quote_family">
									
									
									<input type="hidden" name="year_effective" value="'.$_POST['year_effective'].'" />
									<input type="hidden" name="location" value="'.$_POST['location'].'" />
									<input type="hidden" name="type_con" value="'.$_POST['type_con'].'" />';
							
									if(!isset($_POST['level_M1'])){
										echo '<input type="hidden" name="M1" value="0" />';
									}else{
										echo '<input type="hidden" name="M1" value="1" />';
									}
									if(!isset($_POST['level_M2'])){
										echo '<input type="hidden" name="M2" value="0" />';
									}else{
										echo '<input type="hidden" name="M2" value="1" />';
									}
									if(!isset($_POST['level_M3'])){
										echo '<input type="hidden" name="M3" value="0" />';
									}else{
										echo '<input type="hidden" name="M3" value="1" />';
									}
									if(!isset($_POST['extended_area'])){
										echo '<input type="hidden" name="extended_area" value="0" />';
									}else{
										echo '<input type="hidden" name="extended_area" value="1" />';
									}
									if(!isset($_POST['local'])){
										echo '<input type="hidden" name="local" value="0" />';
									}else{
										echo '<input type="hidden" name="local" value="1" />';
									}
									if(!isset($_POST['lifetime'])){
										echo '<input type="hidden" name="lifetime" value="0" />';
									}else{
										echo '<input type="hidden" name="lifetime" value="1" />';
									}
							
							
									echo '<input type="hidden" name="company_family" value="'.$_POST['company_family'].'" />
									<input type="hidden" name="email_family" value="'.$_POST['email_family'].'" />
									<input type="hidden" name="address_family" value="'.$_POST['address_family'].'" />
									<input type="hidden" name="phone_family" value="'.$_POST['phone_family'].'" />
									<input type="hidden" name="country_family" value="'.$_POST['country_family'].'" />
									<input type="hidden" name="profession_family" value="'.$_POST['profession_family'].'" />
									<input type="hidden" name="currency" value="'.$_POST['currency'].'" />';
									
									/* 1st insured adult*/
									echo '
									<input type="hidden" name="sex_1st_family" value="'.$_POST['sex_1st_family'].'" />
									<input type="hidden" name="dob_1st_family" value="'.$_POST['dob_1st_family'].'" />
									<input type="hidden" name="age_1st_family" value="'.$_POST['age_1st_family'].'" />
									<input type="hidden" name="firstname_1st_family" value="'.$_POST['firstname_1st_family'].'" />
									<input type="hidden" name="lastname_1st_family" value="'.$_POST['lastname_1st_family'].'" />
									<input type="hidden" name="nationality_1st_family" value="'.$_POST['nationality_1st_family'].'" />';
							
									if(!isset($_POST['marine_1st_family'])){
										echo '<input type="hidden" name="marine_1st_family" value="0" />';
									}else{
										echo '<input type="hidden" name="marine_1st_family" value="1" />';
									}
							
									/* 2nd insured adult*/
									echo '
									<input type="hidden" name="sex_2nd_family" value="'.$_POST['sex_2nd_family'].'" />
									<input type="hidden" name="dob_2nd_family" value="'.$_POST['dob_2nd_family'].'" />
									<input type="hidden" name="age_2nd_family" value="'.$_POST['age_2nd_family'].'" />
									<input type="hidden" name="firstname_2nd_family" value="'.$_POST['firstname_2nd_family'].'" />
									<input type="hidden" name="lastname_2nd_family" value="'.$_POST['lastname_2nd_family'].'" />
									<input type="hidden" name="nationality_2nd_family" value="'.$_POST['nationality_2nd_family'].'" />';
							
									if(!isset($_POST['marine_2nd_family'])){
										echo '<input type="hidden" name="marine_2nd_family" value="0" />';
									}else{
										echo '<input type="hidden" name="marine_2nd_family" value="1" />';
									}
							
									/* 1 children insured */
									echo '
									<input type="hidden" name="sex_1_child_family" value="'.$_POST['sex_1_child_family'].'" />
									<input type="hidden" name="dob_1_child_family" value="'.$_POST['dob_1_child_family'].'" />
									<input type="hidden" name="age_1_child_family" value="'.$_POST['age_1_child_family'].'" />
									<input type="hidden" name="firstname_1_child_family" value="'.$_POST['firstname_1_child_family'].'" />
									<input type="hidden" name="lastname_1_child_family" value="'.$_POST['lastname_1_child_family'].'" />
									<input type="hidden" name="nationality_1_child_family" value="'.$_POST['nationality_1_child_family'].'" />';
							
									/* 2 children insured */
									echo '
									<input type="hidden" name="sex_2_child_family" value="'.$_POST['sex_2_child_family'].'" />
									<input type="hidden" name="dob_2_child_family" value="'.$_POST['dob_2_child_family'].'" />
									<input type="hidden" name="age_2_child_family" value="'.$_POST['age_2_child_family'].'" />
									<input type="hidden" name="firstname_2_child_family" value="'.$_POST['firstname_2_child_family'].'" />
									<input type="hidden" name="lastname_2_child_family" value="'.$_POST['lastname_2_child_family'].'" />
									<input type="hidden" name="nationality_2_child_family" value="'.$_POST['nationality_2_child_family'].'" />';
							
									/* 3 children insured */
									echo '
									<input type="hidden" name="sex_3_child_family" value="'.$_POST['sex_3_child_family'].'" />
									<input type="hidden" name="dob_3_child_family" value="'.$_POST['dob_3_child_family'].'" />
									<input type="hidden" name="age_3_child_family" value="'.$_POST['age_3_child_family'].'" />
									<input type="hidden" name="firstname_3_child_family" value="'.$_POST['firstname_3_child_family'].'" />
									<input type="hidden" name="lastname_3_child_family" value="'.$_POST['lastname_3_child_family'].'" />
									<input type="hidden" name="nationality_3_child_family" value="'.$_POST['nationality_3_child_family'].'" />';
							
									/* 4 children insured */
									echo '
									<input type="hidden" name="sex_4_child_family" value="'.$_POST['sex_4_child_family'].'" />
									<input type="hidden" name="dob_4_child_family" value="'.$_POST['dob_4_child_family'].'" />
									<input type="hidden" name="age_4_child_family" value="'.$_POST['age_4_child_family'].'" />
									<input type="hidden" name="firstname_4_child_family" value="'.$_POST['firstname_4_child_family'].'" />
									<input type="hidden" name="lastname_4_child_family" value="'.$_POST['lastname_4_child_family'].'" />
									<input type="hidden" name="nationality_4_child_family" value="'.$_POST['nationality_4_child_family'].'" />';
							
									
									echo '<table width="100%" class="table table-bordered " id="dataTables-family">
										<thead>
											<tr style="background-color: #aaaaaa">
												<th></th>
												<th width="8%">Level</th>
												<th>Product</th>
												<th>Plan</th>
												<th width="10%">Deductible</th>
												<th width="10%">Type Duration</th>
												<th width="7%">Zone</th>
												<th width="10%">Premium</th>
											</tr>
										</thead>
										<tbody>';
							foreach($all as $p){
								
								if($p['type_age_caculaion'] == "CY"){
									$data['age_1st'] = $age_cy_1st;
									$data['age_2nd'] = $age_cy_2nd;
									$data['age_1_child'] = $age_cy_1_child;
									$data['age_2_child'] = $age_cy_2_child;
									$data['age_3_child'] = $age_cy_3_child;
									$data['age_4_child'] = $age_cy_4_child;
								}else{
									$data['age_1st'] = $age_ca_1st;
									$data['age_2nd'] = $age_ca_2nd;
									$data['age_1_child'] = $age_ca_1_child;
									$data['age_2_child'] = $age_ca_2_child;
									$data['age_3_child'] = $age_ca_3_child;
									$data['age_4_child'] = $age_ca_4_child;
								}
								
								$data['id_product'] = $p['id_product'];
								$data['marine'] = $data['marine_1st_family'];
								$data['sex'] = $data['sex_1st_family'];
								
								$product_available = $product->getPlanAvailableBySearch($data);
								$age = array();
								
								$age[] = $data['age_1st'];
								
								if($data['age_2nd'] != 0){
									$age[] = $data['age_2nd'];
								}
								
								$age_child_under_19 = array();
								$age_child_up_19 = array();
								$age_child = array();
								
								
								if($data['age_1_child'] != 0){
									if(intval($data['age_1_child']) > 18){
										$age_child_up_19[] = $data['age_1_child'];
									}else{
										$age_child_under_19[] = $data['age_1_child'];
									}
									$age_child[] = $data['age_1_child'];
								}
								
								if($data['age_2_child'] != 0){
									if(intval($data['age_2_child']) > 18){
										$age_child_up_19[] = $data['age_2_child'];
									}else{
										$age_child_under_19[] = $data['age_2_child'];
									}
									$age_child[] = $data['age_2_child'];
								}
								
								if($data['age_3_child'] != 0){
									if(intval($data['age_3_child']) > 18){
										$age_child_up_19[] = $data['age_3_child'];
									}else{
										$age_child_under_19[] = $data['age_3_child'];
									}
									$age_child[] = $data['age_3_child'];
								}
								
								if($data['age_4_child'] != 0){
									if(intval($data['age_4_child']) > 18){
										$age_child_up_19[] = $data['age_4_child'];
									}else{
										$age_child_under_19[] = $data['age_4_child'];
									}
									$age_child[] = $data['age_4_child'];
								}
								//$age[] = $data['age_1_child'];
								
								
								
								/** Parent Price By Product **/
								if(sizeof($product_available) > 0){
									$info = array();
									$hidden = "";
									$list_price = array();
									
									foreach($product_available as $level){
										
										
										
										if(!isset($_POST['lifetime'])){
											if(($level['LT'] == 1) AND ($level['NLT'] == 1)){
												if($level['lifetime_option'] == 'NLT'){
													
													
													if(!isset($_POST['extended_area'])){
														if(($level['Z1'] == 1) AND ($level['Z2'] == 1)){
															if($level['zone'] == "Z1"){
																
																$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}
										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
																
										$total = $total + $level['assis_family'];
										
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
																
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
																
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
										
															
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
															
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
															}
														}else{
															$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}

										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										
										$total = $total + $level['assis_family'];
										
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
										$realprice = $realprice + $level['adh_fee'];
										$total = $total +  $level['adh_fee'];
															
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
														}
													}else{
														$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}

										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
														
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
													}
													
													
													
												}
											}else{
												if(!isset($_POST['extended_area'])){
														if(($level['Z1'] == 1) AND ($level['Z2'] == 1)){
															if($level['zone'] == "Z1"){
																
																$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}

										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
																
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
																
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
															}
														}else{
															$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}

										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										
										$total = $total + $level['assis_family'];
										
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
															
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
															
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
														}
													}else{
														$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}
										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
													
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
													
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
													}
											}
										}else{
											if(!isset($_POST['extended_area'])){
														if(($level['Z1'] == 1) AND ($level['Z2'] == 1)){
															if($level['zone'] == "Z1"){
																
																$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}
										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
																
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
																
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
															}
														}else{
															$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}
										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
															
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
															
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
														}
													}else{
														$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age);
										$total = 0;
										$rate_currency = 1;
										if($p['currency'] != $_POST['currency']){
											$curr = $currency->getCurrenyById($p['currency']);
											$rate_currency = $curr['rate'];
										}
										$tol = sizeof($age) + sizeof($age_child);
										if(($level['family'] == 1) && ($tol >2)){
											$total = $level['price_family'];
											$info[] = 'Family Pack  : '.number_format(floor($level['price_family']*$rate_currency));
											$hidden .= '<input type="hidden" name="family_pack_'.$level['id_level'].'" value="'.$level['price_family'].'" />';
										}else{
											
										$iii = 1;
										foreach($all_level as $price){
											$total = $total + $price['price'];
											$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
											$hidden .= '<input type="hidden" name="adult_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
											$iii++;
											//echo $price['price'].'+';
										}
										
										
										if(sizeof($age_child) > 0){
											
											
											/* if special price for children */
											if($level['children'] == 1){
												
												/* get special price for children age under 18 yearold */
												if(sizeof($age_child_under_19) > 0){
													$total = $total + $level[''.sizeof($age_child_under_19).'_children'];
													$info[] = "Children ".sizeof($age_child_under_19)." : ".number_format(floor($level[''.sizeof($age_child_under_19).'_children']*$rate_currency));
													//echo $level[''.sizeof($age_child_under_19).'_children'].'+';
													$hidden .= '<input type="hidden" name="children_pack_'.$level['id_level'].'" value="'.$level[''.sizeof($age_child_under_19).'_children'].'" />';
												}
												
												
												/* if age higher than 18 yearold get normal price*/
												if(sizeof($age_child_up_19) > 0){
													$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child_up_19);
													$iii = 1;
													foreach($all_level as $price){
														$total = $total + $price['price'];
														//echo $price['price'].'+';
														$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
														$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
														$iii++;
													}
												}
											}else{
												/* get normal price for all age*/
												$all_level = $product->getProductSearchByLevelAge($level['id_level'],$age_child);
												$iii=1;
												foreach($all_level as $price){
													$total = $total + $price['price'];
													$info[] = 'Age '.$price['age'].' : '.number_format(floor($price['price']*$rate_currency));
													$hidden .= '<input type="hidden" name="children_'.$iii.'_'.$level['id_level'].'" value="'.$price['price'].'" />';
													$iii++;
													//echo $price['price'].'+';
												}
											}
										}
										}
										$total = $total + $level['assis_family'];
										//echo ' = '.$total.'<br />';
										if(($p['location'] != 'ALL') && ($p['location'] != '') && ($p['location'] != $_POST['location'])){
											$not_eligible = true;
										}else{
											$not_eligible = false;
										}
										if($level['name_level'] == "M1"){ $color = "m1";}
										if($level['name_level'] == "M2"){ $color = "m2";}
										if($level['name_level'] == "M3"){ $color = "m3";}
										if($not_eligible){
											echo '<tr class="'.$color.'" style="opacity:0.5">';
										}else{
											echo '<tr class="'.$color.'">';
										}
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){
											$realprice = $total - ($total * ($p['discount_percent']/100));
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="'.$p['discount_percent'].'" />';
										}else{
											$realprice = $total;
											$hidden .= '<input type="hidden" name="discount_'.$level['id_level'].'" value="0" />';
										}
										
										echo $hidden;
										
										if($not_eligible){
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" disabled /></td>';
										}else{
											echo '<td class=" text-center"><input type="checkbox" name="selected_permium[]" value="'.$level['id_level'].'" /><input type="hidden" name="price_'.$level['id_level'].'" value="'.$realprice.'" /></td>';
										}
										
										echo '<td >'.$level['name_level'].'</td>';
										if($p['discount'] == 1 && $tol >= $p['minimum_nb_contract']){
											echo '<td >'.$p['name_product'].' <i>(Discount '.$p['discount_percent'].'%)</i></td>';
										}else{
											echo '<td >'.$p['name_product'].'</td>';
										}
										
										
										if($not_eligible){
											echo '<td >'.$level['name_plan'].'<span class="red" style="float:right;">
											<i class="fa fa-times" aria-hidden="true"></i> Not eligible for This country </span>
											</td>';
										}else{
											echo '<td ><b>'.$level['name_plan'].'</b><i>';
											$ii = 1;
											if(sizeof($info) > 0){
												echo '<br /> { ';
												foreach($info as $in){
													
													if($ii == sizeof($info)){
														echo $in;
													}else{
														echo $in.' | ';
													}
													$ii++;
												}
												echo ' }';
												
											}
											echo '</i><span style="float:right;">
											</span>
											</td>';
										}
										if($level['deductible'] != 0){
											echo '<td class=" text-center">'.$level['deductible'].'</td>';
										}else{
											echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
										}
										echo '<td class=" text-center">'.$level['lifetime_option'].'</td>';
										echo '<td class=" text-center">'.$level['zone'].'</td>';
										$realprice = $realprice + $level['adh_fee'];
										$total = $total + $level['adh_fee'];
												
										if($p['currency'] != $_POST['currency']){
											
											$curr = $currency->getCurrenyById($p['currency']);
											$realprice = floor($realprice * $curr['rate']);
											$total = floor($total * $curr['rate']);
										}
										
										if(($p['discount'] == 1) && ($tol >= $p['minimum_nb_contract'])){			  
											echo '<td class="text-right "><s>'.number_format($total).'</s>  <b>'.number_format($realprice,2).'</b></td>';
										}else{
											echo '<td class="text-right "><b>'.number_format($realprice,2).'</b></td>';
											}
										
										echo "</tr>";
										unset($info);
													}
										}
										
									}
								}
								
							unset($age);
							unset($age_child_under_19);
							unset($age_child_up_19);
							unset($age_child);
							
							
							}
							echo '		</tbody>
									</table>
									<center>
									<input type="submit" class="btn btn-primary btn-lg" value=" Save Quote "/>
									</center>
									</form>
								</div>';
							}
						
						
						} // end Family type
					
					} // if isset type_con
			?>
				
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>

