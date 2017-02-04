<?php

include("header.php"); 
include("sidebar.php");

require_once("classes/Currency.php");
$currency = Currency::getInstance();

require_once("classes/Location.php");
$location = Location::getInstance();

require_once("classes/Country.php");
$country = Country::getInstance();

require_once("classes/Product.php");
$product = Product::getInstance();

require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

$all_c = $country->getAllCountry();

$quote = $quotation->getQuotationById($_GET['quote']);

if($_GET['type'] == "INDIV"){
	$app = $applicant->getApplicantByQuoteIndiv($_GET['quote']);
}else{
	$app = $applicant->getApplicantByQuote($_GET['quote']);
}

?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-file-o fa-fw"></i> Edit Client Information Quote Nº : <?php echo $quote['reference'].''.$quote['id_quote']?></h1>
                </div>
                <div class="row">
                
                <?php if($_GET['type'] == "INDIV"){ ?>
                <form action="edit_applicant_indiv_process.php" method="post">
                
                <input type="hidden" name="id_applicant" value="<?php echo $app['id_applicant']; ?>" />
                <input type="hidden" name="id_quote" value="<?php echo $quote['id_quote']; ?>" />
                <div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_indiv" disabled>
								<option value="F" <?php if(isset($app['sex'])){if($app['sex'] == "F"){echo "selected";}} ?>>F</option>
								<option value="M" <?php if(isset($app['sex'])){if($app['sex'] == "M"){echo "selected";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control" name="dob" <?php if(isset($app['date_of_birth'])){ echo 'value="'.$app['date_of_birth'].'"';} ?> readonly />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
         			
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" name="age" value="<?php echo $app['age']?>" readonly />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname" value="<?php echo $app['firstname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname" value="<?php echo $app['lastname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality">
								<?php 
								foreach($all_c as $c){
									if($app['nationality'] == $c['country_name']){
										echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
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
								<input type="checkbox" disabled name="marine" value="1" <?php if($app['marine'] == 1){echo 'checked';}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
          		<div class="col-lg-12"></div>
				<div class="col-lg-4">
					<div class="form-group">
						<label >Company name (optional)</label>
						<input type="text" class="form-control" name="company" value="<?php echo $quote['company'] ?>" />
					</div>
					<div class="form-group">
						<label >Email (optional)</label>
						<input type="text" class="form-control" name="email" value="<?php echo $quote['email'] ?>"  />
					</div>
				</div>
         		<div class="col-lg-4">
					<div class="form-group">
						<label >Address (optional)</label>
						<textarea class="form-control" rows="5" name="address"><?php echo $quote['address'] ?></textarea>
					</div>
				</div>
         		<div class="col-lg-2">
					<div class="form-group">
						<label >Phone number (optional)</label>
						<input type="text" class="form-control" name="phone" value="<?php echo $quote['tel'] ?>" />
					</div>
					
				</div>
				<div class="col-lg-2">
				<div class="form-group">
						<label >Country Of Residence (optional)</label>
						<input type="text" class="form-control" name="country" value="<?php echo $quote['country'] ?>" />
					</div>
				</div>
				<div class="col-lg-4">
						<div class="form-group">
							<label >Profession (optional)</label>
							<input type="text" class="form-control" name="profession" value="<?php echo $quote['profession'] ?>" />
						</div>
					</div>
				<div class="col-lg-12">
				 <input type="submit" value=" Confirm Edit" class="btn btn-primary" />
				</div>
				
				
				</form>
				<?php }else{ ?>
				
				<form action="edit_applicant_family_process.php" method="post">
                
                
                <input type="hidden" name="id_quote" value="<?php echo $quote['id_quote']; ?>" />
                
                <!-- 1st applicant-->
                <div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_1st" disabled>
								<option value="F" <?php if(isset($app[0]['sex'])){if($app[0]['sex'] == "F"){echo "selected";}} ?>>F</option>
								<option value="M" <?php if(isset($app[0]['sex'])){if($app[0]['sex'] == "M"){echo "selected";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control" name="dob_1st" <?php if(isset($app[0]['date_of_birth'])){ echo 'value="'.$app[0]['date_of_birth'].'"';} ?> readonly />
								<input type="hidden" name="id_applicant_1st" value="<?php echo $app[0]['id_applicant']; ?>" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
         			
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" name="age_1st" value="<?php echo $app[0]['age']?>" readonly />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_1st" value="<?php echo $app[0]['firstname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_1st" value="<?php echo $app[0]['lastname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_1st">
								<?php 
								foreach($all_c as $c){
									if($app[0]['nationality'] == $c['country_name']){
										echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
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
								<input type="checkbox" disabled name="marine_1st" value="1" <?php if($app[0]['marine'] == 1){echo 'checked';}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
          		<!-- end 1st applicant-->
					<div class="col-lg-12"></div>
          		<?php if($app[1]['type_applicant'] == '2ND'){ ?>
          		
          		<!-- 2nd applicant-->
                <div class="col-lg-1">
                		<div class="form-group">
							<label >Gender</label>
							<select class="form-control" name="sex_2nd" disabled>
								<option value="F" <?php if(isset($app[1]['sex'])){if($app[1]['sex'] == "F"){echo "selected";}} ?>>F</option>
								<option value="M" <?php if(isset($app[1]['sex'])){if($app[1]['sex'] == "M"){echo "selected";}} ?>>M</option>
							</select>
					  	</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label>Date of birth</label>
							<div class='input-group date'>
								<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[1]['date_of_birth'])){ echo 'value="'.$app[1]['date_of_birth'].'"';} ?> readonly />
								<input type="hidden" name="id_applicant_2nd" value="<?php echo $app[1]['id_applicant']; ?>" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div>
         			
          			<div class="col-lg-1">
						<div class="form-group">
							<label >Age</label>
							<input type="text" class="form-control" name="age_2nd" value="<?php echo $app[1]['age']?>" readonly />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Firstname</label>
							<input type="text" class="form-control" name="firstname_2nd" value="<?php echo $app[1]['firstname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Lastname</label>
							<input type="text" class="form-control" name="lastname_2nd" value="<?php echo $app[1]['lastname']?>" />
						</div>
					</div>
          			<div class="col-lg-2">
						<div class="form-group">
							<label >Nationality</label>
							<select class="form-control" name="nationality_2nd">
								<?php 
								foreach($all_c as $c){
									if($app[1]['nationality'] == $c['country_name']){
										echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
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
								<input type="checkbox" disabled name="marine_2nd" value="1" <?php if($app[1]['marine'] == 1){echo 'checked';}?>> <i class="fa fa-anchor" aria-hidden="true"></i> Marine Activity
							</label> 
						</div>
					</div>
          		</div>
          		<!-- end 2nd applicant-->
          		<fieldset>
          			<legend> <i class="fa fa-users" aria-hidden="true"></i> Children </legend>
          			<?php if(isset($app[2]['sex'])){ ?>
          			<!-- 1_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_1_child" disabled>
									<option value="F" <?php if(isset($app[2]['sex'])){if($app[2]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[2]['sex'])){if($app[2]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[2]['date_of_birth'])){ echo 'value="'.$app[2]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_1_child" value="<?php echo $app[2]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_1_child" value="<?php echo $app[2]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_1_child" value="<?php echo $app[2]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_1_child" value="<?php echo $app[2]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_1_child">
									<?php 
									foreach($all_c as $c){
										if($app[2]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 1_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[3]['sex'])){ ?>
          		<!-- 2_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_1_child" disabled>
									<option value="F" <?php if(isset($app[3]['sex'])){if($app[3]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[3]['sex'])){if($app[3]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[3]['date_of_birth'])){ echo 'value="'.$app[3]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_2_child" value="<?php echo $app[3]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_2_child" value="<?php echo $app[3]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_2_child" value="<?php echo $app[3]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_2_child" value="<?php echo $app[3]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_2_child">
									<?php 
									foreach($all_c as $c){
										if($app[3]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 2_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[4]['sex'])){ ?>
          		<!-- 3_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_2_child" disabled>
									<option value="F" <?php if(isset($app[4]['sex'])){if($app[4]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[4]['sex'])){if($app[4]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[4]['date_of_birth'])){ echo 'value="'.$app[4]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_3_child" value="<?php echo $app[4]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_3_child" value="<?php echo $app[4]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_3_child" value="<?php echo $app[4]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_3_child" value="<?php echo $app[4]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_3_child">
									<?php 
									foreach($all_c as $c){
										if($app[4]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 3_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[5]['sex'])){ ?>
          		<!-- 4_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_2_child" disabled>
									<option value="F" <?php if(isset($app[5]['sex'])){if($app[5]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[5]['sex'])){if($app[5]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[5]['date_of_birth'])){ echo 'value="'.$app[5]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_4_child" value="<?php echo $app[5]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_3_child" value="<?php echo $app[5]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_3_child" value="<?php echo $app[5]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_3_child" value="<?php echo $app[5]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_3_child">
									<?php 
									foreach($all_c as $c){
										if($app[5]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 4_children applicant-->
          		<?php } ?>
          		</fieldset>
          		
          		<?php }else{ ?>
          		<fieldset>
          			<legend> <i class="fa fa-users" aria-hidden="true"></i> Children </legend>
          			<?php if(isset($app[1]['sex'])){ ?>
          			<!-- 1_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_1_child" disabled>
									<option value="F" <?php if(isset($app[1]['sex'])){if($app[1]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[1]['sex'])){if($app[1]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[1]['date_of_birth'])){ echo 'value="'.$app[1]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_1_child" value="<?php echo $app[1]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_1_child" value="<?php echo $app[1]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_1_child" value="<?php echo $app[1]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_1_child" value="<?php echo $app[1]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_1_child">
									<?php 
									foreach($all_c as $c){
										if($app[1]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 1_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[2]['sex'])){ ?>
          		<!-- 2_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_1_child" disabled>
									<option value="F" <?php if(isset($app[2]['sex'])){if($app[2]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[2]['sex'])){if($app[2]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[2]['date_of_birth'])){ echo 'value="'.$app[3]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_2_child" value="<?php echo $app[2]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_2_child" value="<?php echo $app[2]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_2_child" value="<?php echo $app[2]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_2_child" value="<?php echo $app[2]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_2_child">
									<?php 
									foreach($all_c as $c){
										if($app[2]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 2_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[3]['sex'])){ ?>
          		<!-- 3_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_2_child" disabled>
									<option value="F" <?php if(isset($app[3]['sex'])){if($app[3]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[3]['sex'])){if($app[3]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[3]['date_of_birth'])){ echo 'value="'.$app[3]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_3_child" value="<?php echo $app[3]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_3_child" value="<?php echo $app[3]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_3_child" value="<?php echo $app[3]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_3_child" value="<?php echo $app[3]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_3_child">
									<?php 
									foreach($all_c as $c){
										if($app[3]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 3_children applicant-->
          		<?php } ?>
          		<?php if(isset($app[4]['sex'])){ ?>
          		<!-- 4_children applicant-->
					<div class="col-lg-1">
							<div class="form-group">
								<label >Gender</label>
								<select class="form-control" name="sex_2_child" disabled>
									<option value="F" <?php if(isset($app[4]['sex'])){if($app[4]['sex'] == "F"){echo "selected";}} ?>>F</option>
									<option value="M" <?php if(isset($app[4]['sex'])){if($app[4]['sex'] == "M"){echo "selected";}} ?>>M</option>
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Date of birth</label>
								<div class='input-group date'>
									<input type='text' class="form-control" name="dob_2nd" <?php if(isset($app[4]['date_of_birth'])){ echo 'value="'.$app[4]['date_of_birth'].'"';} ?> readonly />
									<input type="hidden" name="id_applicant_4_child" value="<?php echo $app[4]['id_applicant']; ?>" />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group">
								<label >Age</label>
								<input type="text" class="form-control" name="age_4_child" value="<?php echo $app[4]['age']?>" readonly />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Firstname</label>
								<input type="text" class="form-control" name="firstname_4_child" value="<?php echo $app[4]['firstname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Lastname</label>
								<input type="text" class="form-control" name="lastname_4_child" value="<?php echo $app[4]['lastname']?>" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label >Nationality</label>
								<select class="form-control" name="nationality_3_child">
									<?php 
									foreach($all_c as $c){
										if($app[4]['nationality'] == $c['country_name']){
											echo '<option value="'.$c['country_name'].'" selected>'.$c['country_name'].'</option>';
										}else{
											echo '<option value="'.$c['country_name'].'">'.$c['country_name'].'</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
         			<div class="col-lg-12"></div>
          		<!-- end 4_children applicant-->
          		<?php } ?>
          		</fieldset>
          		<?php } ?>
          		
          		<div class="col-lg-12"></div>
				<div class="col-lg-4">
					<div class="form-group">
						<label >Company name (optional)</label>
						<input type="text" class="form-control" name="company" value="<?php echo $quote['company'] ?>" />
					</div>
					<div class="form-group">
						<label >Email (optional)</label>
						<input type="text" class="form-control" name="email" value="<?php echo $quote['email'] ?>"  />
					</div>
				</div>
         		<div class="col-lg-4">
					<div class="form-group">
						<label >Address (optional)</label>
						<textarea class="form-control" rows="5" name="address"><?php echo $quote['address'] ?></textarea>
					</div>
				</div>
         		<div class="col-lg-2">
					<div class="form-group">
						<label >Phone number (optional)</label>
						<input type="text" class="form-control" name="phone" value="<?php echo $quote['tel'] ?>" />
					</div>
					
				</div>
				<div class="col-lg-2">
				<div class="form-group">
						<label >Country Of Residence (optional)</label>
						<input type="text" class="form-control" name="country" value="<?php echo $quote['country'] ?>" />
					</div>
					</div>
				<div class="col-lg-4">
						<div class="form-group">
							<label >Profession (optional)</label>
							<input type="text" class="form-control" name="profession" value="<?php echo $quote['profession'] ?>" />
						</div>
					</div>
				<div class="col-lg-12">
				 <input type="submit" value=" Confirm Edit" class="btn btn-primary" />
				</div>
				
				
				</form>
				<?php } ?>
				</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
<?php include("footer.php"); ?>
            