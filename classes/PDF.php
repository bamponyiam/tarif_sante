<?php
include_once('mpdf/mpdf.php');

class PDF{
	//private $mpdf;
	private static $_instance; //The single instance
	
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	private function __construct(){
		//$mpdf = Mpdf::getInstance();
	}
	
	public function CreatePDF( $content,$filename,$option){
		$mpdf = new mPDF();	
		$mpdf->DefHTMLHeaderByName('Chapter2Header','');
		
		$mpdf->DefHTMLFooterByName('Chapter2Footer','');
		
		$mpdf->SetHTMLHeaderByName('Chapter2Header');
		$mpdf->SetHTMLFooterByName('Chapter2Footer');
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename,$option); //D:sent to brownser and force to download   F: Save to directory path
	}	
	
	public function CreatePDFHeadFoot( $content,$filename,$option,$head,$foot){
		$mpdf = new mPDF();	
		$mpdf->DefHTMLHeaderByName('Chapter2Header',$head);
		
		$mpdf->DefHTMLFooterByName('Chapter2Footer',$foot);
		
		$mpdf->SetHTMLHeaderByName('Chapter2Header');
		$mpdf->SetHTMLFooterByName('Chapter2Footer');
		$mpdf->WriteHTML($content);
		$mpdf->Output($filename,$option); //D:sent to brownser and force to download   F: Save to directory path
	}
}
?>