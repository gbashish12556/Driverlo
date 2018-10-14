<?php //include(ACTION_PATH.'contact_action.php'); ?>
<section class="section margin-bottom-10" >
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
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Contact Us</h1>
        </div>
      </div>
     </div>
</section>
<section class="section">
    <div class="container">
      <div class="row body_white_round">
          <p class="story_text text-left" >Everyone loves their car but driving it is a different experience altogether. Driving your car on a highway can be really exciting but during peak hours, where the traffic is bumper-to-bumper, it can get exhausting. Driverlo driver on-demand services provide you with much needed comfort. We guarantee that you will have a comfortable experience when our professional driver takes over the wheel.</p>
      </div>
     </div>
</section>
<section class="section section-short ">
    <div class="container">
     <div class="row">
       <div class="form-group">
         <div class="col-sm-6 body_white_round">
               <form class="form padding-top-bottom-15" method="post" action="<?php loader_display(ROOT_PATH.'contact')?>">
                 <div class="form-group row">
                    <label for="name" class="col-sm-2 control-label">Name*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control required"  type="text" size="50" name="name" id="name" placeholder="Enter Your Name"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="email" class="col-sm-2 control-label">Email*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control email required email"  type="email" size="50" name="email" id="email" placeholder="Enter Your Email"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="mobile_no" class="col-sm-2 control-label">Mobile*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control numeric required mobile_no numeric"  type="text" size="50" name="mobile_no" id="mobile_no" placeholder="Enter 10 digit mobile No"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="subject" class="col-sm-2 control-label">Subject*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control"  type="text" size="50" name="subject" id="subject" placeholder="Subject"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="message" class="col-sm-2 control-label">Message*</label>
                    <div class="col-sm-10">
                        <textarea class="large-form-control required"  type="text" height="250" name="message" id="message" placeholder="Message"></textarea>
                    </div>
                 </div>
                 <?php loader_set_session('form_session',rand(10,10000));?>
                 <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" hidden/>
                 <div class="form-group text-center">
                    <div class="">
                        <input type="submit" id="contact_form_button" name="contact_form_button" class="btn btn-large btn-default" value="Submit" />
                    </div>
                </div>
               </form>
           </div>
         <div class="col-sm-6 body_white_round text-center">
             <h4 class="text-center bold">HELPLINE NO</h4>
             <img class="margin-top-20" alt="mobile phone" src="images/contact.png"/>
             <h1 class="very-large-text"><?php loader_display(''.SUPPORT_CONTACT_NO.'')?></h1>
             <h1 class="very-large-text"><?php loader_display(''.COMPANY_EMAIL.'')?></h1>
         </div>
       </div>
     </div>
    </div>
  </section>  