<?php include(ACTION_PATH.'jobs_action.php')?>
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Submit Resume</h1>
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
 <!-- Start Submit Resume-->
 <section id="1" class="section-very-short">
     <div class="container">
          <div class="row body_white_round">
            <form class="form" enctype="multipart/form-data" method="post" action="<?php loader_display(ROOT_PATH.'jobs')?>" >
			 
               <div class="form-group">
			   <?php loader_set_session('form_session',rand(10,10000));?>
                 <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" hidden/>
                 
                  <div class="col-sm-6 margin-bottom-10">
                    <div class= "form-group">
                      <label for="first_name" class="col-sm-2 control-label">First Name*</label>
                         <div class="col-sm-10">
                    <input name="first_name" id="first_name" class="large-form-control required customvalidation" value= ""   type="text" size="50" placeholder="Enter First Name" /></div>
                    </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                      <div class= "form-group">
                       <label for="last_name" class="col-sm-2 control-label">Last Name*</label>
                       <div class="col-sm-10">
                      <input name="last_name" id="last_name" class="large-form-control required customvalidation" value= "" type="text" size="50" placeholder="Enter Last Name"/></div>
                      </div>
                     </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-6 margin-bottom-10">
                    <div class= "form-group">
                                             <label for="email" class="col-sm-2 control-label">Email ID*</label>
                         <div class="col-sm-10">
                    <input name="email" id="email" class="large-form-control required email" value= ""   type="email" size="50" placeholder="Enter Email ID " /></div>
                    </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                      <div class= "form-group">
                       <label for="mobile_no" class="col-sm-2 control-label">Mobile No*</label>
                         <div class="col-sm-10">
                      <input name="mobile_no" id="mobile_no" class="large-form-control required numeric mobile_no" value= "" type="text" size="50" placeholder="Enter 10 Digit Mobile No"/></div>
                      </div>
                    </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-6 margin-bottom-10">
                   <div class= "form-group">
                    <label for="postal_address" class="col-sm-2 control-label">Postal Address*</label>
                    <div class="col-sm-10">
                   <textarea height="100" name="postal_address" id="postal_address" class="large-form-control required" value= ""   type="text" size="50" placeholder="Enter Your Address "></textarea></div>
                   </div>
                   </div>
                   <div class="col-sm-6 margin-bottom-10">
                        <div class="form-group">
                         <label for="resume" class="col-sm-2 control-label">Upload Resume*</label>
                         <div class="col-sm-10">
                           <input name="resume" id="resume" class="large-form-control required" type="file" placeholder="Upload Resume"/>
                         </div>
                        </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                        <div class="form-group">
                        
                              <input style="height:4em; width: 4em; vertical-align: middle;" id="r1" type="radio" name="gender" value="male" checked><label class="big-level" for="r1">Male</label>
                              <input style="height:4em; width: 4em; vertical-align: middle;" id="r2" type="radio" name="gender" value="female"><label class="big-level" for="r2">Female</label>
                              <input style="height:4em; width: 4em; vertical-align: middle;" id="r3" type="radio" name="gender" value="other"><label class="big-level" for="r3">Other</label>
                        </div>
                   </div>
                  
               </div>
			  
			   
               <div class="form-group text-center">
			   
                            <div class="">
                                <input type="submit" id="submit_resume_button" name="submit_resume_button" class="btn btn-large btn-default" value="Submit" />
                            </div>
                        </div>               
            </form>
          </div>
     </div>
 </section>
 <!--End Submit Resume-->
  <!-- Start Pricing-->
 <section class="section-very-short">
     <div class="container">
          <div class="row body_white_round">
             <h2 class="padding-bottom-25 section-title text-center " >For Drivers Only</h2>
             <div class="form-group">
                 <form id="register_mobile_form" action="<?php loader_display(ROOT_PATH."jobs")?>"  method="post">
                 <div class="form-group" >
                    <div class="col-sm-3 margin-bottom-10">
                     <h3 class="text-center padding-bottom-25 section-title" >Register Your Mobile</h3>
                    </div>
					<?php loader_set_session('form_session',rand(10,10000));?>
                 <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" hidden/>
                 
                    <div class="col-sm-6 margin-bottom-10">
                       <input class="large-form-control required mobile_no numeric"  type="text" size="50" name="driver_mobile_no" id="driver_mobile_no" placeholder="Enter 10 digit Mobile No"/>
                    </div>
                     <div class="col-sm-3 margin-bottom-10 text-center ">
                       <input type="submit" class="btn btn-large" id="register_driver_button" name="register_driver_button" value="Register" />
                    </div>
                 </div>
               </form>
             </div>
          </div>
     </div>
 </section>
 <!--End Pricing-->