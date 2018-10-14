<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Supr admin</title>
    <meta name="author" content="SuggeElson" />
    <meta name="description" content="Supr admin template - new premium responsive admin template. This template is designed to help you build the site administration without losing valuable time.Template contains all the important functions which must have one backend system.Build on great twitter boostrap framework" />
    <meta name="keywords" content="admin, admin template, admin theme, responsive, responsive admin, responsive admin template, responsive theme, themeforest, 960 grid system, grid, grid theme, liquid, masonry, jquery, administration, administration template, administration theme, mobile, touch , responsive layout, boostrap, twitter boostrap" />
    <meta name="application-name" content="Supr admin template" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Le styles -->

    <!-- Use new way for google web fonts 
    http://www.smashingmagazine.com/2012/07/11/avoiding-faux-weights-styles-google-web-fonts -->
    <link href='<?php loader_display(ROOT_PATH)?>css/open.sans400.css' rel='stylesheet' type='text/css' /> <!-- Headings -->
    <link href='<?php loader_display(ROOT_PATH)?>css/droid.sans400.css' rel='stylesheet' type='text/css' /> <!-- Text -->
    <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Core stylesheets do not remove -->
    <link href="<?php loader_display(ROOT_PATH)?>css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php loader_display(ROOT_PATH)?>css/bootstrap/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php loader_display(ROOT_PATH)?>css/supr-theme/jquery.ui.supr.css" rel="stylesheet" type="text/css"/>
    <link href="<?php loader_display(ROOT_PATH)?>css/icons.css" rel="stylesheet" type="text/css" />

    <!-- Plugin stylesheets -->
    <link href="<?php loader_display(ROOT_PATH)?>plugins/misc/qtip/jquery.qtip.css" rel="stylesheet" type="text/css" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/misc/datetime/datetimepicker.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/uniform/uniform.default.css" type="text/css" rel="stylesheet" />        
    <link href="<?php loader_display(ROOT_PATH)?>plugins/tables/dataTables/jquery.dataTables.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/inputlimiter/jquery.inputlimiter.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/togglebutton/toggle-buttons.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/color-picker/color-picker.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/select/select2.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/validate/validate.css" type="text/css" rel="stylesheet" />
    <link href="<?php loader_display(ROOT_PATH)?>plugins/forms/smartWizzard/smart_wizard.css" type="text/css" rel="stylesheet" />
    
    <!-- Main stylesheets -->
    <link href="<?php loader_display(ROOT_PATH)?>css/main.css" rel="stylesheet" type="text/css" /> 

    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="<?php loader_display(ROOT_PATH)?>css/custom.css" rel="stylesheet" type="text/css" />
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php loader_display(ROOT_PATH)?>images/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php loader_display(ROOT_PATH)?>images/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php loader_display(ROOT_PATH)?>images/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="<?php loader_display(ROOT_PATH)?>images/apple-touch-icon-57-precomposed.png" />
     <script  type="text/javascript" src="<?php loader_display(ROOT_PATH)?>js/jquery.min.js"></script>
     <script type="text/javascript" src="<?php loader_display(ROOT_PATH)?>js/jquery-ui.min.js"></script>
     <script type="text/javascript" src="<?php loader_display(ROOT_PATH)?>js/bootstrap.min.js"></script>
     <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyB16e-1Q6Ogfx3bEQ8AVY5R1NvMYNHkgok" type="text/javascript"></script>  
     <script>
     </script>
    </head>
    <body>
    <!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>
    <?php if($page != "admin_login"){
		$error_message = "";
		$result_no = 0;
		$query_no_new_order = "SELECT brn_no FROM view_booking_detail WHERE is_approved = '0' AND is_completed = '0' AND is_cancelled = '0'";
		if($result_no = loader_query($query_no_new_order)){
			$no_new_order = loader_num_rows($result_no);
		}else{
			$error_message = SERVER_ERROR;
		}
		?>
    <div id="header">
        <div class="navbar">
            <div class="navbar-inner">
              <div class="container-fluid">
                <a class="brand" href="dashboard.html"><span class="slogan">ADMIN123</span></a>
                <div class="nav-no-collapse">
                    <ul class="nav">
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'dashboard')?>"><span class="icon16 icomoon-icon-screen-2"></span> Dashboard</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'new_order')?>"> <span class="icon16 icomoon-icon-cart"></span>New Order <span class="notification"><?php loader_display($no_new_order);?></span></a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_new_order')?>"><span class="icon16 icomoon-icon-plus-2"></span>Order</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_customer')?>"><span class="icon16 icomoon-icon-plus-2"></span>Customer</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_franchise')?>"><span class="icon16 icomoon-icon-plus-2"></span>Franchise</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_driver')?>"><span class="icon16 icomoon-icon-plus-2"></span>Driver</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_coupon_discount')?>"><span class="icon16 icomoon-icon-plus-2"></span>Coupon Discount</a></li>
                        <li class="dropdown"><a href="<?php loader_display(ROOT_PATH.'create_fare_chart')?>"><span class="icon16 icomoon-icon-plus-2"></span>Fare Chart</a></li>
                    </ul>
                    <ul class="nav pull-right usernav">
                        <li><a href="<?php loader_display(ROOT_PATH.'logout')?>"><span class="icon16 icomoon-icon-exit"></span> Logout</a></li>
                    </ul>
                </div><!-- /.nav-collapse -->
                
              </div>
            </div><!-- /navbar-inner -->
          </div><!-- /navbar --> 
    </div><!-- End #header -->
    <?php }?>
