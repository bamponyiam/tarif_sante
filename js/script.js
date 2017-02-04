function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".")+".00";
}
function update_currency(id,val){
	  $.post("update_currency_rate.php", { id: id, val : val },
		function(result){
			$('#lib_'+id).hide().html(result).fadeIn(1000);
		  $('.rate_edit').hide();
			//alert(result);
	});
}
$( document ).ready(function() {

	$('#discount').click(function() {
		if($('#discount').prop('checked')) {
			$('.discount').show('slow');
		} else {
			$('.discount').hide('slow');
		}
	});
	
	$('#location').click(function() {
		if($('#location').prop('checked')) {
			$('.location').show('slow');
		} else {
			$('.location').hide('slow');
		}
	});
	$('#children').click(function() {
		if($('#children').prop('checked')) {
			$('.children').show('slow');
		} else {
			$('.children').hide('slow');
		}
	});
	
	$('#family_option').click(function() {
		if($('#family_option').prop('checked')) {
			$('.family_option').show('slow');
		} else {
			$('.family_option').hide('slow');
		}
	});
	
	$('.type_con').click(function() {
		if($("input[name=type_con][value='INDIV']").prop("checked")){
			$('.individual').show('slow');
			$('.family').hide('slow');
			
		}else{
			$('.individual').hide('slow');
			$('.family').show('slow');
			
		}
		$('.panel-body').hide();
	});
	
	$("#search-form").submit(function( event ) {
	 if($('input:radio[name=type_con]:checked').val() == 'INDIV'){
		 if($("#dob_indiv").val() == ""){
			 if($("#age_indiv").val() == ""){
				 alert('Please input date of birth / Age');
		  		$("#age_indiv").parent().addClass("has-error");
				$("#dob_indiv").parent().addClass("has-error");
		  		return false;
			 }
	  	}
	 }else{
		if($("#dob_1st_family").val() == ""){
			 if($("#age_1st_family").val() == ""){
				 alert('Please input date of birth / Age');
		  		$("#dob_1st_family").parent().addClass("has-error");
				$("#age_1st_family").parent().addClass("has-error");
		  		return false;
			 }
	  	} 
	 }
	  	  
	});
	
	
	$('.rate_edit').hide();
	$('.edit_rate').on('click', function (e) {
        e.preventDefault(); 
        $($(this).attr('href')).toggle('slow', function(){});
    });
	
	$('.edit_field').hide();
    $('.edit').on('click', function (e) {
        e.preventDefault(); 
        $($(this).attr('href')).toggle('slow', function(){});
    });
	
	$('.confirm_edit_rate').click(function() {
		update_currency($(this).attr('id'),$('#val_rate_'+$(this).attr('id')).val());
		//alert();
		//console.log($(this).parent().parent().parent().html());
	});
	
	$('.cal-field').blur(function() {
		//$(this).parent().parent().parent().parent('input').each(function() {
		//	alert($(this).val());
		//});
		//console.log();
		//$(this).parent().parent().parent().parent().each(function() {
			
		//});
		var total = 0;
		$(this).parent().parent().parent().parent().find('.cal-field').each(function (index, element) {
			//console.log($(this).val());
			total = total+parseInt($(this).val());
		});
		$(this).parent().parent().parent().parent().find('.total').each(function (index, element) {
			$(this).val(total);
		});
	});
	
	$('.cancel-edit').click(function() {
		$(this).parent().parent().parent().hide('slow');
		//alert('555');
		//console.log($(this).parent().parent().parent().html());
	});
	
	
	$("#quote_indiv").submit(function( event ) {
		
		$("#quote_indiv input[name=firstname_indiv]").val($("#search-form input[name=firstname_indiv]").val());
		$("#quote_indiv input[name=lastname_indiv]").val($("#search-form input[name=lastname_indiv]").val());
		$("#quote_indiv input[name=sex_indiv]").val($("#search-form select[name=sex_indiv] ").val());
		$("#quote_indiv input[name=nationality_indiv]").val($("#search-form select[name=nationality_indiv]").val());
		$("#quote_indiv input[name=age_indiv]").val($("#search-form input[name=age_indiv]").val());
		$("#quote_indiv input[name=company_indiv]").val($("#search-form input[name=company_indiv]").val());
		$("#quote_indiv input[name=email_indiv]").val($("#search-form input[name=email_indiv]").val());
		$("#quote_indiv input[name=address_indiv]").val($("#search-form textarea[name=address_indiv]").val());
		$("#quote_indiv input[name=phone_indiv]").val($("#search-form input[name=phone_indiv]").val());
		$("#quote_indiv input[name=country_indiv]").val($("#search-form input[name=country_indiv]").val());
		
		return true;
	});
	
	$("#quote_family").submit(function( event ) {
		
		$("#quote_family input[name=firstname_1st_family]").val($("#search-form input[name=firstname_1st_family]").val());
		$("#quote_family input[name=lastname_1st_family]").val($("#search-form input[name=lastname_1st_family]").val());
		$("#quote_family input[name=age_1st_family]").val($("#search-form input[name=age_1st_family]").val());
		$("#quote_family input[name=sex_1st_family]").val($("#search-form select[name=sex_1st_family] ").val());
		$("#quote_family input[name=nationality_1st_family]").val($("#search-form select[name=nationality_1st_family]").val());
		
		$("#quote_family input[name=firstname_2nd_family]").val($("#search-form input[name=firstname_2nd_family]").val());
		$("#quote_family input[name=lastname_2nd_family]").val($("#search-form input[name=lastname_2nd_family]").val());
		$("#quote_family input[name=age_2nd_family]").val($("#search-form input[name=age_2nd_family]").val());
		$("#quote_family input[name=sex_2nd_family]").val($("#search-form select[name=sex_2nd_family] ").val());
		$("#quote_family input[name=nationality_2nd_family]").val($("#search-form select[name=nationality_2nd_family]").val());
		
		$("#quote_family input[name=firstname_1_child_family]").val($("#search-form input[name=firstname_1_child_family]").val());
		$("#quote_family input[name=lastname_1_child_family]").val($("#search-form input[name=lastname_1_child_family]").val());
		$("#quote_family input[name=age_1_child_family]").val($("#search-form input[name=age_1_child_family]").val());
		$("#quote_family input[name=sex_1_child_family]").val($("#search-form select[name=sex_1_child_family] ").val());
		$("#quote_family input[name=nationality_1_child_family]").val($("#search-form select[name=nationality_1_child_family]").val());
		
		$("#quote_family input[name=firstname_2_child_family]").val($("#search-form input[name=firstname_2_child_family]").val());
		$("#quote_family input[name=lastname_2_child_family]").val($("#search-form input[name=lastname_2_child_family]").val());
		$("#quote_family input[name=age_2_child_family]").val($("#search-form input[name=age_2_child_family]").val());
		$("#quote_family input[name=sex_2_child_family]").val($("#search-form select[name=sex_2_child_family] ").val());
		$("#quote_family input[name=nationality_2_child_family]").val($("#search-form select[name=nationality_2_child_family]").val());
		
		$("#quote_family input[name=firstname_3_child_family]").val($("#search-form input[name=firstname_3_child_family]").val());
		$("#quote_family input[name=lastname_3_child_family]").val($("#search-form input[name=lastname_3_child_family]").val());
		$("#quote_family input[name=age_3_child_family]").val($("#search-form input[name=age_3_child_family]").val());
		$("#quote_family input[name=sex_3_child_family]").val($("#search-form select[name=sex_3_child_family] ").val());
		$("#quote_family input[name=nationality_3_child_family]").val($("#search-form select[name=nationality_3_child_family]").val());
		
		$("#quote_family input[name=firstname_4_child_family]").val($("#search-form input[name=firstname_4_child_family]").val());
		$("#quote_family input[name=lastname_4_child_family]").val($("#search-form input[name=lastname_4_child_family]").val());
		$("#quote_family input[name=age_4_child_family]").val($("#search-form input[name=age_4_child_family]").val());
		$("#quote_family input[name=sex_4_child_family]").val($("#search-form select[name=sex_4_child_family] ").val());
		$("#quote_family input[name=nationality_4_child_family]").val($("#search-form select[name=nationality_4_child_family]").val());
		
		$("#quote_family input[name=company_family]").val($("#search-form input[name=company_family]").val());
		$("#quote_family input[name=email_family]").val($("#search-form input[name=email_family]").val());
		$("#quote_family input[name=address_family]").val($("#search-form textarea[name=address_family]").val());
		$("#quote_family input[name=phone_family]").val($("#search-form input[name=phone_family]").val());
		$("#quote_family input[name=country_family]").val($("#search-form input[name=country_family]").val());
		
		return true;
	});
	
	$(function() {
    //----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 
        e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
 
        e.preventDefault();
    });
});
	
		
});