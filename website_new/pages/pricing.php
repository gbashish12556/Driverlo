
<script type="text/javascript">
jQuery(function(){
	 $("#myonoffswitch").change(function() {
		if(this.checked) {
			$('#night_section').show();
			$('#day_section').hide();
		}else
		{
			$('#night_section').hide();
			$('#day_section').show();
		}
	});
 });
</script>
</script>
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Our Pricing</h1>
        </div>
      </div>
     </div>
</section>
<section>
    <div class="col-sm-12">
      <div>
				  <?php
                  if(isset($success_message) && $success_message !="")
                   {
                   ?>
                   <div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">close</button>
                                <?php loader_display($success_message); ?>
                            </div>
                 <?php  } ?>
      </div>
      <div>
				 <?php
                if(isset($error_message) &&  $error_message != "")
                {
                ?>
                <div class="alert alert-danger">
                                             <button data-dismiss="alert" class="close" type="button">close</button>
                                             <?php loader_display($error_message); ?>
                                     </div>
              <?php  } ?>
      </div>
  </div>
</section>
 <!-- Start Pricing-->
 <section id="1" class="text-center section-very-short">
     <div class="container">
          <div class="row body_white_round">
              <!-- Rectangular switch -->
            <div class="onoffswitch" style="margin:0 auto;">
                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                <label class="onoffswitch-label" for="myonoffswitch">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
            <div id="night_section">
              <h2 class="blr-pricing-heading">Your private driver anytime @ ₹ 99/hr</h2>
              <h4>Pay by the minute after the first hour(Rs 1 per min)</h4> 
              <p class="mid_font_text" >Night time charge of ₹150 for drives ending between 11 PM to 6AM</p>
              <p>Service tax as applicable.Terms & Conditions Apply & return fare for bus train allowance extra</p>
            </div>
            <div id="day_section" hidden="hidden">
              <h2 class="blr-pricing-heading">Your private driver anytime @ ₹ 99/hr</h2>
              <h4>Pay by the minute after the first hour(Rs 1 per min) + One - way charge of ₹100</h4> 
              <p class="mid_font_text" >Night time charge of ₹150 for drives ending between 11 PM to 6AM</p>
              <p>Service tax as applicable. Terms & Conditions Apply & return fare for bus train allowance extra</p>
            </div>
            <h4>Charges per day + Boarding / lodging + Food1200 per day + Boarding / lodging + Food charges extra</h4>
            <h4>Cancellation Charges (in case driver reports at reporting address and is sent back)</h4>
            <p class="mid_font_text" >P. S. :The above mentioned charges are not applicable on special occasions(e.g. Holi, New Year's Eve etc.)</p>
          </div>
     </div>
 </section>
 <!--End Pricing-->
  <section id="1" class="text-center section-very-short">
     <div class="container">
          <div class="row body_white_round">
            <div id="night_section">
              <h2 class="blr-pricing-heading">Offer !</h2>
              <h3 style="font-weight:bold; color:#25AAA0  !important" >Use coupon code DL50 for Rs. 50 discount in 4 hrs duty</h3>
              <h3 style="font-weight:bold; color:#25AAA0  !important" >Use coupon code DL80 for Rs. 80 discount in 8 hrs duty</h3>
            </div>
          </div>
     </div>
  </section>            
  <!-- Start Monthly Plan-->
 <section id="1" class="text-center section-very-short">
     <div class="container">
          <div class="row body_white_round">
            <div id="night_section">
              <h2 class="blr-pricing-heading">Monthly Plan</h2>
              <p class="mid_font_text">Driver for monthly basis (private vehicle)</p >
              <div class="table-container">
				 <table class="price table-distance margin-bottom-10">
				  <colgroup>
					<col width="300px">
                    <col width="150px">
					<col width="150px">
				  </colgroup>
				  <tbody>
				  <tr>
					<th><b>Type of vehicle</b></th>
					<th><b>10hrs</b></th>
                    <th><b>12 hrs</b></th>
				  </tr>
                  <tr>
					<td><b>Hatch back, sedan car (manual gear) </b></td>
					<td><b>₹ 12000/months  </b></td>
                    <td><b>₹ 14000/months</b></td>
				  </tr>
                  <tr>
					<td><b>Hatch back, sedan car (auto gear)</b></td>
					<td><b>₹ 13000/months</b></td>
                    <td><b>₹ 15000/months</b></td>
				  </tr>
                  <tr>
					<td><b>Luxury car (BMW, Audi, Mercedes etc)</b></td>
					<td><b>₹ 15000/months</b></td>
                    <td><b>₹ 17000/months</b></td>
				  </tr>
				  </tbody>
				</table>
			</div> 
              <h2 class="blr-pricing-heading">Note</h2>
              <div class="table-container">
				 <table class="price table-distance margin-bottom-10">
				  <colgroup>
					<col width="350px">
                    <col width="250px">
				  </colgroup>
				  <tbody>
				  <tr>
					<th><b>Parameter</b></th>
					<th><b>Remarks</b></th>
				  </tr>
                  <tr>
					<td><b>Over time</b></td>
					<td><b> ₹ 50/h</b></td>
				  </tr>
                  <tr>
					<td><b>Weekly off</b></td>
					<td><b>1 weekly off</b></td>
				  </tr>
                  <tr>
					<td><b>Casual  leave</b></td>
					<td><b>1 in month</b></td>
				  </tr>
                  <tr>
					<td><b>Replacement period</b></td>
					<td><b>6 months</b></td>
				  </tr>
                  <tr>
					<td><b>Commission </b></td>
					<td><b>half month salary</b></td>
				  </tr>
				  </tbody>
				</table>
			</div>
          </div>
     </div>
 </section>
 <!--End Monthly Plan-->