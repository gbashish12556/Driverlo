
	jQuery.validator.addMethod("alphanumeric", function(value, element) 
	{
	return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
	}, "Cannot contain any special characters");

	jQuery.validator.addMethod("pin", function(value, element) 
	{
	return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
	}, "Cannot contain any special characters or space");
	jQuery.validator.addMethod("numeric", function(value, element) 
	{
	return this.optional(element) || /^[0-9]+$/i.test(value);
	}, "Only numbers allowed");
	jQuery.validator.addMethod("numeric_5", function(value, element) 
	{
	return this.optional(element) || /^([0-5]{1})+(\.([0-9]{1,2})?)?$/i.test(value);
	}, "Only numbers less than 5 allowed");
	 jQuery.validator.addMethod("float", function(value, element) 
	{
	return this.optional(element) || /^[0-9]+(\.([0-9]{1,2})?)?$/i.test(value);
	}, "Only decimal numbers allowed");
	$.validator.addMethod("customvalidation", function(value, element) {
   return this.optional(element) || /^[a-zA-Z ]*$/i.test(value);
	}, "Only alphabet and space allowed");
		 $.validator.addMethod("city", function(value, element) {
	   return this.optional(element) || /^[a-zA-Z0-9 ]*$/i.test(value);
	}, "Cannot contain any special characters");
	$.validator.addMethod("datetime", function(value, element) {
	   return this.optional(element) || /^([0][1-9]|[12][0-9]|3[0-1])\/([0][1-9]|1[0-2])\/(\d{4}) (0[0-9]|1[0-2])\:([0-5][0-9]) (am|pm)$/i.test(value);
	}, "Date format not valid");
	$.validator.addMethod("time", function(value, element) {
	   return this.optional(element) || /^([0-9]|1[0-2])\:([0-5][0-9]) (am|pm)$/i.test(value);
	}, "time format not valid");
	$('.mobile_no').mask('9999999999');
	$('#search_form').validate();
	$('#create_form').validate();
	$('#edit_form').validate();
	$('#delete_form').validate();
	$("#loginForm").validate({
		rules: {
			username: {
				required: true,
				minlength: 4
			},
			password: {
				required: true,
				minlength: 6
			}  
		},
		messages: {
			username: {
				required: "Fill me please",
				minlength: "My name is bigger"
			},
			password: {
				required: "Please provide a password",
				minlength: "My password is more that 6 chars"
			}
		}   
	});
	 $(".paginate_button").click(function(){
		//alert($(this).attr('var_pageno'));
		$("#new_page_pag").val($(this).attr('var_pageno'));
		//alert($("#new_page_pag").val());
		$("#page_form").submit();
		return false;
	});
	

