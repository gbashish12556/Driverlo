<?php include(ACTION_PATH.'changepassword_action.php')?>
<section class="margin-bottom-10">
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
          <h1 class="main_heading super  text-center">Change Password</h1>
        </div>
      </div>
     </div>
</section>
<section class="section">
    <div class="container">
      <div class="row body_white_round">
       <form id="change_password_form" method="POST" action="<?php loader_display(ROOT_PATH.'changepassword')?>" >
               <div class="form-group">
                  <div class="col-sm-6 margin-bottom-10">
                    <div class= "form-group">
                      <label for="name" class="col-sm-2 control-label">Mobile No*</label>
                         <div class="col-sm-10">
                    <input name="mobile_no" id="mobile_no" class="large-form-control required numeric" value= "<?php loader_display($mobile_no)?>"   type="text" size="50" placeholder="Enter 10 Digit Mobile No" /></div>
                    </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                      <div class= "form-group">
                       <label for="resume" class="col-sm-2 control-label">Old Password*</label>
                       <div class="col-sm-10">
                      <input name="old_password" id="old_password" class="large-form-control required" value= "<?php loader_display($old_password)?>" type="password" size="50" placeholder="Old Password"/></div>
                      </div>
                     </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-6 margin-bottom-10">
                    <div class= "form-group">
                      <label for="name" class="col-sm-2 control-label">New Password*</label>
                         <div class="col-sm-10">
                    <input name="new_password" id="new_password" class="large-form-control required" value= "<?php loader_display($new_password)?>"   type="password" size="50" placeholder="New Password" /></div>
                    </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                      <div class= "form-group">
                       <label for="resume" class="col-sm-2 control-label">Confirm New Password*</label>
                       <div class="col-sm-10">
                      <input name="confirm_new_password" id="confirm_new_password" class="large-form-control required" value= "<?php loader_display($confirm_new_password)?>" type="password" size="50" placeholder="Confirm New Password"/></div>
                      </div>
                     </div>
               </div>
               <div class="form-group text-center">
                    <div class="">
                        <input type="submit" id="change_password_button" name="change_password_button" class="btn btn-large btn-default" value="Update" />
                    </div>
                </div>               
            </form>
      </div>
     </div>
</section>