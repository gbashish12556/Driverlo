<?php include(ACTION_PATH.'admin_login_action.php')?> 
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
    <div class="container-fluid">
        <div id="">
            <div class="row-fluid">
                <div class="navbar">
                    <div class="navbar-inner">
                      <div class="container text-center">
                            <a class="brand" href="dashboard.html">DriverLo <span class="slogan">Admin</span></a>
                      </div>
                    </div><!-- /navbar-inner -->
                  </div><!-- /navbar -->
            </div><!-- End .row-fluid -->
        </div><!-- End #header -->
    </div><!-- End .container-fluid -->    
    <div class="container-fluid">
        <div class="loginContainer">
            <form class="form-horizontal" action="<?php loader_display(ROOT_PATH."admin_login")?>" id="loginForm" method="POST" >
                <div class="form-row row-fluid">
                    <div class="span12">
                        <div class="row-fluid">
                            <label class="form-label span12" for="username" >
                                Username:
                                <span class="icon16 icomoon-icon-user-3 right gray marginR10"></span>
                            </label>
                            <input class="span12 required" id="username" type="text" name="username" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="form-row row-fluid">
                    <div class="span12">
                        <div class="row-fluid">
                            <label class="form-label span12" for="password">
                                Password:
                                <span class="icon16 icomoon-icon-locked right gray marginR10"></span>
                                <span class="forgot"><a href="#">Forgot your password?</a></span>
                            </label>
                            <input class="span12 required" id="password" type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-row row-fluid">                       
                    <div class="span12">
                        <div class="row-fluid">
                            <div class="form-actions">
                            <div class="span12 controls">
                                <input type="checkbox" id="keepLoged" value="Value" class="styled" name="logged" /> Keep me logged in
                                <button type="submit" class="btn btn-info right" id="loginBtn"><span class="icon16 icomoon-icon-enter white"></span> Login</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>
        </div>
    </div><!-- End .container-fluid -->
    <script>
    			    <!--
    d=document;d.write('<a href="https://www.tyxo.bg/?138779" title="Tyxo.bg counter"><img width="1" height="1" border="0" alt="Tyxo.bg counter" src="'+location.protocol+'//cnt.tyxo.bg/138779?rnd='+Math.round(Math.random()*2147483647));
    d.write('&sp='+screen.width+'x'+screen.height+'&r='+escape(d.referrer)+'"></a>');
    </script>