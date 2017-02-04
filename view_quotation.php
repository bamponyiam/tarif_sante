<?php 
	include("header.php");
	include("sidebar.php");

	require_once("classes/Quotation.php");
	$quotation = Quotation::getInstance();

	require_once("classes/Applicant.php");
	$applicant = Applicant::getInstance();

	require_once("classes/Product.php");
	$product = Product::getInstance();

	require_once("classes/Currency.php");
	$currency = Currency::getInstance();

	$quote = $quotation->getQuotationById($_GET['id']);
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-bars fa-fw"></i> Quotations Nº <?php echo $quote['reference'].''.$quote['id_quote'];?>  </h1>
                </div>
			</div>
                <div class="row">
                <div class="col-lg-12">
                        <div class="panel-heading">
                            <h4>Insured Details</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <table class="table table-bordered">
                                   <thead>
                                        <tr>
                                            <th width="5%">Nº</th>
                                            <th>Fullname</th>
                                            <th>Date of birth</th>
                                            <th width="5%" class="text-center">Age</th>
                                            <th>Nationality</th>
                                            <th width="20%">Country of residence</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                       	<?php 
											$app = $applicant->getApplicantByQuote($quote['id_quote']);
										
											if(sizeof($app) > 0){
												$i=1;
												foreach($app as $a){
													echo '<tr>
															<td>'.$i.'</td>
															<td>'.$a['firstname'].' '.$a['lastname'].'</td>
															<td>'.$a['date_of_birth'].'</td>
															<td class="text-center">'.$a['age'].'</td>
															<td>'.$a['nationality'].'</td>
															<td>'.$quote['country'].'</td>
															
														</tr>';
													$i++;
												}
											}
										?>
                                   	<tr>
                                   		<td></td>
                                   		<td colspan="3"><strong>Company :</strong><?php echo $quote['company'];?><br /><strong>Address :</strong>  <?php echo $quote['address'];?></td>
                                   		<td><strong>Phone :</strong> <?php echo $quote['tel'];?></td>
                                   		<td ><strong>Email :</strong><?php echo $quote['email'];?>
                                   		 <br /><strong>Profession :</strong><?php echo $quote['profession'];?></td>
                                   	</tr>
                                    </tbody>
                                </table>
                                <a href="edit-client-info?quote=<?php echo $quote['id_quote']?>&type=<?php echo $quote['type_con']?>" class="btn btn-warning" style="float: right"> Edit Information </a>
                            </div>
                            
						</div>
                           
                           
                            <!-- /.table-responsive -->
                            
                        <div class="panel-heading">
                          <h4>Selected Plan</h4>
                           <?php //if($u['office'] != 'THA'){?>
                            
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_family.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global (FR) </a>
                            
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global_en.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_family_en.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global (EN) </a>
                            
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global_en_new.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_en_new_family.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global New (EN) </a>
                            
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global_en_new_resume.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_en_new_family_resume.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global Summary (EN) </a>
                            
                            <?php //} else { if(($u['office'] != 'ALL') || ($u['office'] != 'THA')){?>
                            
                            	
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global_arawan.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_arawan_family.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-danger"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global Arawan (FR) </a>
                            
                            <a href="<?php if($quote['type_con'] == 'INDIV'){echo 'pdf_download_quote_global_arawan_en.php?id_quote='.$quote['id_quote'];}else{echo 'pdf_download_quote_global_arawan_family_en.php?id_quote='.$quote['id_quote'];} ?>" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Download PDF Global Arawan (EN) </a>
                            
                            <?php//} }?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <table class="table table-bordered">
                                   <thead>
                                        <tr>
                                            <th width="3%">Nº</th>
                                            <th width="5%">Level</th>
                                            <th>Plan</th>
                                            <th width="10%" class=" text-center">Deductible</th>
                                            <th width="10%" class="text-right">Premium Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       	<?php 
											$pre = $quotation->getSelectedPremiumByQuote($quote['id_quote']);
										
											if(sizeof($pre) > 0){
												$i=1;
												foreach($pre as $a){
													if($a['id_level'] != 0){
														$l = $product->getLevelById($a['id_level']);
													}else{
														$l = $product->getLevelByPremium($a['id_premium']);
													}
													
													echo '<tr>
															<td>'.$i.'</td>
															<td>'.$l['name_level'].'</td>';
														if($a['discount'] != 0){
															echo '<td><b>'.$l['name_plan'].' </b><i>(-'.$a['discount'].'%)</i><span style="float:right;"><a href="#premium_'.$a['id_premium_selected'].'" class="edit"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit / View Premium </a> &nbsp; <a href="pdf_download_quote.php?id_quote='.$quote['id_quote'].'&id_price='.$a['id_premium_selected'].'"><i class="fa fa-download" aria-hidden="true"></i> PDF </a></span>'; 
														}else{
															echo '<td><b>'.$l['name_plan'].'</b><span style="float:right;"><a href="#premium_'.$a['id_premium_selected'].'" class="edit"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit / View Premium </a> &nbsp; <a href="pdf_download_quote.php?id_quote='.$quote['id_quote'].'&id_price='.$a['id_premium_selected'].'"><i class="fa fa-download" aria-hidden="true"></i> PDF </a></span>'; 
														}
															?>
															
															<div style="display: none;" class="edit_field" id="premium_<?php echo $a['id_premium_selected'];?>">
															<br /><br />
															<form method="POST" action="edit_premium_selected.php?id=<?php echo $a['id_premium_selected'] ?>&quote=<?php echo $quote['id_quote']; ?>">
															<?php
													
															if($quote['type_con'] == "INDIV"){ ?>

															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Premium : </label>
																  <div class="col-xs-2">
																  	<input type="hidden" name="type_con" value="<?php echo $quote['type_con']; ?>" />
																	<input class="form-control cal-field" id="test" type="text" name="price_premium_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['1st_adult'];?>" >
																  </div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Membership fees : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="adh_cie_fee_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['adh_cie_fee']?>" >
																  </div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Additional Poema membership fees : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="adh_poema_fee_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['adh_poema_fee']?>" >
																  </div>
																</div>
															</div>
															<hr />
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Medical assistance (<?php echo $quote['type_con']; ?>) : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="ass_cie_<?php echo $a['id_premium_selected']; ?>" value="<?php if($quote['type_con'] == 'INDIV'){echo $a['ass_cie_indiv'];}else{echo $a['ass_cie_family'];} ?>" i>
																  </div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Additional Poema assistance fees : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="ass_poema_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['ass_poema']?>" >
																  </div>
																</div>
															</div>
															
															<?php }else{ // family pack ?>
															
															<?php if($a['family_pack'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Family Pack : </label>
																  <div class="col-xs-2">
																  	<input type="hidden" name="type_con" value="<?php echo $quote['type_con']; ?>" />
																	<input class="form-control cal-field" type="text" name="family_pack_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['family_pack'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['1st_adult'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">1st Adult Price : </label>
																  <div class="col-xs-2">
																  	<input type="hidden" name="type_con" value="<?php echo $quote['type_con']; ?>" />
																	<input class="form-control cal-field" type="text" name="1st_adult_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['1st_adult'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['2nd_adult'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">2nd Adult Price : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="2nd_adult_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['2nd_adult'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['children_pack'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Children under 18 pack : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="children_pack_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['children_pack'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['1_children'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"> Children 1 : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="1_children_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['1_children'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['2_children'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"> Children 2 : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="2_children_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['2_children'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['3_children'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"> Children 3 : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="3_children_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['3_children'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<?php if($a['4_children'] != 0){?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"> Children 4 : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="4_children_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['4_children'];?>" >
																  </div>
																</div>
															</div>
															<?php } ?>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Membership fees : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="adh_cie_fee_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['adh_cie_fee']?>" >
																  </div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Additional Poema membership fees  : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="adh_poema_fee_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['adh_poema_fee']?>" >
																  </div>
																</div>
															</div>
															<hr />
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Medical assistance (<?php echo $quote['type_con']; ?>) : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="ass_cie_<?php echo $a['id_premium_selected']; ?>" value="<?php if($quote['type_con'] == 'INDIV'){echo $a['ass_cie_indiv'];}else{echo $a['ass_cie_family'];} ?>" i>
																  </div>
																</div>
															</div>
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Additional Poema assistance fees : </label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="ass_poema_<?php echo $a['id_premium_selected']; ?>" value="<?php echo $a['ass_poema']?>" >
																  </div>
																</div>
															</div>
															<?php }
													
															$all_field = $quotation->getAdditionalFieldByIdPremiumSelected($a['id_premium_selected']);
															//print_r($all_field);
															$additional = 0;
															?>
															
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"><input type="text" class="form-control" name="title_field_1" value="<?php if(isset($all_field[0]['id_field'])){echo $all_field[0]['name_field']; }?>"  placeholder="Title 1" /></label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="field_1" value="<?php if(isset($all_field[0]['id_field'])){echo $all_field[0]['value_field'];$additional = $additional+$all_field[0]['value_field']; }else{echo '0';}?>" >
																  </div>
																</div>
															</div>
															
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right"><input type="text" class="form-control" name="title_field_2" value="<?php if(isset($all_field[1]['id_field'])){echo $all_field[1]['name_field']; }?>"  placeholder="Title 2" /></label>
																  <div class="col-xs-2">
																	<input class="form-control cal-field" type="text" name="field_2" value="<?php if(isset($all_field[1]['id_field'])){echo $all_field[1]['value_field'];$additional = $additional+$all_field[1]['value_field']; }else{echo '0';}?>" >
																  </div>
																</div>
															</div>
															
															<div class="col-lg-12">
																<div class="form-group row">
																  <label class="col-xs-3 col-form-label text-right">Grand total : </label>
																  <div class="col-xs-2">
																	<input class="form-control total" name="grand_total_<?php echo $a['id_premium_selected']; ?>" type="text" readonly value="<?php echo ($a['1st_adult']+$a['2nd_adult']+$a['1_children']+$a['2_children']+$a['3_children']+$a['4_children']+$a['family_pack']+$a['children_pack']+$a['adh_cie_fee']+$a['adh_poema_fee']+$a['ass_cie_family']+$a['ass_cie_indiv']+$a['ass_poema']+$additional) ?>" >
																  </div>
																</div>
															</div>
															<div class="col-lg-12 text-right">
																<input type="submit" value="Confirm Edit" class="btn btn-primary" />
																<input type="reset" value="Reset" class="btn btn-info" />
																<a href="#\" class="btn btn-default cancel-edit"> Cancel </a>
															</div>
															</form>
															</div>
													
															
													<?php 
															$pro = $product->getProductById($l['id_product']);
															$rate = 1;
															if($pro['currency'] != $quote['currency']){
																$curr = $currency->getCurrenyById($pro['currency']);
																$rate = $curr['rate'];
															}
															if($l['deductible'] != 0){
																echo '<td class=" text-center">'.number_format(floor($l['deductible']*$rate)).'</td>';
															}else{
																echo '<td class=" text-center"><i class="fa fa-times" aria-hidden="true"></i></td>';
															}
															$total_price = ($a['1st_adult']+$a['2nd_adult']+$a['1_children']+$a['2_children']+$a['3_children']+$a['4_children']+$a['family_pack']+$a['children_pack']+$a['ass_cie_family']+$a['ass_cie_indiv']+$a['ass_poema']);
													
															$fees = ($a['adh_cie_fee']+$a['adh_poema_fee']);
													
															$total_grand = $total_price;
															
															if($a['discount'] != 0){
																$total_grand = $total_price - ($total_price * ($a['discount']/100));
																$total_grand = $total_grand + $fees + $additional;
																echo '</td>
															<td class="text-right"><s class="red">'.number_format($total_price+$fees).'</s><br /> <strong>'.number_format($total_grand,2).' '.$quote['currency'].'</strong></td>';
															}else{
																$total_grand = $total_grand + $fees +$additional;
																echo '</td>
															<td class="text-right"><strong>'.number_format($total_grand,2).' '.$quote['currency'].'</strong></td>';
															}
															
														echo '</tr>';
													$i++;
												}
											}
										?>
                                    </tbody>
                                </table>
                            </div>
							</div>
                            <!-- /.table-responsive -->
  
                        <!-- /.panel-body -->
				</div>
                
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include("footer.php"); ?>