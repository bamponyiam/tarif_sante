<?php
session_start();
require_once("classes/PDF.php");
$pdf = PDF::getInstance();

require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

require_once("classes/Product.php");
$product = Product::getInstance();

require_once("classes/User.php");
$user = User::getInstance();
$u = $user->getUserById($_SESSION['login']);

$quote = $quotation->getQuotationById($_GET['id_quote']);
$price = $quotation->getSelectedPremiumById($_GET['id_price']);

if($price['id_premium'] != 0){
	$level = $product->getLevelByPremium($price['id_premium']);
}else{
	$level = $product->getLevelById($price['id_level']);
}

$pro = $product->getProductById($level['id_product']);


$content = file_get_contents("template/template_quote.html");

$content = str_replace("%date%", date('d/m/Y'), $content);
$content = str_replace("%quote_no%", $quote['reference'].''.$quote['id_quote'], $content);


if($u['office'] == 'THA'){
	$content = str_replace("%company%", "<strong>Poe-ma thai insurances brokers Co.,Ltd</strong><br />48/11 Moo 9, Sunrise Road, T. Chalong,<br />A. Muang  83000 Phuket Thailand ", $content);
	$content = str_replace("%city%", "Bangkok", $content);
}
if($u['office'] == 'MMR'){
	$content = str_replace("%company%", "<strong>Poe-ma insurances</strong><br />No 3/89, Gant Gaw Myaing Street, Parami,<br /> Yankin Township 11081 Yangon, <br />Republic of the Union Myanmar", $content);
	$content = str_replace("%city%", "Yangon", $content);
}
if($u['office'] == 'KHM'){
	$content = str_replace("%company%", "<strong>Poe-ma insurances Cambodia</strong><br />#59 I, Street 13,SangkatPsarKandal I<br />Khan Daun Penh, Phnom Penh Cambodia", $content);
	$content = str_replace("%city%", "Phnom Penh", $content);
}

$plan = $level['name_plan'].' ('.$level['name_level'].' , ';

if($level['lifetime_option'] == "LT"){
	$plan .= 'Lifetime';
}else{
	$plan .= 'Non Lifetime';
}
$plan .= ' , ';
if($level['marine'] == 1){
	$plan .= 'Marine';
}else{
	$plan .= 'Non Marine';
}

$plan .= ')';

$content = str_replace("%plan%",$plan , $content);
$content = str_replace("%type_con%", $quote['type_con'], $content);

$app = $applicant->getApplicantByQuote($quote['id_quote']);
$i=1;
$insured = "";
$dest = "";


if($quote['type_con'] == "INDIV"){
	$insured .= '<tr>';
	$insured .= '<td>1</td>';
	$insured .= '<td>'.$app[0]['firstname'].'</td>';
	$insured .= '<td>'.$app[0]['lastname'].'</td>';
	$insured .= '<td>'.$app[0]['age'].'</td>';
	$insured .= '<td>'.$app[0]['sex'].'</td>';
	$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1st_adult'],2).'</td>';
	$insured .= '</tr>';
	
	$dest .= '<i><strong>'.$app[0]['firstname'].' '.$app[0]['lastname'].'</strong></i><br />';
}else{
	$i=1;
	if($price['family_pack'] != 0){
		
		foreach($app as $a){
			$insured .= '<tr>';
			$insured .= '<td>'.$i.'</td>';
			$insured .= '<td>'.$a['firstname'].'</td>';
			$insured .= '<td>'.$a['lastname'].'</td>';
			$insured .= '<td>'.$a['age'].'</td>';
			$insured .= '<td>'.$a['sex'].'</td>';
			$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format(0,2).'</td>';
			$insured .= '</tr>';
			
			if($i==1){
				$dest .= '<i><strong>'.$a['firstname'].' '.$a['lastname'].'</strong></i><br />';
			}
			$i++;
			
		}
		$insured .= '<tr>';
		$insured .= '<td colspan="5" style="text-align: right;padding-right: 10px;">Family Pack</td>';
		$insured .= '<td style="text-align: right;padding-right: 10px;">'.number_format($price['family_pack'],2).'</td>';
		$insured .= '</tr>';
	}else{
		$insured .= '<tr>';
		$insured .= '<td>'.$i.'</td>';
		$insured .= '<td>'.$app[0]['firstname'].'</td>';
		$insured .= '<td>'.$app[0]['lastname'].'</td>';
		$insured .= '<td>'.$app[0]['age'].'</td>';
		$insured .= '<td>'.$app[0]['sex'].'</td>';
		$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1st_adult'],2).'</td>';
		$insured .= '</tr>';
		$dest .= $app[0]['firstname'].' '.$app[0]['lastname'].'<br />';
		$i++;
		
		if($price['2nd_adult'] != 0){
			$insured .= '<tr>';
			$insured .= '<td>'.$i.'</td>';
			
			if($app[1]['firstname'] != ""){
				$insured .= '<td>'.$app[1]['firstname'].'</td>';
			}else{
				$insured .= '<td>Pax 2 </td>';
			}
			
			$insured .= '<td>'.$app[1]['lastname'].'</td>';
			$insured .= '<td>'.$app[1]['age'].'</td>';
			$insured .= '<td>'.$app[1]['sex'].'</td>';
			$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['2nd_adult'],2).'</td>';
			$insured .= '</tr>';
			$i++;
		}
		
		if($price['children_pack'] != 0){
			$k=1;
			foreach($app as $a){
				if($a['type_applicant'] == '1CHILD'){
					if($a['age'] <= 18){
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 1  </td>';
						}
						
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format(0,2).'</td>';
						$insured .= '</tr>';
					}else{
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 1  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price[''.$k.'_children'],2).'</td>';
						$insured .= '</tr>';
						$k++;
					}
					$i++;
				}
				if($a['type_applicant'] == '2CHILD'){
					if($a['age'] <= 18){
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 2  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format(0,2).'</td>';
						$insured .= '</tr>';
					}else{
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 2  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price[''.$k.'_children'],2).'</td>';
						$insured .= '</tr>';
						$k++;
					}
					$i++;
				}
				
				if($a['type_applicant'] == '3CHILD'){
					if($a['age'] <= 18){
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 3  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format(0,2).'</td>';
						$insured .= '</tr>';
					}else{
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 3  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price[''.$k.'_children'],2).'</td>';
						$insured .= '</tr>';
						$k++;
					}
					$i++;
				}
				
				if($a['type_applicant'] == '4CHILD'){
					if($a['age'] <= 18){
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 4  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format(0,2).'</td>';
						$insured .= '</tr>';
					}else{
						$insured .= '<tr>';
						$insured .= '<td>'.$i.'</td>';
						if($a['firstname'] != ""){
							$insured .= '<td>'.$a['firstname'].'</td>';
						}else{
							$insured .= '<td>Child 4  </td>';
						}
						$insured .= '<td>'.$a['lastname'].'</td>';
						$insured .= '<td>'.$a['age'].'</td>';
						$insured .= '<td>'.$a['sex'].'</td>';
						$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price[''.$k.'_children'],2).'</td>';
						$insured .= '</tr>';
						$k++;
					}
					$i++;
				}
			}
			$insured .= '<tr>';
			$insured .= '<td colspan="5" style="text-align: right;padding-right: 10px;">Children Pack</td>';
        	$insured .= '<td style="text-align: right;padding-right: 10px;">'.number_format($price['children_pack'],2).'</td>';
			$insured .= '</tr>';
		}else{
			foreach($app as $a){
				if($a['type_applicant'] == '1CHILD'){
					$insured .= '<tr>';
					$insured .= '<td>3</td>';
					$insured .= '<td>'.$a['firstname'].'</td>';
					$insured .= '<td>'.$a['lastname'].'</td>';
					$insured .= '<td>'.$a['age'].'</td>';
					$insured .= '<td>'.$a['sex'].'</td>';
					$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1_children'],2).'</td>';
					$insured .= '</tr>';
				}
				if($a['type_applicant'] == '2CHILD'){
					$insured .= '<tr>';
					$insured .= '<td>4</td>';
					$insured .= '<td>'.$a['firstname'].'</td>';
					$insured .= '<td>'.$a['lastname'].'</td>';
					$insured .= '<td>'.$a['age'].'</td>';
					$insured .= '<td>'.$a['sex'].'</td>';
					$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1_children'],2).'</td>';
					$insured .= '</tr>';
				}
				if($a['type_applicant'] == '3CHILD'){
					$insured .= '<tr>';
					$insured .= '<td>5</td>';
					$insured .= '<td>'.$a['firstname'].'</td>';
					$insured .= '<td>'.$a['lastname'].'</td>';
					$insured .= '<td>'.$a['age'].'</td>';
					$insured .= '<td>'.$a['sex'].'</td>';
					$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1_children'],2).'</td>';
					$insured .= '</tr>';
				}
				if($a['type_applicant'] == '4CHILD'){
					$insured .= '<tr>';
					$insured .= '<td>6</td>';
					$insured .= '<td>'.$a['firstname'].'</td>';
					$insured .= '<td>'.$a['lastname'].'</td>';
					$insured .= '<td>'.$a['age'].'</td>';
					$insured .= '<td>'.$a['sex'].'</td>';
					$insured .= '<td style="text-align:right;padding-right: 10px;">'.number_format($price['1_children'],2).'</td>';
					$insured .= '</tr>';
				}
			}
		}
	}
	
}


$dest .= $quote['company'].' <br /> '.$quote['address'];
$dest .= '<br /> Tel : '.$quote['tel'].' <br />Email :  '.$quote['email'];

$content = str_replace("%applicant_detail%", $dest, $content);
$content = str_replace("%currency%", $quote['currency'], $content);

$content = str_replace("%adhesion%", number_format(($price['adh_cie_fee'] + $price['adh_poema_fee']),2), $content);
$content = str_replace("%assistance%", number_format(($price['ass_cie_indiv'] + $price['ass_cie_family'] + $price['ass_poema']),2), $content);

$additional = "";
$add_val = 0;


$all_field = $quotation->getAdditionalFieldByIdPremiumSelected($_GET['id_price']);
if(sizeof($all_field) > 0){
	foreach($all_field as $af){
		$additional .= '<tr>';
		$additional .= '<td colspan="5" style="text-align: right;padding-right: 10px;">'.$af['name_field'].'</td>';
		$additional .= '<td style="text-align: right;padding-right: 10px;">'.number_format($af['value_field'],2).'</td>';
		$additional .= '</tr>';
		$add_val = $add_val + $af['value_field'];
	}
}

$content = str_replace("%additional%", $additional, $content);

$grandtotal = ($price['family_pack'] + $price['children_pack'] + $price['1st_adult'] + $price['2nd_adult'] + $price['1_children'] + $price['2_children'] + $price['3_children'] + $price['4_children']  + $price['ass_cie_indiv'] + $price['ass_cie_family'] + $price['ass_poema']);

$fee = $price['adh_cie_fee'] + $price['adh_poema_fee'] + +$add_val;

$grand_total = $grandtotal+$fee;

if($price['discount'] != 0){
	$grand_total = $grandtotal - ($grandtotal * ($price['discount']/100));
	$grand_total = $grand_total+$fee;
	$insured .= '<tr>';
	$insured .= '<td colspan="5" style="text-align: right;padding-right: 10px;">Discount '.$price['discount'].'%</td>';
	$insured .= '<td style="text-align: right;padding-right: 10px;">-'.number_format(($grandtotal * $price['discount'])/100,2).'</td>';
	$insured .= '</tr>';
}
$content = str_replace("%insured%", $insured, $content);
$content = str_replace("%grandtotal%", number_format($grand_total,2), $content);

$content = str_replace("%note%", $level['note_en'], $content);



//echo $content;
//print_r($all_field);


$file_name = 'quote.pdf';

$head = '<img src="http://sante-expatrie-asie.com/asia/header.jpg" style="margin:auto; height:97px;" />';
$foot = '';

$pdf->CreatePDFHeadFoot($content,$file_name,'D',$head,$foot);

?>