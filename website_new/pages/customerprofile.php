<?php include(ACTION_PATH.'customerprofile_action.php')?>
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
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Welcome <?php loader_display($name) ?></h1>
        </div>
      </div>
     </div>
</section>
<section class="section">
    <div class="container">
      <div class="row body_white_round">
        <div class="form-group">
           <div class="col-sm-6">
               <label class="image-replace cd-username" for="signup_name">Full Name</label>
               <h3><?php loader_display($name) ?></h3>
               <label class="image-replace cd-mobile" for="signup_name">Mobile No</label>
               <h3><?php loader_display($mobile_no) ?></h3>
               <label class="image-replace cd-email" for="signup_name">Email Id</label>
               <h3><?php loader_display($email) ?></h3>
            </div>
            <div class="col-sm-6">
                <h3><a href="<?php loader_display(ROOT_PATH.'editcustomerprofile')?>">Edit Profile</a></h3>
                <h3><a href="<?php loader_display(ROOT_PATH.'changepassword')?>">Change Password</a></h3>
                <h3><a href="<?php loader_display(ROOT_PATH.'bookingstatus')?>">Booking Status</a></h3>
                <h3><a href="<?php loader_display(ROOT_PATH.'logout')?>">Logout</a></h3>
            </div>   
         </div>
      </div>
     </div>
</section>
