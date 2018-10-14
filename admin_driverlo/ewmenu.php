<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(2, $Language->MenuPhrase("2", "MenuText"), "tbl_booking_detaillist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_booking_detail'), FALSE);
$RootMenu->AddMenuItem(5, $Language->MenuPhrase("5", "MenuText"), "tbl_customer_infolist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_customer_info'), FALSE);
$RootMenu->AddMenuItem(16, $Language->MenuPhrase("16", "MenuText"), "tbl_franchise_infolist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_franchise_info'), FALSE);
$RootMenu->AddMenuItem(6, $Language->MenuPhrase("6", "MenuText"), "tbl_driver_infolist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_driver_info'), FALSE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "tbl_fare_chartlist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_fare_chart'), FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "tbl_coupon_discountlist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_coupon_discount'), FALSE);
$RootMenu->AddMenuItem(12, $Language->MenuPhrase("12", "MenuText"), "tbl_adminlist.php", -1, "", AllowListMenu('{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}tbl_admin'), FALSE);
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "userlevelslist.php", -1, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(13, $Language->MenuPhrase("13", "MenuText"), "userlevelpermissionslist.php", -1, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
