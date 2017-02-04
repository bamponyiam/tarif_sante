<?php 
	session_start();
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

	$quote = $quotation->getQuotationById($_GET['id']);

	$data = array();
	$data['reference'] =  $u['office'].''.date('Ymd');
	$data['currency'] = $quote['currency'];
	$data['type_con'] = $quote['type_con'];
	$data['company'] = $quote['company'];
	$data['address'] = $quote['address'];
	$data['tel'] = $quote['tel'];
	$data['email'] = $quote['email'];
	$data['country'] = $quote['country'];
	$data['id_user'] = $u['id_user'];
	$data['profession'] = $quote['profession'];

	$id_quote = $quotation->insertQuotation($data);

	if($quote['type_con'] == 'INDIV'){

		$appli = $applicant->getApplicantByQuote($quote['id_quote']);
		$app = array();

		$app['date_of_birth'] = $appli[0]['date_of_birth'];
		$app['sex'] = $appli[0]['sex'];
		$app['type_applicant'] = "INDIV";
		$app['marine'] = $appli[0]['marine'];
		$app['age'] = $appli[0]['age'];
		$app['firstname'] = $appli[0]['firstname'];
		$app['lastname'] = $appli[0]['lastname'];
		$app['nationality'] = $appli[0]['nationality'];
		$app['id_quote'] = $id_quote;

		$applicant->insertApplicant($app);

	}else{
		
		$appli = $applicant->getApplicantByQuote($quote['id_quote']);
		
		if(sizeof($appli) > 0){
			foreach($appli as $a){
				
				$app = array();
				$app['date_of_birth'] = $a['date_of_birth'];
				$app['sex'] = $a['sex'];
				$app['type_applicant'] = $a['stype_applicantex'];
				$app['marine'] = $a['marine'];
				$app['age'] = $a['age'];
				$app['firstname'] = $a['firstname'];
				$app['lastname'] = $a['lastname'];
				$app['nationality'] = $a['nationality'];
				$app['id_quote'] = $id_quote;

				$applicant->insertApplicant($app);
				
				unset($app);
			}
		}

		
		
	}

	$all = $quotation->getSelectedPremiumByQuote($quote['id_quote']);
	if(sizeof($all) > 0){
		foreach($all as $p){
			$premium = array();

			$premium['id_level'] = $p['id_level'];
			$premium['id_premium'] = $p['id_premium'];
			$premium['id_quote'] = $id_quote;
			$premium['1st_adult'] = $p['1st_adult'];
			$premium['2nd_adult'] = $p['2nd_adult'];
			$premium['1_children'] = $p['1_children'];
			$premium['2_children'] = $p['2_children'];
			$premium['3_children'] = $p['3_children'];
			$premium['4_children'] = $p['4_children'];
			$premium['discount'] = $p['discount'];
			$premium['family_pack'] = $p['family_pack'];
			$premium['children_pack'] = $p['children_pack'];
			$premium['adh_cie_fee'] = $p['adh_cie_fee'];
			$premium['ass_cie_indiv'] = $p['ass_cie_indiv'];
			$premium['adh_poema_fee'] = $p['adh_poema_fee'];
			$premium['ass_cie_family'] = $p['ass_cie_family'];
			$premium['ass_poema'] = $p['ass_poema'];

			$quotation->insertSelectedPremium($premium);

			unset($premium);
		}
	}

	$se = $quotation->getSearchByQuote($quote['id_quote']);
	$search = array();

	$search['M1'] = $se['M1'];
	$search['M2'] = $se['M2'];
	$search['M3'] = $se['M3'];
	$search['currency'] = $se['currency'];
	$search['year_effective'] = $se['year_effective'];
	$search['location'] = $se['location'];
	$search['local'] = $se['local'];
	$search['lifetime'] = $se['lifetime'];
	$search['extended_area'] = $se['extended_area'];
	$search['id_quote'] = $id_quote;

	$quotation->insertSearch($search);

	

header("Location:view-quote?id=".$id_quote);

	
?>