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

require_once("classes/Currency.php");
$currency = Currency::getInstance();

require_once("classes/User.php");
$user = User::getInstance();
$u = $user->getUserById($_SESSION['login']);

$quote = $quotation->getQuotationById($_GET['id_quote']);
$search = $quotation->getSearchByQuote($_GET['id_quote']);

$content = file_get_contents("template/template_quote_global_en_arawan.html");

$content = str_replace("%month-year%", date('F Y'), $content);
$content = str_replace("%quote_no%", $quote['reference'].''.$quote['id_quote'], $content);
$content = str_replace("%year_effective%", date('Y'), $content);


if($u['office'] == 'MMR'){
	$content = str_replace("%office%", 'Poe-ma insurances (Myanmar Representative Office) - No 3/89 - Gant Gaw Myaing Street, Parami, Yankin Township
	11081 Yangon - Republic of the Union Myanmar', $content);
}
if($u['office'] == 'THA'){
	$content = str_replace("%office%", 'Poe-ma thai insurance brokers - 48/11 Moo 9 - Sunrise Road, T. Chalong - A. Muang 83000 Phuket Thailand', $content);
}
if($u['office'] == 'KHM'){
	$content = str_replace("%office%", 'PoemaCambodia - #59 I, Street 13 - SangkatPsarKandal I - Khan Daun Penh - Phnom Penh Cambodia', $content);
}

$app = $applicant->getApplicantByQuote($quote['id_quote']);


$i=1;
$insured = "";

$content = str_replace("%type%", 'INDIVIDUEL', $content);

if($quote['profession'] == ""){
	$content = str_replace("%profession%", 'A Préciser', $content);
}else{
	$content = str_replace("%profession%", $quote['profession'], $content);
}

$content = str_replace("%nom%",strtoupper($app[0]['lastname']).' '.ucfirst($app[0]['firstname']), $content);
$content = str_replace("%nationality%", $app[0]['nationality'], $content);

if($app[0]['date_of_birth'] != ""){
	$a = explode("/",$app[0]['date_of_birth']);
	$dob= $a[2].'-'.$a[1].'-'.$a[0];
	
	$age_cy = ($search['year_effective'] - date('Y',strtotime($dob)));

	$from = new DateTime($dob);
	$to   = new DateTime('today');

	$age_ca = $from->diff($to)->y;
	$content = str_replace("%1st_dob%", $app[0]['date_of_birth'], $content);
	$content = str_replace("%1st_age%", $app[0]['age'].' ans', $content);
	
}else{
	$content = str_replace("%1st_dob%", $app[0]['age'].' ans', $content);
}

$content = str_replace("%2nd_dob%", "NON", $content);
$content = str_replace("%nb_children%", "NON", $content);
	

$content = str_replace("%email%", $quote['email'], $content);
$content = str_replace("%residence%", $quote['country'], $content);
$content = str_replace("%date_create%", date('d-m-Y'), $content);



$all_1 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M1');
$all_2 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M2');
$all_3 = $quotation->getSelectedPremiumByQuoteByLevel($quote['id_quote'],'M3');

$module_1 = "";


$indication = "<ul>";
$content = str_replace("%option_title%", 'Coverages', $content);


if(sizeof($all_1) > 0){
	
	$module_1 = "<h3 style='text-align:center;'>Best offers in 2017</h3>";
	
	$indication .= '<li><strong>Hospitalisation only / IPD/ Module 1</strong><br /><p>covering only inpatient expenses (hospitalizations & surgeries). Stay more than 24 hours in a room of hospital.</p></li><br />';
	
	if(sizeof($all_2) > 0){
		$indication .= '<li><strong>Hospitalisation + Consultations /IPD+OPD Module 2</strong><br /><p>Routine medical care, such as: doctor’s consultations, pharmacy, investigations, laboratory.</p> </li><br />';
		$module_1 = "<h3 style='text-align:center;'>Best offers in 2017</h3>";
		
		if(sizeof($all_3) > 0){
			$indication .= '<li><strong>Hospitalisation + Consultations + Optique et Dentaire /IPD+OPD MODULE 3</strong><br /><p>En formule complète avec Optique et Dentaire</p></li><br />';
		}
	}else{
		if(sizeof($all_3) > 0){
			$indication .= '<li><strong>Hospitalisation + Consultations /IPD+OPD Module 2</strong><br /><p>Tous les frais d’hospitalisation, frais médicaux courants, consultations médicales chez les spécialistes et généralistes.</p> </li><br />';
			$indication .= '<li><strong>Hospitalisation + Consultations + Optique et Dentaire /IPD+OPD MODULE 3</strong><br /><p>En formule complète avec Optique et Dentaire</p></li><br />';
			$module_1 = "<h3 style='text-align:center;'>Best offers in 2017</h3>";
		}
	}
}else{
	$indication .= '<li><strong>Hospitalisation uniquement / IPD/ Module 1</strong><br /><p> Les frais liés à votre hospitalisation sont remboursés à 100 % des frais réels avec un service de règlement direct de vos frais aux hôpitaux internationaux (ce contrat couvre seulement en cas de gros probleme de sante qui a besoin de rester à l\'hopital plus de 24 H) </p></li><br />';
	
	$module_1 = "<h3 style='text-align:center;'>Best offers in 2017</h3>";
	if(sizeof($all_2) > 0){
		$indication .= '<li><strong>Hospitalisation + Consultations /IPD+OPD Module 2</strong><br /><p>Tous les frais d’hospitalisation, frais médicaux courants, consultations médicales chez les spécialistes et généralistes.</p> </li><br />';
		
		if(sizeof($all_3) > 0){
			$indication .= '<li><strong>Hospitalisation + Consultations + Optique et Dentaire /IPD+OPD MODULE 3</strong><br /><p>En formule complète avec Optique et Dentaire</p></li><br />';
			$module_1 = "<h3 style='text-align:center;'>Best offers in 2017</h3>";
		}
	}else{
		if(sizeof($all_3) > 0){
			$indication .= '<li><strong>Hospitalisation + Consultations /IPD+OPD Module 2</strong><p>Tous les frais d’hospitalisation, frais médicaux courants, consultations médicales chez les spécialistes et généralistes.</p> </li>';
			$indication .= '<li><strong>Hospitalisation + Consultations + Optique et Dentaire /IPD+OPD MODULE 3</strong><p>En formule complète avec Optique et Dentaire</p></li>';
		}
	}
}

if($search['extended_area'] == 1){
	$indication .= '<li>La tarification a été faite avec un couverture en Zone etendu (Voir details)</li>';
}
if($search['lifetime'] == 1){
	$indication .= '<li>le tarif a été donné sur la base d’un contrat Viager</li>';
}

$indication .= '</ul>';



$module_1 .= "<h5 style='text-align:center;'>( Rate in %currency% per year )</h5>";
//$module_1 .= "<p style='text-align:center;font-size:11px'><i>Certaines offres sont Fractionnables (Mois, Trimestre, Semestre) – voir Annexe.</i></p>";

if(sizeof($all_1) > 0){
	
	
	$module_1 .= "<h5 style='text-align:center;'>Module 1: Hospitalsations only (IN PATIENT)</h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Tarif <strong>( '.$quote['currency'].' )</strong></td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	
	if($app[0]['date_of_birth'] != ""){

		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Age '.$age_ca.' - '.$age_cy.' years old</td>%age%';
		}else{
			$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
		}
		
		
	}else{
		$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
	}
	
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
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
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		$age .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		
		if(($select['ass_cie_indiv']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">Inclus</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_indiv']+$select['ass_poema']).'</td>';
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
		
		$total .= '<td style="text-align:center;"><strong>'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']+$select['ass_cie_indiv']+$select['ass_poema']+$select['1st_adult']+$additional_val).'</strong></strong></td>';
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
	$module_1 = str_replace("%age%", $age, $module_1);
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%note%", $note, $module_1);
	
}



if(sizeof($all_2) > 0){
	$module_1 .= "<h5 style='text-align:center;'>Module 2: Hospitalisations + Consultations (IN PATIENT + OUT PATIENT) </h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Tarif <strong>( '.$quote['currency'].' )</strong></td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	if($app[0]['date_of_birth'] != ""){

		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Age '.$age_ca.' - '.$age_cy.' years old</td>%age%';
		}else{
			$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
		}
		
		
	}else{
		$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
	}
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
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
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		$age .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		if(($select['ass_cie_indiv']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">Inclus</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_indiv']+$select['ass_poema']).'</td>';
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
		
		$total .= '<td style="text-align:center;"><strong>'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']+$select['ass_cie_indiv']+$select['ass_poema']+$select['1st_adult']+$additional_val).'</strong></strong></td>';
		
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
	$module_1 = str_replace("%age%", $age, $module_1);
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%note%", $note, $module_1);
	
}


if(sizeof($all_3) > 0){
	$module_1 .= "<h5 style='text-align:center;'>Module 3: Hospitalisations + Consultations (IN PATIENT + OUT PATIENT) + Optique et Dentaire</h5>";
	$module_1 .= '<table class="table" style="width:100%; border-collapse: collapse; font-size:10px;">';
	$module_1 .= '<thead>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%" style="background-color:#eee;">Tarif <strong>( '.$quote['currency'].' )</strong></td>%title%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	if($app[0]['date_of_birth'] != ""){

		if( $age_cy != $age_ca){
			$module_1 .= '<td width="15%">Age '.$age_ca.' - '.$age_cy.' years old</td>%age%';
		}else{
			$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
		}
		
		
	}else{
		$module_1 .= '<td width="15%">Age '.$app[0]['age'].' years old</td>%age%';
	}
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Assistance / Repatriation.</td>%assistance%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Membership fees</td>%adhesion%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
	$module_1 .= '<td width="15%">Additional fees</td>%additional%';
	$module_1 .= '</tr>';
	
	$module_1 .= '<tr>';
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
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />'.number_format($select['garanty']).' '.$pro['currency'].'</td>';
			}
			
		}else{
			if($lev['deductible'] != 0){
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'<br />Franchise : '.number_format(floor($lev['deductible']*$rate)).'</td>';
			}else{
				$title .= '<td style="text-align:center;background-color:#eee;">'.$select['name_plan'].'</td>';
			}
			
		}
		
		$age .= '<td style="text-align:center;">'.number_format($select['1st_adult']).'</td>';
		if(($select['ass_cie_indiv']+$select['ass_poema']) == 0){
			$assistance .= '<td style="text-align:center;">Inclus</td>';
		}else{
			$assistance .= '<td style="text-align:center;">'.number_format($select['ass_cie_indiv']+$select['ass_poema']).'</td>';
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
		
		$total .= '<td style="text-align:center;"><strong>'.number_format($select['adh_cie_fee']+$select['adh_poema_fee']+$select['ass_cie_indiv']+$select['ass_poema']+$select['1st_adult']+$additional_val).'</strong></strong></td>';
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
	$module_1 = str_replace("%age%", $age, $module_1);
	$module_1 = str_replace("%assistance%", $assistance, $module_1);
	$module_1 = str_replace("%adhesion%", $adhesion, $module_1);
	$module_1 = str_replace("%additional%", $additional, $module_1);
	$module_1 = str_replace("%total%", $total, $module_1);
	$module_1 = str_replace("%note%", $note, $module_1);
	
}

$content = str_replace("%module_details%", $module_1, $content);
$content = str_replace("%currency%", $quote['currency'], $content);
$content = str_replace("%indications%", $indication, $content);
//echo $content;


$file_name = $app[0]['lastname'].'_'.$quote['reference'].''.$quote['id_quote'].'.pdf';

//$head = '<img src="http://localhost/asia/header.jpg" style="margin:auto; height:97px;" />';
//$foot = '';

$pdf->CreatePDF($content,$file_name,'D');

?>