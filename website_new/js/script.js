/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $(document).ready(function(){
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
	$('.form').validate();
	$('#get_quote_form').validate();
	$('#login_form').validate();
	$('#forget_password_form').validate();
	$('#register_mobile_form').validate();
    jQuery('#signup_form').validate({
		rules: {
			signup_password: {
				minlength: 5
			},
			confirm_signup_password: {
				minlength: 5,
				equalTo : '[name="signup_password"]'
			}
		}
	}); 
	jQuery('#change_password_form').validate({
    rules: {
        new_password: {
            minlength: 5
        },
        confirm_new_password: {
            minlength: 5,
            equalTo : '[name="new_password"]'
        }
    }
}); 
	   //option A
	$('.mobile_no').mask('9999999999');
	('.hide-password').on('click', function(){
		  var $this= $(this),
		$password_field = $this.prev('input');
		( 'password' === $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
		( 'Hide' === $this.text() ) ? $this.text('Show') : $this.text('Hide');
		//focus and move cursor to the end of input field
		$password_field.putCursorAtEnd();
    });
	$('li').click(function(){
		$('li').removeClass('active');
		$(this).flnd('li').addClass('active');
	});
    $("#benefits_section").hover(function(){
        $(".animation_para").css("-webkit-animation-play-state", "paused");
		$(".animation_para").css("animation-play-state", "paused");
     });
});

