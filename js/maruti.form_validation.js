/**
 * Unicorn Admin Template
 * Diablo9983 -> diablo9983@gmail.com
**/
$(document).ready(function(){
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
    $("#basic_validate").validate({
		ignore: ".ignore",
		//onfocusout: false,
                //invalidHandler: function(form, validator) {
                //    var errors = validator.numberOfInvalids();
                //    if (errors) {
                //        alert(validator.errorList[0].message + " (" + validator.errorList[0].element.id + ")");
                //        validator.errorList[0].element.focus();
                //    }
                //},
		invalidHandler: function(e, validator){
			if(validator.errorList.length){
				//alert("A");
				$('#tabs a[href="#' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
			}
		},
		
		rules:{
			required:{
				required:true
			},
			email:{
				maxlength:30,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			country:{
				required:true
			},
			title:{
				required:true,
				minlength:1
			},
			
			name1:{
				required:true,
				minlength:1,
				maxlength:35
			},
			name2:{
				maxlength:35
			},
			nickname:{
				maxlength:10
			},
			search1:{
				required:true,
				minlength:1,
				maxlength:25
			},
			search2:{
				maxlength:25
			},
			industry:{
				required:true,
				minlength:1
			},
			//customer_class:{
			//	required:true,
			//	minlength:1
			//},
			top:{
				required:true,
				minlength:1
			},
			sales_org:{
				required:true,
				minlength:1
			},
			company:{
				required:true,
				minlength:1
			},
			dis_channel:{
				required:true,
				minlength:1
			},
			division:{
				required:true,
				minlength:1
			},
			account_group:{
				required:true,
				minlength:1
			},
			
			nik:{
				required:true,
				minlength:1
			},
			app:{
				required:true,
				minlength:1
			},
			postalcode:{
				required:true,
				maxlength:5,
				minlength:5,
				number:true
			},
			city:{
				required:true,
				maxlength:35,
				minlength:1
			},
			tlp:{
				maxlength:16,
			},
			fax:{
				maxlength:30
			},
			hp:{
				maxlength:16
			},
			subject:{
				required:true,
				maxlength:30
			},
			address:{
				required:true,
				maxlength:35
			},
			address2:{
				maxlength:35
			},
			address3:{
				maxlength:35
			},
			address4:{
				maxlength:35
			},
			region:{
				required:true,
				minlength:1
			},
			membercard:{
				maxlength:30
			},
			vat:{
				maxlength:20
			},
			//sales_office:{
			//	required:true,
			//	minlength:1
			//},
			//customer_group:{
			//	required:true,
			//	minlength:1
			//},
			currency:{
				required:true,
				minlength:1
			},
			incoterm:{
				required:true,
				minlength:1
			},
			deskripsi:{
				required:true,
				maxlength:25
			},
			name_find:{
				required:true,
				minlength:3
			},
			cust_account:{
				required:true,
				minlength:10,
				maxlength:10
			},
			//company2:{
			//	required:true,
			//	minlength:1
			//},
			//dis_channel2:{
			//	required:true,
			//	minlength:1
			//},
			//division2:{
			//	required:true,
			//	minlength:1
			//},
			xname_cp:{
				required:true
				
			},
			role:{
				required:true,
				minlength:1
			},
			cust:{
				required:true,
				minlength:1
			}
			
			
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
			pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			pwd2:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});
