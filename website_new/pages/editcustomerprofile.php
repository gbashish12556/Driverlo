<?php include(ACTION_PATH.'editcustomerprofile_action.php')?>
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
          <h1 class="main_heading super  text-center">Edit Customer Profile</h1>
        </div>
      </div>
     </div>
</section>
<section class="section">
    <div class="container">
      <div class="row body_white_round">
       <form class="form" enctype="multipart/form-data" method="POST" action="<?php loader_display(ROOT_PATH.'editcustomerprofile')?>" >
               <div class="form-group">
                  <div class="col-sm-6 margin-bottom-10">
                    <div class= "form-group">
                      <label for="name" class="col-sm-2 control-label">Full Name*</label>
                         <div class="col-sm-10">
                    <input name="name" id="name" class="large-form-control required" value= "<?php loader_display($name)?>"   type="text" size="50" placeholder="Enter Full Name" /></div>
                    </div>
                   </div>
                  <div class="col-sm-6 margin-bottom-10">
                      <div class= "form-group">
                       <label for="resume" class="col-sm-2 control-label">Email Id*</label>
                       <div class="col-sm-10">
                      <input name="email" id="email" class="large-form-control required email" value= "<?php loader_display($email)?>" type="email" size="50" placeholder="Email ID"/></div>
                      </div>
                     </div>
               </div>
               <div class="form-group text-center">
                    <div class="">
                        <input type="submit" id="update_profile_button" name="update_profile_button" class="btn btn-large btn-default" value="Update" />
                    </div>
                </div>               
            </form>
      </div>
     </div>
</section>