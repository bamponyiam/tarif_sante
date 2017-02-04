<?php

session_start();
require_once("classes/User.php");
$user = User::getInstance();

require_once("classes/PDF.php");
$pdf = PDF::getInstance();

require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

require_once("classes/Product.php");
$product = Product::getInstance();

require_once("classes/Currency.php");
$currency = Currency::getInstance();

$quote = $quotation->getQuotationById($_GET['id_quote']);
$search = $quotation->getSearchByQuote($_GET['id_quote']);

$u = $user->getUserById($_SESSION['login']);


$content = file_get_contents("template/template_quote_global_en_alex_family.html");

$content = str_replace("%quote_no%", $quote['reference'].''.$quote['id_quote'], $content);
$content = str_replace("%year_effective%", date('Y'), $content);


$app = $applicant->getApplicantByQuote($quote['id_quote']);


$i=1;
$insured = "";


$content = str_replace("%type%", 'FAMILY', $content);

if($quote['profession'] == ""){
	$content = str_replace("%profession%", 'TBA', $content);
}else{
	$content = str_replace("%profession%", $quote['profession'], $content);
}
$content = str_replace("%nom%",strtoupper($app[0]['lastname']).' '.ucfirst($app[0]['firstname']), $content);
$content = str_replace("%nationality%", $app[0]['nationality'], $content);

if($app[0]['date_of_birth'] != ""){
	$content = str_replace("%1st_dob%", '('.$app[0]['date_of_birth'].') - '.$app[0]['age'].' years old', $content);
}else{
	$content = str_replace("%1st_dob%", $app[0]['age'].' years old', $content);
}

if($app[1]['type_applicant'] == "2ND"){
	$i++;
	if($app[1]['date_of_birth'] != ""){
		$content = str_replace("%2nd_dob%", '('.$app[1]['date_of_birth'].') - '.$app[1]['age'].' years old', $content);
	}else{
			$content = str_replace("%2nd_dob%", $app[1]['age'].' years old', $content);
	}
}else{
	$content = str_replace("%2nd_dob%", "NON", $content);
}

$nb_children = sizeof($app)-$i;

if($nb_children == 0){
	$content = str_replace("%nb_children%", "NON", $content);
}else{
	$content = str_replace("%nb_children%", sizeof($app)-$i, $content);
}

$content = str_replace("%pax%", sizeof($app).' Pax', $content);
	

$content = str_replace("%email_client%", $quote['email'], $content);
$content = str_replace("%tel_client%", $quote['tel'], $content);
$content = str_replace("%residence%", $quote['country'], $content);
$content = str_replace("%date_create%", date('d/m/Y'), $content);

$content = str_replace("%reference%", $u['id_user'], $content);
$content = str_replace("%by%", ucfirst($u['firstname']).' '.strtoupper($u['lastname']), $content);
$content = str_replace("%email_by%", $u['email'], $content);
$content = str_replace("%valid_until%", date('d/m/Y', strtotime("+1 month")), $content);





$all_1 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M1');
$all_2 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M2');
$all_3 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M3');

$module_1 = "";


$indication = "<ul>";

if(sizeof($all_1) > 0){
	
	$module_1 = "<h3 style='text-align:center;'> OFFER'S SUMMARY </h3>";

	$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 1 / Basic coverage</strong>: insurance plans covering only inpatient expenses (hospitalizations & surgeries). </li><br />';
	if(sizeof($all_2) > 0){
		$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 2 / Extensive coverage</strong>: insurance plans covering inpatient expenses + outpatient expenses (routine medical care, such as: doctor’s consultations, pharmacy, investigations, laboratory).</li><br />';
		$module_1 = "<h3 style='text-align:center;'>OFFER'S SUMMARY</h3>";
		if(sizeof($all_3) > 0){
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 3 / Comprehensive plans</strong>: insurance plans covering inpatient and outpatient expenses + dental care and/or vision care and/or maternity.</li><br />';
		}
	}else{
		if(sizeof($all_3) > 0){
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 2 / Extensive coverage</strong>: insurance plans covering inpatient expenses + outpatient expenses (routine medical care, such as: doctor’s consultations, pharmacy, investigations, laboratory).</li>';
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 3 / Comprehensive plans</strong>: insurance plans covering inpatient and outpatient expenses + dental care and/or vision care and/or maternity.</li>';
			$module_1 = "<h3 style='text-align:center;'>OFFER'S SUMMARY</h3>";
		}
		
	}
}else{
	$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 1 / Basic coverage</strong>: insurance plans covering only inpatient expenses (hospitalizations & surgeries). </li>';
	$module_1 = "<h3 style='text-align:center;'>OFFER'S SUMMARY</h3>";
	if(sizeof($all_2) > 0){
		$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 2 / Extensive coverage</strong>: insurance plans covering inpatient expenses + outpatient expenses (routine medical care, such as: doctor’s consultations, pharmacy, investigations, laboratory).</li>';
		if(sizeof($all_3) > 0){
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 3 / Comprehensive plans</strong>: insurance plans covering inpatient and outpatient expenses + dental care and/or vision care and/or maternity.</li>';
			$module_1 = "<h3 style='text-align:center;'>OFFER'S SUMMARY</h3>";
		}
	}else{
		if(sizeof($all_3) > 0){
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 2 / Extensive coverage</strong>: insurance plans covering inpatient expenses + outpatient expenses (routine medical care, such as: doctor’s consultations, pharmacy, investigations, laboratory).</li>';
			$indication .= '<li style="line-height:25px;padding-top:5px;"><strong>Module 3 / Comprehensive plans</strong>: insurance plans covering inpatient and outpatient expenses + dental care and/or vision care and/or maternity.</li>';
		}
	}
}

$indication .= '</ul>';



$module_1 .= "<h5 style='text-align:center;'>(Premiums are annual, in %currency%)</h5>";

if(sizeof($all_1) > 0){
	$module_1 .= "<h5 style='text-align:center;'>MODULE 1</h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Insurance Plan</td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	
	if($app[0]['date_of_birth'] != ""){
		$a = explode("/",$app[0]['date_of_birth']);
		$dob= $a[2].'-'.$a[1].'-'.$a[0];

		$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

		$from = new DateTime($dob);
		$to   = new DateTime('today');

		$age_ca = $from->diff($to)->y;
		
		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_1st%';
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
		}
	}else{
		$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
	}
	
	$module_1 .= '</tr>';
	$age_1st = "";
	
	if($app[1]['type_applicant'] == "2ND"){
		$age_2nd = "";
		$module_1 .= '<tr>';
		
		if($app[1]['date_of_birth'] != ""){
			$a = explode("/",$app[1]['date_of_birth']);
			$dob= $a[2].'-'.$a[1].'-'.$a[0];

			$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

			$from = new DateTime($dob);
			$to   = new DateTime('today');

			$age_ca = $from->diff($to)->y;

			if( $age_cy != $age_ca){
				$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_2nd%';
			}else{
				$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
			}
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
		}
		$module_1 .= '</tr>';
	}
	
	if($nb_children > 0){
		if(isset($age_2nd)){
			
			$module_1 .= '<tr>';
			
			if($app[2]['date_of_birth'] != ""){
				$a = explode("/",$app[2]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';

				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[5]['age'])){
				$module_1 .= '<tr>';

				if($app[5]['date_of_birth'] != ""){
					$a = explode("/",$app[5]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
				}
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}else{
			$module_1 .= '<tr>';
			
			if($app[1]['date_of_birth'] != ""){
				$a = explode("/",$app[1]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[2]['age'])){
				$module_1 .= '<tr>';

				if($app[2]['date_of_birth'] != ""){
					$a = explode("/",$app[2]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';
				
				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
				}
				
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}
		
	}
	

	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation Family.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Family Discount (If any)</td>%discount%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Additional fees</td>%additional%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr style="font-weight:bold">';
	$module_1 .= '<td width="15%"><strong>TOTAL</strong></td>%total%';
	$module_1 .= '</tr>';
	
	$module_1 .= '</thead>';
	$module_1 .= '</table>';
	$module_1 .= '<br /><ul style="font-size:9px;font-weight:normal">%note%</ul>';
	
	$title = "";
	$assistance = "";
	$adhesion = "";
	$additional = "";
	$total = "";
	$note = "";
	$discount = "";
	$family_pack_active = 0;
	$children_pack_active = 0;
	
	foreach($all_1 as $select){
		$pro = $product->getProductByLevel($select['id_level']);
		$lev = $product->getLevelById($select['id_level']);

		$rate = 1;
		if($pro['currency'] != $quote['currency']){
			$curr = $currency->getCurrenyById($pro['currency']);
			$rate = $curr['rate'];
		}
		
		if($select['garanty'] != 0){
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		
		if($select['family_pack'] != 0){
			$family_pack_active = 1;
			$age_1st .= '<td style="text-align:center;">'.number_format($select['family_pack']).'</td>';
		}else{
			$age_1st .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		}
		
		if(isset($age_2nd)){
			if($family_pack_active == 1){
				$age_2nd .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				$age_2nd .= '<td style="text-align:center;">'.number_format($select['2nd_adult']).'</td>';
			}
		}
		
		if(isset($child1)){
			if($family_pack_active == 1){
				$child1 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['1_children'] == 0){
						$children_pack_active = 1;
						$child1 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
					}else{
						$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
					}
				}else{
					$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
				}
			}	
		}
		if(isset($child2)){
			if($family_pack_active == 1){
				$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['2_children'] == 0){
						if(isset($children_pack_active)){
							$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child2 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
					}
				}else{
					$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
				}
			}
		}
		if(isset($child3)){
			if($family_pack_active == 1){
				$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['3_children'] == 0){
						if(isset($children_pack_active)){
							$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child3 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
					}
				}else{
					$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
				}
			}
		}
		
		if(isset($child4)){
			if($family_pack_active == 1){
				$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['4_children'] == 0){
						if(isset($children_pack_active)){
							$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child4 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
					}
				}else{
					$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
				}
			}
		}

		
		if(($select['ass_cie_family']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">INCLUDED</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_family']+$select['ass_poema']).'</td>';
		}
		
		$adhesion .= '<td style="text-align:center;">'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']).'</td>';
		
		$all_field = $quotation->getAdditionalFieldByIdPremiumSelected($select['id_premium_selected']);
		$additional_val = 0;
		if(sizeof($all_field) > 0){
			$additional .= '<td>';
			foreach($all_field as $a1){
				$additional .= $a1['name_field'].' : '.$a1['value_field'].'<br />';
				$additional_val = $additional_val + $a1['value_field'];
			}
			$additional .= '</td>';
		}else{
			$additional .= '<td></td>';
		}
		
		
		if($select['discount'] != 0){
			$discount .= '<td style="text-align:center;">'.$select['discount'].'%</td>';
		}else{
			$discount .= '<td style="text-align:center;"></td>';
		}
		
		$normal_total = ($select['1st_adult']+$select['2nd_adult']+$select['1_children']+$select['2_children']+$select['3_children']+$select['4_children']+$select['family_pack']+$select['children_pack']+$select['ass_cie_family']+$select['ass_poema']);
		
		$fees = ($select['adh_cie_fee']+$select['adh_poema_fee']);
		
		if($select['discount'] != 0){
			$total_grand = $normal_total - ($normal_total * ($select['discount']/100));
			$total_grand = $total_grand + $fees + $additional_val;
		}else{
			$total_grand = $normal_total + $fees + $additional_val;
		}
		
		if($select['discount'] != 0){
			$total .= '<td style="text-align:center;"><s>'.number_format($normal_total+$fees+$additional_val).'</s> <strong>'.number_format($total_grand).'</strong></strong></td>';
		}else{
			$total .= '<td style="text-align:center;"><strong>'.number_format($total_grand).'</strong></strong></td>';
		}
		
		if($select['note_en'] != ""){
			
			$n = explode('<br />',$select['note_en']);
			$note .= '<li>'.$select['name_plan'].' - ';
			$i = 1;
			foreach($n as $notee){
				if($i == sizeof($n)){
					$note .= $notee;
				}else{
					$note .= $notee. ' - ';
				}

				$i++;
			}
			$note .= '</li>';
		}
	}
	
	$module_1 = str_replace("%title%", $title, $module_1);
	$module_1 = str_replace("%age_1st%", $age_1st, $module_1);
	
	if(isset($age_2nd)){
		$module_1 = str_replace("%age_2nd%", $age_2nd, $module_1);
	}
	if(isset($child1)){
		$module_1 = str_replace("%child1%", $child1, $module_1);
	}
	if(isset($child2)){
		$module_1 = str_replace("%child2%", $child2, $module_1);
	}
	if(isset($child3)){
		$module_1 = str_replace("%child3%", $child3, $module_1);
	}
	if(isset($child4)){
		$module_1 = str_replace("%child4%", $child4, $module_1);
	}
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%discount%", $discount, $module_1);
	$module_1 = str_replace("%note%", $note.'<br />', $module_1);
	
}



if(sizeof($all_2) > 0){
	$module_1 .= "<h5 style='text-align:center;'>MODULE 2</h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Insurance Plan</td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	
	if($app[0]['date_of_birth'] != ""){
		$a = explode("/",$app[0]['date_of_birth']);
		$dob= $a[2].'-'.$a[1].'-'.$a[0];


		$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

		$from = new DateTime($dob);
		$to   = new DateTime('today');

		$age_ca = $from->diff($to)->y;
		
		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_1st%';
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
		}
	}else{
		$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
	}
	
	$module_1 .= '</tr>';
	$age_1st = "";
	
	if($app[1]['type_applicant'] == "2ND"){
		$age_2nd = "";
		$module_1 .= '<tr>';
		
		if($app[1]['date_of_birth'] != ""){
			$a = explode("/",$app[1]['date_of_birth']);
			$dob= $a[2].'-'.$a[1].'-'.$a[0];

			$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

			$from = new DateTime($dob);
			$to   = new DateTime('today');

			$age_ca = $from->diff($to)->y;

			if( $age_cy != $age_ca){
				$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_2nd%';
			}else{
				$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
			}
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
		}
		$module_1 .= '</tr>';
	}
	
	if($nb_children > 0){
		if(isset($age_2nd)){
			
			$module_1 .= '<tr>';
			
			if($app[2]['date_of_birth'] != ""){
				$a = explode("/",$app[2]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';

				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[5]['age'])){
				$module_1 .= '<tr>';

				if($app[5]['date_of_birth'] != ""){
					$a = explode("/",$app[5]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
				}
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}else{
			$module_1 .= '<tr>';
			
			if($app[1]['date_of_birth'] != ""){
				$a = explode("/",$app[1]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[2]['age'])){
				$module_1 .= '<tr>';

				if($app[2]['date_of_birth'] != ""){
					$a = explode("/",$app[2]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';
				
				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
				}
				
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}
		
	}
	

	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation Family.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Family Discount (If any)</td>%discount%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Additional fees</td>%additional%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr style="font-weight:bold">';
	$module_1 .= '<td width="15%"><strong>TOTAL</strong></td>%total%';
	$module_1 .= '</tr>';
	
	$module_1 .= '</thead>';
	$module_1 .= '</table>';
	$module_1 .= '<br /><ul style="font-size:9px;font-weight:normal">%note%</ul>';
	
	$title = "";
	$assistance = "";
	$adhesion = "";
	$additional = "";
	$total = "";
	$note = "";
	$discount = "";
	$family_pack_active = 0;
	$children_pack_active = 0;
	
	foreach($all_2 as $select){
		$pro = $product->getProductByLevel($select['id_level']);
		$lev = $product->getLevelById($select['id_level']);

		$rate = 1;
		if($pro['currency'] != $quote['currency']){
			$curr = $currency->getCurrenyById($pro['currency']);
			$rate = $curr['rate'];
		}
		
		if($select['garanty'] != 0){
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		
		if($select['family_pack'] != 0){
			$family_pack_active = 1;
			$age_1st .= '<td style="text-align:center;">'.number_format($select['family_pack']).'</td>';
		}else{
			$age_1st .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		}
		
		if(isset($age_2nd)){
			if($family_pack_active == 1){
				$age_2nd .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				$age_2nd .= '<td style="text-align:center;">'.number_format($select['2nd_adult']).'</td>';
			}
		}
		
		if(isset($child1)){
			if($family_pack_active == 1){
				$child1 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['1_children'] == 0){
						$children_pack_active = 1;
						$child1 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
					}else{
						$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
					}
				}else{
					$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
				}
			}	
		}
		if(isset($child2)){
			if($family_pack_active == 1){
				$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['2_children'] == 0){
						if(isset($children_pack_active)){
							$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child2 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
					}
				}else{
					$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
				}
			}
		}
		if(isset($child3)){
			if($family_pack_active == 1){
				$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['3_children'] == 0){
						if(isset($children_pack_active)){
							$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child3 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
					}
				}else{
					$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
				}
			}
		}
		
		if(isset($child4)){
			if($family_pack_active == 1){
				$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['4_children'] == 0){
						if(isset($children_pack_active)){
							$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child4 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
					}
				}else{
					$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
				}
			}
		}

		
		if(($select['ass_cie_family']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">INCLUDED</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_family']+$select['ass_poema']).'</td>';
		}
		
		$adhesion .= '<td style="text-align:center;">'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']).'</td>';
		
		$all_field = $quotation->getAdditionalFieldByIdPremiumSelected($select['id_premium_selected']);
		$additional_val = 0;
		if(sizeof($all_field) > 0){
			$additional .= '<td>';
			foreach($all_field as $a1){
				$additional .= $a1['name_field'].' : '.$a1['value_field'].'<br />';
				$additional_val = $additional_val + $a1['value_field'];
			}
			$additional .= '</td>';
		}else{
			$additional .= '<td></td>';
		}
		
		if($select['discount'] != 0){
			$discount .= '<td style="text-align:center;">'.$select['discount'].'%</td>';
		}else{
			$discount .= '<td style="text-align:center;"></td>';
		}
		
		$normal_total = ($select['1st_adult']+$select['2nd_adult']+$select['1_children']+$select['2_children']+$select['3_children']+$select['4_children']+$select['family_pack']+$select['children_pack']+$select['ass_cie_family']+$select['ass_poema']);
		
		$fees = ($select['adh_cie_fee']+$select['adh_poema_fee']);
		
		if($select['discount'] != 0){
			$total_grand = $normal_total - ($normal_total * ($select['discount']/100));
			$total_grand = $total_grand + $fees + $additional_val;
		}else{
			$total_grand = $normal_total + $fees + $additional_val;
		}
		
		if($select['discount'] != 0){
			$total .= '<td style="text-align:center;"><s>'.number_format($normal_total+$fees+$additional_val).'</s> <strong>'.number_format($total_grand).'</strong></strong></td>';
		}else{
			$total .= '<td style="text-align:center;"><strong>'.number_format($total_grand).'</strong></strong></td>';
		}
		
		if($select['note_en'] != ""){
			
			$n = explode('<br />',$select['note_en']);
			$note .= '<li>'.$select['name_plan'].' - ';
			$i = 1;
			foreach($n as $notee){
				if($i == sizeof($n)){
					$note .= $notee;
				}else{
					$note .= $notee. ' - ';
				}

				$i++;
			}
			$note .= '</li>';
		}
	}
	
	$module_1 = str_replace("%title%", $title, $module_1);
	$module_1 = str_replace("%age_1st%", $age_1st, $module_1);
	
	if(isset($age_2nd)){
		$module_1 = str_replace("%age_2nd%", $age_2nd, $module_1);
	}
	if(isset($child1)){
		$module_1 = str_replace("%child1%", $child1, $module_1);
	}
	if(isset($child2)){
		$module_1 = str_replace("%child2%", $child2, $module_1);
	}
	if(isset($child3)){
		$module_1 = str_replace("%child3%", $child3, $module_1);
	}
	if(isset($child4)){
		$module_1 = str_replace("%child4%", $child4, $module_1);
	}
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%discount%", $discount, $module_1);
	$module_1 = str_replace("%note%", $note.'<br />', $module_1);
	
}


if(sizeof($all_3) > 0){
	$module_1 .= "<h5 style='text-align:center;'>MODULE 3</h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Insurance Plan</td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	
	if($app[0]['date_of_birth'] != ""){
		$a = explode("/",$app[0]['date_of_birth']);
		$dob= $a[2].'-'.$a[1].'-'.$a[0];

		$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

		$from = new DateTime($dob);
		$to   = new DateTime('today');

		$age_ca = $from->diff($to)->y;
		
		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_1st%';
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
		}
	}else{
		$module_1 .= '<td width="15%">Pax '.$app[0]['age'].' years old</td>%age_1st%';
	}
	
	$module_1 .= '</tr>';
	$age_1st = "";
	
	if($app[1]['type_applicant'] == "2ND"){
		$age_2nd = "";
		$module_1 .= '<tr>';
		
		if($app[1]['date_of_birth'] != ""){
			$a = explode("/",$app[1]['date_of_birth']);
			$dob= $a[2].'-'.$a[1].'-'.$a[0];

			$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

			$from = new DateTime($dob);
			$to   = new DateTime('today');

			$age_ca = $from->diff($to)->y;

			if( $age_cy != $age_ca){
				$module_1 .= '<td width="15%">Pax '.$age_ca.' - '.$age_cy.' years old</td>%age_2nd%';
			}else{
				$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
			}
		}else{
			$module_1 .= '<td width="15%">Pax '.$app[1]['age'].' years old</td>%age_2nd%';
		}
		$module_1 .= '</tr>';
	}
	
	if($nb_children > 0){
		if(isset($age_2nd)){
			
			$module_1 .= '<tr>';
			
			if($app[2]['date_of_birth'] != ""){
				$a = explode("/",$app[2]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';

				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[5]['age'])){
				$module_1 .= '<tr>';

				if($app[5]['date_of_birth'] != ""){
					$a = explode("/",$app[5]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[5]['age'].' years old</td>%child4%';
				}
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}else{
			$module_1 .= '<tr>';
			
			if($app[1]['date_of_birth'] != ""){
				$a = explode("/",$app[1]['date_of_birth']);
				$dob= $a[2].'-'.$a[1].'-'.$a[0];

				$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

				$from = new DateTime($dob);
				$to   = new DateTime('today');

				$age_ca = $from->diff($to)->y;

				if( $age_cy != $age_ca){
					$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child1%';
				}else{
					$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
				}
			}else{
				$module_1 .= '<td width="15%">Child '.$app[1]['age'].' years old</td>%child1%';
			}
			
			$module_1 .= '</tr>';
			$child1 = "";
			
			if(isset($app[2]['age'])){
				$module_1 .= '<tr>';

				if($app[2]['date_of_birth'] != ""){
					$a = explode("/",$app[2]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child2%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[2]['age'].' years old</td>%child2%';
				}
				
				$module_1 .= '</tr>';
				$child2 = "";
			}
			if(isset($app[3]['age'])){
				$module_1 .= '<tr>';
				
				if($app[3]['date_of_birth'] != ""){
					$a = explode("/",$app[3]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child3%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[3]['age'].' years old</td>%child3%';
				}
				
				$module_1 .= '</tr>';
				$child3 = "";
			}
			
			if(isset($app[4]['age'])){
				$module_1 .= '<tr>';
				
				if($app[4]['date_of_birth'] != ""){
					$a = explode("/",$app[4]['date_of_birth']);
					$dob= $a[2].'-'.$a[1].'-'.$a[0];

					$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

					$from = new DateTime($dob);
					$to   = new DateTime('today');

					$age_ca = $from->diff($to)->y;

					if( $age_cy != $age_ca){
						$module_1 .= '<td width="15%">Child '.$age_ca.' - '.$age_cy.' years old</td>%child4%';
					}else{
						$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
					}
				}else{
					$module_1 .= '<td width="15%">Child '.$app[4]['age'].' years old</td>%child4%';
				}
				
				$module_1 .= '</tr>';
				$child4 = "";
			}
		}
		
	}
	

	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation Family.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Family Discount (If any)</td>%discount%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Additional fees</td>%additional%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr style="font-weight:bold">';
	$module_1 .= '<td width="15%"><strong>TOTAL</strong></td>%total%';
	$module_1 .= '</tr>';
	
	$module_1 .= '</thead>';
	$module_1 .= '</table>';
	$module_1 .= '<br /><ul style="font-size:9px;font-weight:normal">%note%</ul>';
	
	$title = "";
	$age = "";
	$assistance = "";
	$adhesion = "";
	$additional = "";
	$total = "";
	$note = "";
	$discount = "";
	$family_pack_active = 0;
	$children_pack_active = 0;
	
	foreach($all_3 as $select){
		$pro = $product->getProductByLevel($select['id_level']);
		$lev = $product->getLevelById($select['id_level']);

		$rate = 1;
		if($pro['currency'] != $quote['currency']){
			$curr = $currency->getCurrenyById($pro['currency']);
			$rate = $curr['rate'];
		}
		
		if($select['garanty'] != 0){
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Deductible : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		
		if($select['family_pack'] != 0){
			$family_pack_active = 1;
			$age_1st .= '<td style="text-align:center;">'.number_format($select['family_pack']).'</td>';
		}else{
			$age_1st .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		}
		
		if(isset($age_2nd)){
			if($family_pack_active == 1){
				$age_2nd .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				$age_2nd .= '<td style="text-align:center;">'.number_format($select['2nd_adult']).'</td>';
			}
		}
		
		if(isset($child1)){
			if($family_pack_active == 1){
				$child1 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['1_children'] == 0){
						$children_pack_active = 1;
						$child1 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
					}else{
						$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
					}
				}else{
					$child1 .= '<td style="text-align:center;">'.number_format($select['1_children']).'</td>';
				}
			}	
		}
		if(isset($child2)){
			if($family_pack_active == 1){
				$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['2_children'] == 0){
						if(isset($children_pack_active)){
							$child2 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child2 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
					}
				}else{
					$child2 .= '<td style="text-align:center;">'.number_format($select['2_children']).'</td>';
				}
			}
		}
		if(isset($child3)){
			if($family_pack_active == 1){
				$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['3_children'] == 0){
						if(isset($children_pack_active)){
							$child3 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child3 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
					}
				}else{
					$child3 .= '<td style="text-align:center;">'.number_format($select['3_children']).'</td>';
				}
			}
		}
		
		if(isset($child4)){
			if($family_pack_active == 1){
				$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
			}else{
				if($select['children_pack'] != 0){
					if($select['4_children'] == 0){
						if(isset($children_pack_active)){
							$child4 .= '<td style="text-align:center;">Included Family Plan</td>';
						}else{
							$children_pack_active = 1;
							$child4 .= '<td style="text-align:center;">'.number_format($select['children_pack']).'</td>';
						}
					}else{
						$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
					}
				}else{
					$child4 .= '<td style="text-align:center;">'.number_format($select['4_children']).'</td>';
				}
			}
		}


		
		if(($select['ass_cie_family']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">INCLUDED</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_family']+$select['ass_poema']).'</td>';
		}
		
		$adhesion .= '<td style="text-align:center;">'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']).'</td>';
		
		$all_field = $quotation->getAdditionalFieldByIdPremiumSelected($select['id_premium_selected']);
		$additional_val = 0;
		if(sizeof($all_field) > 0){
			$additional .= '<td>';
			foreach($all_field as $a1){
				$additional .= $a1['name_field'].' : '.$a1['value_field'].'<br />';
				$additional_val = $additional_val + $a1['value_field'];
			}
			$additional .= '</td>';
		}else{
			$additional .= '<td></td>';
		}
		
		
		if($select['discount'] != 0){
			$discount .= '<td style="text-align:center;">'.$select['discount'].'%</td>';
		}else{
			$discount .= '<td style="text-align:center;"></td>';
		}
		
		$normal_total = ($select['1st_adult']+$select['2nd_adult']+$select['1_children']+$select['2_children']+$select['3_children']+$select['4_children']+$select['family_pack']+$select['children_pack']+$select['ass_cie_family']+$select['ass_poema']);
		
		$fees = ($select['adh_cie_fee']+$select['adh_poema_fee']);
		
		if($select['discount'] != 0){
			$total_grand = $normal_total - ($normal_total * ($select['discount']/100));
			$total_grand = $total_grand + $fees + $additional_val;
		}else{
			$total_grand = $normal_total + $fees + $additional_val;
		}
		
		if($select['discount'] != 0){
			$total .= '<td style="text-align:center;"><s>'.number_format($normal_total+$fees+$additional_val).'</s> <strong>'.number_format($total_grand).'</strong></strong></td>';
		}else{
			$total .= '<td style="text-align:center;"><strong>'.number_format($total_grand).'</strong></strong></td>';
		}
		
		if($select['note_en'] != ""){
			
			$n = explode('<br />',$select['note_en']);
			$note .= '<li>'.$select['name_plan'].' - ';
			$i = 1;
			foreach($n as $notee){
				if($i == sizeof($n)){
					$note .= $notee;
				}else{
					$note .= $notee. ' - ';
				}

				$i++;
			}
			$note .= '</li>';
		}
	}
	
	$module_1 = str_replace("%title%", $title, $module_1);
	$module_1 = str_replace("%age_1st%", $age_1st, $module_1);
	
	if(isset($age_2nd)){
		$module_1 = str_replace("%age_2nd%", $age_2nd, $module_1);
	}
	if(isset($child1)){
		$module_1 = str_replace("%child1%", $child1, $module_1);
	}
	if(isset($child2)){
		$module_1 = str_replace("%child2%", $child2, $module_1);
	}
	if(isset($child3)){
		$module_1 = str_replace("%child3%", $child3, $module_1);
	}
	if(isset($child4)){
		$module_1 = str_replace("%child4%", $child4, $module_1);
	}
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%discount%", $discount, $module_1);
	$module_1 = str_replace("%note%", $note.'<br />', $module_1);
	
}

$content = str_replace("%module_details%", $module_1, $content);
$content = str_replace("%currency%", $quote['currency'], $content);
$content = str_replace("%indications%", $indication, $content);
//echo $content;


$file_name = $app[0]['lastname'].'_'.$quote['reference'].''.$quote['id_quote'].'.pdf';

$head = '<table>';
$head .= '<tr>';

$head .= '<td style="width:400px;">';
$head .= '<img src="http://sante-expatrie-asie.com/asia/head.png" style="width:200px;"/>';
$head .= '</td>';

$head .= '<td>';
$head .= '<h3>PERSONAL HEALTH INSURANCE</h3>';
$head .= '<p>Quotation reference : <strong>'.$quote['reference'].''.$quote['id_quote'].'</strong></p>';
$head .= '</td>';

$head .= '</tr>';
$head .= '</table>';

if($u['office'] == 'MMR'){
	$foot = '<hr style="margin-bottom:0px;" />';
	$foot .= '<div style="text-align:center">';
	$foot .= '<h5>Poe-ma insurances (Myanmar Representative Office)</h5>';
	$foot .= '<p style="font-size:10px;">No 3/89, Gant Gaw Myaing Street, Parami, Yankin Township <br />
	11081 Yangon, Republic of the Union Myanmar <br />
	Email: '.$u['email'].' | Web: www.poema-insurances.com
	</p>';
	$foot .= '</div>';
}
if($u['office'] == 'KHM'){
	$foot = '<hr style="margin-bottom:0px;" />';
	$foot .= '<div style="text-align:center">';
	$foot .= '<h5>Poe-ma insurances Cambodia</h5>';
	$foot .= '<p style="font-size:10px;">#59 I, Street 13,SangkatPsarKandal I<br />
	Khan Daun Penh, Phnom Penh Cambodia<br />
	Email: '.$u['email'].' | Web: www.poema-insurances.com
	</p>';
	$foot .= '</div>';
}

if($u['office'] == 'THA'){
	$foot = '<hr style="margin-bottom:0px;" />';
	$foot .= '<div style="text-align:center">';
	$foot .= '<h5>Poe-ma thai insurances brokers Co.,Ltd</h5>';
	$foot .= '<p style="font-size:10px;">48/11 Moo 9, Sunrise Road, T. Chalong,<br />
	A. Muang  83000 Phuket Thailand<br />
	Email: '.$u['email'].' | Web: www.poema-insurances.com
	</p>';
	$foot .= '</div>';
}


$pdf->CreatePDFHeadFoot($content,$file_name,'D',$head,$foot);

?>