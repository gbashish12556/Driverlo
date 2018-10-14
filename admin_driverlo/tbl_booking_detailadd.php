<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_booking_detailinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_booking_detail_add = NULL; // Initialize page object first

class ctbl_booking_detail_add extends ctbl_booking_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_booking_detail';

	// Page object name
	var $PageObjName = 'tbl_booking_detail_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tbl_booking_detail)
		if (!isset($GLOBALS["tbl_booking_detail"]) || get_class($GLOBALS["tbl_booking_detail"]) == "ctbl_booking_detail") {
			$GLOBALS["tbl_booking_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_booking_detail"];
		}

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_booking_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_booking_detaillist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["fld_booking_ai_id"] != "") {
				$this->fld_booking_ai_id->setQueryStringValue($_GET["fld_booking_ai_id"]);
				$this->setKey("fld_booking_ai_id", $this->fld_booking_ai_id->CurrentValue); // Set up key
			} else {
				$this->setKey("fld_booking_ai_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_booking_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_booking_detailview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->fld_pickup_point->CurrentValue = "N.A.";
		$this->fld_customer_name->CurrentValue = "DefaultIsNothing";
		$this->fld_mobile_no->CurrentValue = 0;
		$this->fld_booking_datetime->CurrentValue = NULL;
		$this->fld_booking_datetime->OldValue = $this->fld_booking_datetime->CurrentValue;
		$this->fld_coupon_code->CurrentValue = "N.A. ";
		$this->fld_driver_rating->CurrentValue = 0.00;
		$this->fld_customer_feedback->CurrentValue = "defaultStringIfNothingFound";
		$this->fld_is_cancelled->CurrentValue = "0";
		$this->fld_total_fare->CurrentValue = 0.00;
		$this->fld_booked_driver_id->CurrentValue = 0;
		$this->fld_is_approved->CurrentValue = "0";
		$this->fld_is_completed->CurrentValue = "0";
		$this->fld_is_active->CurrentValue = "1";
		$this->fld_created_on->CurrentValue = NULL;
		$this->fld_created_on->OldValue = $this->fld_created_on->CurrentValue;
		$this->fld_dropoff_point->CurrentValue = "N.A.";
		$this->fld_estimated_time->CurrentValue = "defaultStringIfNothingFound";
		$this->fld_estimated_fare->CurrentValue = 0;
		$this->fld_brn_no->CurrentValue = NULL;
		$this->fld_brn_no->OldValue = $this->fld_brn_no->CurrentValue;
		$this->fld_journey_type->CurrentValue = NULL;
		$this->fld_journey_type->OldValue = $this->fld_journey_type->CurrentValue;
		$this->fld_vehicle_type->CurrentValue = NULL;
		$this->fld_vehicle_type->OldValue = $this->fld_vehicle_type->CurrentValue;
		$this->fld_vehicle_mode->CurrentValue = NULL;
		$this->fld_vehicle_mode->OldValue = $this->fld_vehicle_mode->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fld_pickup_point->FldIsDetailKey) {
			$this->fld_pickup_point->setFormValue($objForm->GetValue("x_fld_pickup_point"));
		}
		if (!$this->fld_customer_name->FldIsDetailKey) {
			$this->fld_customer_name->setFormValue($objForm->GetValue("x_fld_customer_name"));
		}
		if (!$this->fld_mobile_no->FldIsDetailKey) {
			$this->fld_mobile_no->setFormValue($objForm->GetValue("x_fld_mobile_no"));
		}
		if (!$this->fld_booking_datetime->FldIsDetailKey) {
			$this->fld_booking_datetime->setFormValue($objForm->GetValue("x_fld_booking_datetime"));
			$this->fld_booking_datetime->CurrentValue = ew_UnFormatDateTime($this->fld_booking_datetime->CurrentValue, 9);
		}
		if (!$this->fld_coupon_code->FldIsDetailKey) {
			$this->fld_coupon_code->setFormValue($objForm->GetValue("x_fld_coupon_code"));
		}
		if (!$this->fld_driver_rating->FldIsDetailKey) {
			$this->fld_driver_rating->setFormValue($objForm->GetValue("x_fld_driver_rating"));
		}
		if (!$this->fld_customer_feedback->FldIsDetailKey) {
			$this->fld_customer_feedback->setFormValue($objForm->GetValue("x_fld_customer_feedback"));
		}
		if (!$this->fld_is_cancelled->FldIsDetailKey) {
			$this->fld_is_cancelled->setFormValue($objForm->GetValue("x_fld_is_cancelled"));
		}
		if (!$this->fld_total_fare->FldIsDetailKey) {
			$this->fld_total_fare->setFormValue($objForm->GetValue("x_fld_total_fare"));
		}
		if (!$this->fld_booked_driver_id->FldIsDetailKey) {
			$this->fld_booked_driver_id->setFormValue($objForm->GetValue("x_fld_booked_driver_id"));
		}
		if (!$this->fld_is_approved->FldIsDetailKey) {
			$this->fld_is_approved->setFormValue($objForm->GetValue("x_fld_is_approved"));
		}
		if (!$this->fld_is_completed->FldIsDetailKey) {
			$this->fld_is_completed->setFormValue($objForm->GetValue("x_fld_is_completed"));
		}
		if (!$this->fld_is_active->FldIsDetailKey) {
			$this->fld_is_active->setFormValue($objForm->GetValue("x_fld_is_active"));
		}
		if (!$this->fld_created_on->FldIsDetailKey) {
			$this->fld_created_on->setFormValue($objForm->GetValue("x_fld_created_on"));
			$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		}
		if (!$this->fld_dropoff_point->FldIsDetailKey) {
			$this->fld_dropoff_point->setFormValue($objForm->GetValue("x_fld_dropoff_point"));
		}
		if (!$this->fld_estimated_time->FldIsDetailKey) {
			$this->fld_estimated_time->setFormValue($objForm->GetValue("x_fld_estimated_time"));
		}
		if (!$this->fld_estimated_fare->FldIsDetailKey) {
			$this->fld_estimated_fare->setFormValue($objForm->GetValue("x_fld_estimated_fare"));
		}
		if (!$this->fld_brn_no->FldIsDetailKey) {
			$this->fld_brn_no->setFormValue($objForm->GetValue("x_fld_brn_no"));
		}
		if (!$this->fld_journey_type->FldIsDetailKey) {
			$this->fld_journey_type->setFormValue($objForm->GetValue("x_fld_journey_type"));
		}
		if (!$this->fld_vehicle_type->FldIsDetailKey) {
			$this->fld_vehicle_type->setFormValue($objForm->GetValue("x_fld_vehicle_type"));
		}
		if (!$this->fld_vehicle_mode->FldIsDetailKey) {
			$this->fld_vehicle_mode->setFormValue($objForm->GetValue("x_fld_vehicle_mode"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->fld_pickup_point->CurrentValue = $this->fld_pickup_point->FormValue;
		$this->fld_customer_name->CurrentValue = $this->fld_customer_name->FormValue;
		$this->fld_mobile_no->CurrentValue = $this->fld_mobile_no->FormValue;
		$this->fld_booking_datetime->CurrentValue = $this->fld_booking_datetime->FormValue;
		$this->fld_booking_datetime->CurrentValue = ew_UnFormatDateTime($this->fld_booking_datetime->CurrentValue, 9);
		$this->fld_coupon_code->CurrentValue = $this->fld_coupon_code->FormValue;
		$this->fld_driver_rating->CurrentValue = $this->fld_driver_rating->FormValue;
		$this->fld_customer_feedback->CurrentValue = $this->fld_customer_feedback->FormValue;
		$this->fld_is_cancelled->CurrentValue = $this->fld_is_cancelled->FormValue;
		$this->fld_total_fare->CurrentValue = $this->fld_total_fare->FormValue;
		$this->fld_booked_driver_id->CurrentValue = $this->fld_booked_driver_id->FormValue;
		$this->fld_is_approved->CurrentValue = $this->fld_is_approved->FormValue;
		$this->fld_is_completed->CurrentValue = $this->fld_is_completed->FormValue;
		$this->fld_is_active->CurrentValue = $this->fld_is_active->FormValue;
		$this->fld_created_on->CurrentValue = $this->fld_created_on->FormValue;
		$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		$this->fld_dropoff_point->CurrentValue = $this->fld_dropoff_point->FormValue;
		$this->fld_estimated_time->CurrentValue = $this->fld_estimated_time->FormValue;
		$this->fld_estimated_fare->CurrentValue = $this->fld_estimated_fare->FormValue;
		$this->fld_brn_no->CurrentValue = $this->fld_brn_no->FormValue;
		$this->fld_journey_type->CurrentValue = $this->fld_journey_type->FormValue;
		$this->fld_vehicle_type->CurrentValue = $this->fld_vehicle_type->FormValue;
		$this->fld_vehicle_mode->CurrentValue = $this->fld_vehicle_mode->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->fld_booking_ai_id->setDbValue($rs->fields('fld_booking_ai_id'));
		$this->fld_customer_token->setDbValue($rs->fields('fld_customer_token'));
		$this->fld_pickup_point->setDbValue($rs->fields('fld_pickup_point'));
		$this->fld_customer_name->setDbValue($rs->fields('fld_customer_name'));
		$this->fld_mobile_no->setDbValue($rs->fields('fld_mobile_no'));
		$this->fld_booking_datetime->setDbValue($rs->fields('fld_booking_datetime'));
		$this->fld_coupon_code->setDbValue($rs->fields('fld_coupon_code'));
		$this->fld_driver_rating->setDbValue($rs->fields('fld_driver_rating'));
		$this->fld_customer_feedback->setDbValue($rs->fields('fld_customer_feedback'));
		$this->fld_is_cancelled->setDbValue($rs->fields('fld_is_cancelled'));
		$this->fld_total_fare->setDbValue($rs->fields('fld_total_fare'));
		$this->fld_booked_driver_id->setDbValue($rs->fields('fld_booked_driver_id'));
		$this->fld_is_approved->setDbValue($rs->fields('fld_is_approved'));
		$this->fld_is_completed->setDbValue($rs->fields('fld_is_completed'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_dropoff_point->setDbValue($rs->fields('fld_dropoff_point'));
		$this->fld_estimated_time->setDbValue($rs->fields('fld_estimated_time'));
		$this->fld_estimated_fare->setDbValue($rs->fields('fld_estimated_fare'));
		$this->fld_brn_no->setDbValue($rs->fields('fld_brn_no'));
		$this->fld_journey_type->setDbValue($rs->fields('fld_journey_type'));
		$this->fld_vehicle_type->setDbValue($rs->fields('fld_vehicle_type'));
		$this->fld_vehicle_mode->setDbValue($rs->fields('fld_vehicle_mode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_booking_ai_id->DbValue = $row['fld_booking_ai_id'];
		$this->fld_customer_token->DbValue = $row['fld_customer_token'];
		$this->fld_pickup_point->DbValue = $row['fld_pickup_point'];
		$this->fld_customer_name->DbValue = $row['fld_customer_name'];
		$this->fld_mobile_no->DbValue = $row['fld_mobile_no'];
		$this->fld_booking_datetime->DbValue = $row['fld_booking_datetime'];
		$this->fld_coupon_code->DbValue = $row['fld_coupon_code'];
		$this->fld_driver_rating->DbValue = $row['fld_driver_rating'];
		$this->fld_customer_feedback->DbValue = $row['fld_customer_feedback'];
		$this->fld_is_cancelled->DbValue = $row['fld_is_cancelled'];
		$this->fld_total_fare->DbValue = $row['fld_total_fare'];
		$this->fld_booked_driver_id->DbValue = $row['fld_booked_driver_id'];
		$this->fld_is_approved->DbValue = $row['fld_is_approved'];
		$this->fld_is_completed->DbValue = $row['fld_is_completed'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
		$this->fld_dropoff_point->DbValue = $row['fld_dropoff_point'];
		$this->fld_estimated_time->DbValue = $row['fld_estimated_time'];
		$this->fld_estimated_fare->DbValue = $row['fld_estimated_fare'];
		$this->fld_brn_no->DbValue = $row['fld_brn_no'];
		$this->fld_journey_type->DbValue = $row['fld_journey_type'];
		$this->fld_vehicle_type->DbValue = $row['fld_vehicle_type'];
		$this->fld_vehicle_mode->DbValue = $row['fld_vehicle_mode'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("fld_booking_ai_id")) <> "")
			$this->fld_booking_ai_id->CurrentValue = $this->getKey("fld_booking_ai_id"); // fld_booking_ai_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->fld_driver_rating->FormValue == $this->fld_driver_rating->CurrentValue && is_numeric(ew_StrToFloat($this->fld_driver_rating->CurrentValue)))
			$this->fld_driver_rating->CurrentValue = ew_StrToFloat($this->fld_driver_rating->CurrentValue);

		// Convert decimal values if posted back
		if ($this->fld_total_fare->FormValue == $this->fld_total_fare->CurrentValue && is_numeric(ew_StrToFloat($this->fld_total_fare->CurrentValue)))
			$this->fld_total_fare->CurrentValue = ew_StrToFloat($this->fld_total_fare->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_booking_ai_id
		// fld_customer_token
		// fld_pickup_point
		// fld_customer_name
		// fld_mobile_no
		// fld_booking_datetime
		// fld_coupon_code
		// fld_driver_rating
		// fld_customer_feedback
		// fld_is_cancelled
		// fld_total_fare
		// fld_booked_driver_id
		// fld_is_approved
		// fld_is_completed
		// fld_is_active
		// fld_created_on
		// fld_dropoff_point
		// fld_estimated_time
		// fld_estimated_fare
		// fld_brn_no
		// fld_journey_type
		// fld_vehicle_type
		// fld_vehicle_mode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_booking_ai_id
			$this->fld_booking_ai_id->ViewValue = $this->fld_booking_ai_id->CurrentValue;
			$this->fld_booking_ai_id->ViewCustomAttributes = "";

			// fld_pickup_point
			$this->fld_pickup_point->ViewValue = $this->fld_pickup_point->CurrentValue;
			$this->fld_pickup_point->ViewCustomAttributes = "";

			// fld_customer_name
			$this->fld_customer_name->ViewValue = $this->fld_customer_name->CurrentValue;
			$this->fld_customer_name->ViewCustomAttributes = "";

			// fld_mobile_no
			$this->fld_mobile_no->ViewValue = $this->fld_mobile_no->CurrentValue;
			$this->fld_mobile_no->ViewCustomAttributes = "";

			// fld_booking_datetime
			$this->fld_booking_datetime->ViewValue = $this->fld_booking_datetime->CurrentValue;
			$this->fld_booking_datetime->ViewValue = ew_FormatDateTime($this->fld_booking_datetime->ViewValue, 9);
			$this->fld_booking_datetime->ViewCustomAttributes = "";

			// fld_coupon_code
			$this->fld_coupon_code->ViewValue = $this->fld_coupon_code->CurrentValue;
			$this->fld_coupon_code->ViewCustomAttributes = "";

			// fld_driver_rating
			$this->fld_driver_rating->ViewValue = $this->fld_driver_rating->CurrentValue;
			$this->fld_driver_rating->ViewCustomAttributes = "";

			// fld_customer_feedback
			$this->fld_customer_feedback->ViewValue = $this->fld_customer_feedback->CurrentValue;
			$this->fld_customer_feedback->ViewCustomAttributes = "";

			// fld_is_cancelled
			if (ew_ConvertToBool($this->fld_is_cancelled->CurrentValue)) {
				$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(1) <> "" ? $this->fld_is_cancelled->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(2) <> "" ? $this->fld_is_cancelled->FldTagCaption(2) : "0";
			}
			$this->fld_is_cancelled->ViewCustomAttributes = "";

			// fld_total_fare
			$this->fld_total_fare->ViewValue = $this->fld_total_fare->CurrentValue;
			$this->fld_total_fare->ViewCustomAttributes = "";

			// fld_booked_driver_id
			if (strval($this->fld_booked_driver_id->CurrentValue) <> "") {
				$sFilterWrk = "`fld_driver_ai_id`" . ew_SearchString("=", $this->fld_booked_driver_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `fld_driver_ai_id`, `fld_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_driver_info`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->fld_booked_driver_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->fld_booked_driver_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->fld_booked_driver_id->ViewValue = $this->fld_booked_driver_id->CurrentValue;
				}
			} else {
				$this->fld_booked_driver_id->ViewValue = NULL;
			}
			$this->fld_booked_driver_id->ViewCustomAttributes = "";

			// fld_is_approved
			if (ew_ConvertToBool($this->fld_is_approved->CurrentValue)) {
				$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(1) <> "" ? $this->fld_is_approved->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(2) <> "" ? $this->fld_is_approved->FldTagCaption(2) : "0";
			}
			$this->fld_is_approved->ViewCustomAttributes = "";

			// fld_is_completed
			if (ew_ConvertToBool($this->fld_is_completed->CurrentValue)) {
				$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(1) <> "" ? $this->fld_is_completed->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(2) <> "" ? $this->fld_is_completed->FldTagCaption(2) : "0";
			}
			$this->fld_is_completed->ViewCustomAttributes = "";

			// fld_is_active
			if (ew_ConvertToBool($this->fld_is_active->CurrentValue)) {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : "0";
			}
			$this->fld_is_active->ViewCustomAttributes = "";

			// fld_created_on
			$this->fld_created_on->ViewValue = $this->fld_created_on->CurrentValue;
			$this->fld_created_on->ViewValue = ew_FormatDateTime($this->fld_created_on->ViewValue, 9);
			$this->fld_created_on->ViewCustomAttributes = "";

			// fld_dropoff_point
			$this->fld_dropoff_point->ViewValue = $this->fld_dropoff_point->CurrentValue;
			$this->fld_dropoff_point->ViewCustomAttributes = "";

			// fld_estimated_time
			$this->fld_estimated_time->ViewValue = $this->fld_estimated_time->CurrentValue;
			$this->fld_estimated_time->ViewCustomAttributes = "";

			// fld_estimated_fare
			$this->fld_estimated_fare->ViewValue = $this->fld_estimated_fare->CurrentValue;
			$this->fld_estimated_fare->ViewCustomAttributes = "";

			// fld_brn_no
			$this->fld_brn_no->ViewValue = $this->fld_brn_no->CurrentValue;
			$this->fld_brn_no->ViewCustomAttributes = "";

			// fld_journey_type
			if (strval($this->fld_journey_type->CurrentValue) <> "") {
				switch ($this->fld_journey_type->CurrentValue) {
					case $this->fld_journey_type->FldTagValue(1):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(1) <> "" ? $this->fld_journey_type->FldTagCaption(1) : $this->fld_journey_type->CurrentValue;
						break;
					case $this->fld_journey_type->FldTagValue(2):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(2) <> "" ? $this->fld_journey_type->FldTagCaption(2) : $this->fld_journey_type->CurrentValue;
						break;
					case $this->fld_journey_type->FldTagValue(3):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(3) <> "" ? $this->fld_journey_type->FldTagCaption(3) : $this->fld_journey_type->CurrentValue;
						break;
					default:
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->CurrentValue;
				}
			} else {
				$this->fld_journey_type->ViewValue = NULL;
			}
			$this->fld_journey_type->ViewCustomAttributes = "";

			// fld_vehicle_type
			if (strval($this->fld_vehicle_type->CurrentValue) <> "") {
				switch ($this->fld_vehicle_type->CurrentValue) {
					case $this->fld_vehicle_type->FldTagValue(1):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(1) <> "" ? $this->fld_vehicle_type->FldTagCaption(1) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(2):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(2) <> "" ? $this->fld_vehicle_type->FldTagCaption(2) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(3):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(3) <> "" ? $this->fld_vehicle_type->FldTagCaption(3) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(4):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(4) <> "" ? $this->fld_vehicle_type->FldTagCaption(4) : $this->fld_vehicle_type->CurrentValue;
						break;
					default:
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->CurrentValue;
				}
			} else {
				$this->fld_vehicle_type->ViewValue = NULL;
			}
			$this->fld_vehicle_type->ViewCustomAttributes = "";

			// fld_vehicle_mode
			if (strval($this->fld_vehicle_mode->CurrentValue) <> "") {
				switch ($this->fld_vehicle_mode->CurrentValue) {
					case $this->fld_vehicle_mode->FldTagValue(1):
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(1) <> "" ? $this->fld_vehicle_mode->FldTagCaption(1) : $this->fld_vehicle_mode->CurrentValue;
						break;
					case $this->fld_vehicle_mode->FldTagValue(2):
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(2) <> "" ? $this->fld_vehicle_mode->FldTagCaption(2) : $this->fld_vehicle_mode->CurrentValue;
						break;
					default:
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->CurrentValue;
				}
			} else {
				$this->fld_vehicle_mode->ViewValue = NULL;
			}
			$this->fld_vehicle_mode->ViewCustomAttributes = "";

			// fld_pickup_point
			$this->fld_pickup_point->LinkCustomAttributes = "";
			$this->fld_pickup_point->HrefValue = "";
			$this->fld_pickup_point->TooltipValue = "";

			// fld_customer_name
			$this->fld_customer_name->LinkCustomAttributes = "";
			$this->fld_customer_name->HrefValue = "";
			$this->fld_customer_name->TooltipValue = "";

			// fld_mobile_no
			$this->fld_mobile_no->LinkCustomAttributes = "";
			$this->fld_mobile_no->HrefValue = "";
			$this->fld_mobile_no->TooltipValue = "";

			// fld_booking_datetime
			$this->fld_booking_datetime->LinkCustomAttributes = "";
			$this->fld_booking_datetime->HrefValue = "";
			$this->fld_booking_datetime->TooltipValue = "";

			// fld_coupon_code
			$this->fld_coupon_code->LinkCustomAttributes = "";
			$this->fld_coupon_code->HrefValue = "";
			$this->fld_coupon_code->TooltipValue = "";

			// fld_driver_rating
			$this->fld_driver_rating->LinkCustomAttributes = "";
			$this->fld_driver_rating->HrefValue = "";
			$this->fld_driver_rating->TooltipValue = "";

			// fld_customer_feedback
			$this->fld_customer_feedback->LinkCustomAttributes = "";
			$this->fld_customer_feedback->HrefValue = "";
			$this->fld_customer_feedback->TooltipValue = "";

			// fld_is_cancelled
			$this->fld_is_cancelled->LinkCustomAttributes = "";
			$this->fld_is_cancelled->HrefValue = "";
			$this->fld_is_cancelled->TooltipValue = "";

			// fld_total_fare
			$this->fld_total_fare->LinkCustomAttributes = "";
			$this->fld_total_fare->HrefValue = "";
			$this->fld_total_fare->TooltipValue = "";

			// fld_booked_driver_id
			$this->fld_booked_driver_id->LinkCustomAttributes = "";
			$this->fld_booked_driver_id->HrefValue = "";
			$this->fld_booked_driver_id->TooltipValue = "";

			// fld_is_approved
			$this->fld_is_approved->LinkCustomAttributes = "";
			$this->fld_is_approved->HrefValue = "";
			$this->fld_is_approved->TooltipValue = "";

			// fld_is_completed
			$this->fld_is_completed->LinkCustomAttributes = "";
			$this->fld_is_completed->HrefValue = "";
			$this->fld_is_completed->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";

			// fld_dropoff_point
			$this->fld_dropoff_point->LinkCustomAttributes = "";
			$this->fld_dropoff_point->HrefValue = "";
			$this->fld_dropoff_point->TooltipValue = "";

			// fld_estimated_time
			$this->fld_estimated_time->LinkCustomAttributes = "";
			$this->fld_estimated_time->HrefValue = "";
			$this->fld_estimated_time->TooltipValue = "";

			// fld_estimated_fare
			$this->fld_estimated_fare->LinkCustomAttributes = "";
			$this->fld_estimated_fare->HrefValue = "";
			$this->fld_estimated_fare->TooltipValue = "";

			// fld_brn_no
			$this->fld_brn_no->LinkCustomAttributes = "";
			$this->fld_brn_no->HrefValue = "";
			$this->fld_brn_no->TooltipValue = "";

			// fld_journey_type
			$this->fld_journey_type->LinkCustomAttributes = "";
			$this->fld_journey_type->HrefValue = "";
			$this->fld_journey_type->TooltipValue = "";

			// fld_vehicle_type
			$this->fld_vehicle_type->LinkCustomAttributes = "";
			$this->fld_vehicle_type->HrefValue = "";
			$this->fld_vehicle_type->TooltipValue = "";

			// fld_vehicle_mode
			$this->fld_vehicle_mode->LinkCustomAttributes = "";
			$this->fld_vehicle_mode->HrefValue = "";
			$this->fld_vehicle_mode->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fld_pickup_point
			$this->fld_pickup_point->EditCustomAttributes = "";
			$this->fld_pickup_point->EditValue = ew_HtmlEncode($this->fld_pickup_point->CurrentValue);
			$this->fld_pickup_point->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_pickup_point->FldCaption()));

			// fld_customer_name
			$this->fld_customer_name->EditCustomAttributes = "";
			$this->fld_customer_name->EditValue = ew_HtmlEncode($this->fld_customer_name->CurrentValue);
			$this->fld_customer_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_customer_name->FldCaption()));

			// fld_mobile_no
			$this->fld_mobile_no->EditCustomAttributes = "";
			$this->fld_mobile_no->EditValue = ew_HtmlEncode($this->fld_mobile_no->CurrentValue);
			$this->fld_mobile_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_mobile_no->FldCaption()));

			// fld_booking_datetime
			$this->fld_booking_datetime->EditCustomAttributes = "";
			$this->fld_booking_datetime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fld_booking_datetime->CurrentValue, 9));
			$this->fld_booking_datetime->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_booking_datetime->FldCaption()));

			// fld_coupon_code
			$this->fld_coupon_code->EditCustomAttributes = "";
			$this->fld_coupon_code->EditValue = ew_HtmlEncode($this->fld_coupon_code->CurrentValue);
			$this->fld_coupon_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_coupon_code->FldCaption()));

			// fld_driver_rating
			$this->fld_driver_rating->EditCustomAttributes = "";
			$this->fld_driver_rating->EditValue = ew_HtmlEncode($this->fld_driver_rating->CurrentValue);
			$this->fld_driver_rating->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_driver_rating->FldCaption()));
			if (strval($this->fld_driver_rating->EditValue) <> "" && is_numeric($this->fld_driver_rating->EditValue)) $this->fld_driver_rating->EditValue = ew_FormatNumber($this->fld_driver_rating->EditValue, -2, -1, -2, 0);

			// fld_customer_feedback
			$this->fld_customer_feedback->EditCustomAttributes = "";
			$this->fld_customer_feedback->EditValue = ew_HtmlEncode($this->fld_customer_feedback->CurrentValue);
			$this->fld_customer_feedback->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_customer_feedback->FldCaption()));

			// fld_is_cancelled
			$this->fld_is_cancelled->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_cancelled->FldTagValue(1), $this->fld_is_cancelled->FldTagCaption(1) <> "" ? $this->fld_is_cancelled->FldTagCaption(1) : $this->fld_is_cancelled->FldTagValue(1));
			$arwrk[] = array($this->fld_is_cancelled->FldTagValue(2), $this->fld_is_cancelled->FldTagCaption(2) <> "" ? $this->fld_is_cancelled->FldTagCaption(2) : $this->fld_is_cancelled->FldTagValue(2));
			$this->fld_is_cancelled->EditValue = $arwrk;

			// fld_total_fare
			$this->fld_total_fare->EditCustomAttributes = "";
			$this->fld_total_fare->EditValue = ew_HtmlEncode($this->fld_total_fare->CurrentValue);
			$this->fld_total_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_total_fare->FldCaption()));
			if (strval($this->fld_total_fare->EditValue) <> "" && is_numeric($this->fld_total_fare->EditValue)) $this->fld_total_fare->EditValue = ew_FormatNumber($this->fld_total_fare->EditValue, -2, -1, -2, 0);

			// fld_booked_driver_id
			$this->fld_booked_driver_id->EditCustomAttributes = "";
			if (trim(strval($this->fld_booked_driver_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`fld_driver_ai_id`" . ew_SearchString("=", $this->fld_booked_driver_id->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `fld_driver_ai_id`, `fld_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_driver_info`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->fld_booked_driver_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->fld_booked_driver_id->EditValue = $arwrk;

			// fld_is_approved
			$this->fld_is_approved->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_approved->FldTagValue(1), $this->fld_is_approved->FldTagCaption(1) <> "" ? $this->fld_is_approved->FldTagCaption(1) : $this->fld_is_approved->FldTagValue(1));
			$arwrk[] = array($this->fld_is_approved->FldTagValue(2), $this->fld_is_approved->FldTagCaption(2) <> "" ? $this->fld_is_approved->FldTagCaption(2) : $this->fld_is_approved->FldTagValue(2));
			$this->fld_is_approved->EditValue = $arwrk;

			// fld_is_completed
			$this->fld_is_completed->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_completed->FldTagValue(1), $this->fld_is_completed->FldTagCaption(1) <> "" ? $this->fld_is_completed->FldTagCaption(1) : $this->fld_is_completed->FldTagValue(1));
			$arwrk[] = array($this->fld_is_completed->FldTagValue(2), $this->fld_is_completed->FldTagCaption(2) <> "" ? $this->fld_is_completed->FldTagCaption(2) : $this->fld_is_completed->FldTagValue(2));
			$this->fld_is_completed->EditValue = $arwrk;

			// fld_is_active
			$this->fld_is_active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_active->FldTagValue(1), $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : $this->fld_is_active->FldTagValue(1));
			$arwrk[] = array($this->fld_is_active->FldTagValue(2), $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : $this->fld_is_active->FldTagValue(2));
			$this->fld_is_active->EditValue = $arwrk;

			// fld_created_on
			$this->fld_created_on->EditCustomAttributes = "";
			$this->fld_created_on->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fld_created_on->CurrentValue, 9));
			$this->fld_created_on->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_created_on->FldCaption()));

			// fld_dropoff_point
			$this->fld_dropoff_point->EditCustomAttributes = "";
			$this->fld_dropoff_point->EditValue = ew_HtmlEncode($this->fld_dropoff_point->CurrentValue);
			$this->fld_dropoff_point->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_dropoff_point->FldCaption()));

			// fld_estimated_time
			$this->fld_estimated_time->EditCustomAttributes = "";
			$this->fld_estimated_time->EditValue = ew_HtmlEncode($this->fld_estimated_time->CurrentValue);
			$this->fld_estimated_time->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_estimated_time->FldCaption()));

			// fld_estimated_fare
			$this->fld_estimated_fare->EditCustomAttributes = "";
			$this->fld_estimated_fare->EditValue = ew_HtmlEncode($this->fld_estimated_fare->CurrentValue);
			$this->fld_estimated_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_estimated_fare->FldCaption()));

			// fld_brn_no
			$this->fld_brn_no->EditCustomAttributes = "";
			$this->fld_brn_no->EditValue = ew_HtmlEncode($this->fld_brn_no->CurrentValue);
			$this->fld_brn_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_brn_no->FldCaption()));

			// fld_journey_type
			$this->fld_journey_type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_journey_type->FldTagValue(1), $this->fld_journey_type->FldTagCaption(1) <> "" ? $this->fld_journey_type->FldTagCaption(1) : $this->fld_journey_type->FldTagValue(1));
			$arwrk[] = array($this->fld_journey_type->FldTagValue(2), $this->fld_journey_type->FldTagCaption(2) <> "" ? $this->fld_journey_type->FldTagCaption(2) : $this->fld_journey_type->FldTagValue(2));
			$arwrk[] = array($this->fld_journey_type->FldTagValue(3), $this->fld_journey_type->FldTagCaption(3) <> "" ? $this->fld_journey_type->FldTagCaption(3) : $this->fld_journey_type->FldTagValue(3));
			$this->fld_journey_type->EditValue = $arwrk;

			// fld_vehicle_type
			$this->fld_vehicle_type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(1), $this->fld_vehicle_type->FldTagCaption(1) <> "" ? $this->fld_vehicle_type->FldTagCaption(1) : $this->fld_vehicle_type->FldTagValue(1));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(2), $this->fld_vehicle_type->FldTagCaption(2) <> "" ? $this->fld_vehicle_type->FldTagCaption(2) : $this->fld_vehicle_type->FldTagValue(2));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(3), $this->fld_vehicle_type->FldTagCaption(3) <> "" ? $this->fld_vehicle_type->FldTagCaption(3) : $this->fld_vehicle_type->FldTagValue(3));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(4), $this->fld_vehicle_type->FldTagCaption(4) <> "" ? $this->fld_vehicle_type->FldTagCaption(4) : $this->fld_vehicle_type->FldTagValue(4));
			$this->fld_vehicle_type->EditValue = $arwrk;

			// fld_vehicle_mode
			$this->fld_vehicle_mode->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_vehicle_mode->FldTagValue(1), $this->fld_vehicle_mode->FldTagCaption(1) <> "" ? $this->fld_vehicle_mode->FldTagCaption(1) : $this->fld_vehicle_mode->FldTagValue(1));
			$arwrk[] = array($this->fld_vehicle_mode->FldTagValue(2), $this->fld_vehicle_mode->FldTagCaption(2) <> "" ? $this->fld_vehicle_mode->FldTagCaption(2) : $this->fld_vehicle_mode->FldTagValue(2));
			$this->fld_vehicle_mode->EditValue = $arwrk;

			// Edit refer script
			// fld_pickup_point

			$this->fld_pickup_point->HrefValue = "";

			// fld_customer_name
			$this->fld_customer_name->HrefValue = "";

			// fld_mobile_no
			$this->fld_mobile_no->HrefValue = "";

			// fld_booking_datetime
			$this->fld_booking_datetime->HrefValue = "";

			// fld_coupon_code
			$this->fld_coupon_code->HrefValue = "";

			// fld_driver_rating
			$this->fld_driver_rating->HrefValue = "";

			// fld_customer_feedback
			$this->fld_customer_feedback->HrefValue = "";

			// fld_is_cancelled
			$this->fld_is_cancelled->HrefValue = "";

			// fld_total_fare
			$this->fld_total_fare->HrefValue = "";

			// fld_booked_driver_id
			$this->fld_booked_driver_id->HrefValue = "";

			// fld_is_approved
			$this->fld_is_approved->HrefValue = "";

			// fld_is_completed
			$this->fld_is_completed->HrefValue = "";

			// fld_is_active
			$this->fld_is_active->HrefValue = "";

			// fld_created_on
			$this->fld_created_on->HrefValue = "";

			// fld_dropoff_point
			$this->fld_dropoff_point->HrefValue = "";

			// fld_estimated_time
			$this->fld_estimated_time->HrefValue = "";

			// fld_estimated_fare
			$this->fld_estimated_fare->HrefValue = "";

			// fld_brn_no
			$this->fld_brn_no->HrefValue = "";

			// fld_journey_type
			$this->fld_journey_type->HrefValue = "";

			// fld_vehicle_type
			$this->fld_vehicle_type->HrefValue = "";

			// fld_vehicle_mode
			$this->fld_vehicle_mode->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->fld_pickup_point->FldIsDetailKey && !is_null($this->fld_pickup_point->FormValue) && $this->fld_pickup_point->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_pickup_point->FldCaption());
		}
		if (!$this->fld_customer_name->FldIsDetailKey && !is_null($this->fld_customer_name->FormValue) && $this->fld_customer_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_customer_name->FldCaption());
		}
		if (!$this->fld_mobile_no->FldIsDetailKey && !is_null($this->fld_mobile_no->FormValue) && $this->fld_mobile_no->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_mobile_no->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_mobile_no->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_mobile_no->FldErrMsg());
		}
		if (!$this->fld_booking_datetime->FldIsDetailKey && !is_null($this->fld_booking_datetime->FormValue) && $this->fld_booking_datetime->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_booking_datetime->FldCaption());
		}
		if (!ew_CheckDate($this->fld_booking_datetime->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_booking_datetime->FldErrMsg());
		}
		if (!$this->fld_driver_rating->FldIsDetailKey && !is_null($this->fld_driver_rating->FormValue) && $this->fld_driver_rating->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_driver_rating->FldCaption());
		}
		if (!ew_CheckNumber($this->fld_driver_rating->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_driver_rating->FldErrMsg());
		}
		if (!$this->fld_customer_feedback->FldIsDetailKey && !is_null($this->fld_customer_feedback->FormValue) && $this->fld_customer_feedback->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_customer_feedback->FldCaption());
		}
		if ($this->fld_is_cancelled->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_cancelled->FldCaption());
		}
		if (!$this->fld_total_fare->FldIsDetailKey && !is_null($this->fld_total_fare->FormValue) && $this->fld_total_fare->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_total_fare->FldCaption());
		}
		if (!ew_CheckNumber($this->fld_total_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_total_fare->FldErrMsg());
		}
		if ($this->fld_is_completed->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_completed->FldCaption());
		}
		if (!$this->fld_created_on->FldIsDetailKey && !is_null($this->fld_created_on->FormValue) && $this->fld_created_on->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_created_on->FldCaption());
		}
		if (!ew_CheckDate($this->fld_created_on->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_created_on->FldErrMsg());
		}
		if (!ew_CheckInteger($this->fld_estimated_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_estimated_fare->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		if ($this->fld_brn_no->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(fld_brn_no = '" . ew_AdjustSql($this->fld_brn_no->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->fld_brn_no->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->fld_brn_no->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// fld_pickup_point
		$this->fld_pickup_point->SetDbValueDef($rsnew, $this->fld_pickup_point->CurrentValue, NULL, strval($this->fld_pickup_point->CurrentValue) == "");

		// fld_customer_name
		$this->fld_customer_name->SetDbValueDef($rsnew, $this->fld_customer_name->CurrentValue, NULL, strval($this->fld_customer_name->CurrentValue) == "");

		// fld_mobile_no
		$this->fld_mobile_no->SetDbValueDef($rsnew, $this->fld_mobile_no->CurrentValue, NULL, strval($this->fld_mobile_no->CurrentValue) == "");

		// fld_booking_datetime
		$this->fld_booking_datetime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fld_booking_datetime->CurrentValue, 9), NULL, FALSE);

		// fld_coupon_code
		$this->fld_coupon_code->SetDbValueDef($rsnew, $this->fld_coupon_code->CurrentValue, NULL, strval($this->fld_coupon_code->CurrentValue) == "");

		// fld_driver_rating
		$this->fld_driver_rating->SetDbValueDef($rsnew, $this->fld_driver_rating->CurrentValue, 0, strval($this->fld_driver_rating->CurrentValue) == "");

		// fld_customer_feedback
		$this->fld_customer_feedback->SetDbValueDef($rsnew, $this->fld_customer_feedback->CurrentValue, "", strval($this->fld_customer_feedback->CurrentValue) == "");

		// fld_is_cancelled
		$this->fld_is_cancelled->SetDbValueDef($rsnew, ((strval($this->fld_is_cancelled->CurrentValue) == "1") ? "1" : "0"), 0, strval($this->fld_is_cancelled->CurrentValue) == "");

		// fld_total_fare
		$this->fld_total_fare->SetDbValueDef($rsnew, $this->fld_total_fare->CurrentValue, NULL, strval($this->fld_total_fare->CurrentValue) == "");

		// fld_booked_driver_id
		$this->fld_booked_driver_id->SetDbValueDef($rsnew, $this->fld_booked_driver_id->CurrentValue, NULL, strval($this->fld_booked_driver_id->CurrentValue) == "");

		// fld_is_approved
		$this->fld_is_approved->SetDbValueDef($rsnew, ((strval($this->fld_is_approved->CurrentValue) == "1") ? "1" : "0"), NULL, strval($this->fld_is_approved->CurrentValue) == "");

		// fld_is_completed
		$this->fld_is_completed->SetDbValueDef($rsnew, ((strval($this->fld_is_completed->CurrentValue) == "1") ? "1" : "0"), 0, strval($this->fld_is_completed->CurrentValue) == "");

		// fld_is_active
		$this->fld_is_active->SetDbValueDef($rsnew, ((strval($this->fld_is_active->CurrentValue) == "1") ? "1" : "0"), NULL, strval($this->fld_is_active->CurrentValue) == "");

		// fld_created_on
		$this->fld_created_on->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9), NULL, FALSE);

		// fld_dropoff_point
		$this->fld_dropoff_point->SetDbValueDef($rsnew, $this->fld_dropoff_point->CurrentValue, NULL, strval($this->fld_dropoff_point->CurrentValue) == "");

		// fld_estimated_time
		$this->fld_estimated_time->SetDbValueDef($rsnew, $this->fld_estimated_time->CurrentValue, NULL, strval($this->fld_estimated_time->CurrentValue) == "");

		// fld_estimated_fare
		$this->fld_estimated_fare->SetDbValueDef($rsnew, $this->fld_estimated_fare->CurrentValue, NULL, strval($this->fld_estimated_fare->CurrentValue) == "");

		// fld_brn_no
		$this->fld_brn_no->SetDbValueDef($rsnew, $this->fld_brn_no->CurrentValue, NULL, FALSE);

		// fld_journey_type
		$this->fld_journey_type->SetDbValueDef($rsnew, $this->fld_journey_type->CurrentValue, NULL, FALSE);

		// fld_vehicle_type
		$this->fld_vehicle_type->SetDbValueDef($rsnew, $this->fld_vehicle_type->CurrentValue, NULL, FALSE);

		// fld_vehicle_mode
		$this->fld_vehicle_mode->SetDbValueDef($rsnew, $this->fld_vehicle_mode->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->fld_booking_ai_id->setDbValue($conn->Insert_ID());
			$rsnew['fld_booking_ai_id'] = $this->fld_booking_ai_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "tbl_booking_detaillist.php", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_booking_detail_add)) $tbl_booking_detail_add = new ctbl_booking_detail_add();

// Page init
$tbl_booking_detail_add->Page_Init();

// Page main
$tbl_booking_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_booking_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_booking_detail_add = new ew_Page("tbl_booking_detail_add");
tbl_booking_detail_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_booking_detail_add.PageID; // For backward compatibility

// Form object
var ftbl_booking_detailadd = new ew_Form("ftbl_booking_detailadd");

// Validate form
ftbl_booking_detailadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_fld_pickup_point");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_pickup_point->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_customer_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_customer_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_mobile_no");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_mobile_no->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_mobile_no");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_mobile_no->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_booking_datetime");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_booking_datetime->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_booking_datetime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_booking_datetime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_driver_rating");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_driver_rating->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_driver_rating");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_driver_rating->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_customer_feedback");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_customer_feedback->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_cancelled");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_is_cancelled->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_total_fare");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_total_fare->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_total_fare");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_total_fare->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_completed");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_is_completed->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_booking_detail->fld_created_on->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_created_on->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_estimated_fare");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_booking_detail->fld_estimated_fare->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftbl_booking_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_booking_detailadd.ValidateRequired = true;
<?php } else { ?>
ftbl_booking_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_booking_detailadd.Lists["x_fld_booked_driver_id"] = {"LinkField":"x_fld_driver_ai_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fld_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_booking_detail_add->ShowPageHeader(); ?>
<?php
$tbl_booking_detail_add->ShowMessage();
?>
<form name="ftbl_booking_detailadd" id="ftbl_booking_detailadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_booking_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_booking_detailadd" class="table table-bordered table-striped">
<?php if ($tbl_booking_detail->fld_pickup_point->Visible) { // fld_pickup_point ?>
	<tr id="r_fld_pickup_point">
		<td><span id="elh_tbl_booking_detail_fld_pickup_point"><?php echo $tbl_booking_detail->fld_pickup_point->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_pickup_point->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_pickup_point" class="control-group">
<input type="text" data-field="x_fld_pickup_point" name="x_fld_pickup_point" id="x_fld_pickup_point" size="30" maxlength="100" placeholder="<?php echo $tbl_booking_detail->fld_pickup_point->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_pickup_point->EditValue ?>"<?php echo $tbl_booking_detail->fld_pickup_point->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_pickup_point->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_customer_name->Visible) { // fld_customer_name ?>
	<tr id="r_fld_customer_name">
		<td><span id="elh_tbl_booking_detail_fld_customer_name"><?php echo $tbl_booking_detail->fld_customer_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_customer_name->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_customer_name" class="control-group">
<input type="text" data-field="x_fld_customer_name" name="x_fld_customer_name" id="x_fld_customer_name" size="30" maxlength="50" placeholder="<?php echo $tbl_booking_detail->fld_customer_name->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_customer_name->EditValue ?>"<?php echo $tbl_booking_detail->fld_customer_name->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_customer_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_mobile_no->Visible) { // fld_mobile_no ?>
	<tr id="r_fld_mobile_no">
		<td><span id="elh_tbl_booking_detail_fld_mobile_no"><?php echo $tbl_booking_detail->fld_mobile_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_mobile_no->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_mobile_no" class="control-group">
<input type="text" data-field="x_fld_mobile_no" name="x_fld_mobile_no" id="x_fld_mobile_no" size="30" placeholder="<?php echo $tbl_booking_detail->fld_mobile_no->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_mobile_no->EditValue ?>"<?php echo $tbl_booking_detail->fld_mobile_no->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_mobile_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_booking_datetime->Visible) { // fld_booking_datetime ?>
	<tr id="r_fld_booking_datetime">
		<td><span id="elh_tbl_booking_detail_fld_booking_datetime"><?php echo $tbl_booking_detail->fld_booking_datetime->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_booking_datetime->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_booking_datetime" class="control-group">
<input type="text" data-field="x_fld_booking_datetime" name="x_fld_booking_datetime" id="x_fld_booking_datetime" placeholder="<?php echo $tbl_booking_detail->fld_booking_datetime->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_booking_datetime->EditValue ?>"<?php echo $tbl_booking_detail->fld_booking_datetime->EditAttributes() ?>>
<?php if (!$tbl_booking_detail->fld_booking_datetime->ReadOnly && !$tbl_booking_detail->fld_booking_datetime->Disabled && @$tbl_booking_detail->fld_booking_datetime->EditAttrs["readonly"] == "" && @$tbl_booking_detail->fld_booking_datetime->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_fld_booking_datetime" name="cal_x_fld_booking_datetime" class="btn" type="button"><img src="phpimages/calendar.png" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_booking_detailadd", "x_fld_booking_datetime", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $tbl_booking_detail->fld_booking_datetime->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_coupon_code->Visible) { // fld_coupon_code ?>
	<tr id="r_fld_coupon_code">
		<td><span id="elh_tbl_booking_detail_fld_coupon_code"><?php echo $tbl_booking_detail->fld_coupon_code->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_coupon_code->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_coupon_code" class="control-group">
<input type="text" data-field="x_fld_coupon_code" name="x_fld_coupon_code" id="x_fld_coupon_code" size="30" maxlength="50" placeholder="<?php echo $tbl_booking_detail->fld_coupon_code->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_coupon_code->EditValue ?>"<?php echo $tbl_booking_detail->fld_coupon_code->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_coupon_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_driver_rating->Visible) { // fld_driver_rating ?>
	<tr id="r_fld_driver_rating">
		<td><span id="elh_tbl_booking_detail_fld_driver_rating"><?php echo $tbl_booking_detail->fld_driver_rating->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_driver_rating->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_driver_rating" class="control-group">
<input type="text" data-field="x_fld_driver_rating" name="x_fld_driver_rating" id="x_fld_driver_rating" size="30" placeholder="<?php echo $tbl_booking_detail->fld_driver_rating->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_driver_rating->EditValue ?>"<?php echo $tbl_booking_detail->fld_driver_rating->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_driver_rating->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_customer_feedback->Visible) { // fld_customer_feedback ?>
	<tr id="r_fld_customer_feedback">
		<td><span id="elh_tbl_booking_detail_fld_customer_feedback"><?php echo $tbl_booking_detail->fld_customer_feedback->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_customer_feedback->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_customer_feedback" class="control-group">
<input type="text" data-field="x_fld_customer_feedback" name="x_fld_customer_feedback" id="x_fld_customer_feedback" size="30" maxlength="100" placeholder="<?php echo $tbl_booking_detail->fld_customer_feedback->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_customer_feedback->EditValue ?>"<?php echo $tbl_booking_detail->fld_customer_feedback->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_customer_feedback->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_cancelled->Visible) { // fld_is_cancelled ?>
	<tr id="r_fld_is_cancelled">
		<td><span id="elh_tbl_booking_detail_fld_is_cancelled"><?php echo $tbl_booking_detail->fld_is_cancelled->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_cancelled->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_cancelled" class="control-group">
<div id="tp_x_fld_is_cancelled" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_cancelled" id="x_fld_is_cancelled" value="{value}"<?php echo $tbl_booking_detail->fld_is_cancelled->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_cancelled" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_is_cancelled->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_is_cancelled->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_cancelled" name="x_fld_is_cancelled" id="x_fld_is_cancelled_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_is_cancelled->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_is_cancelled->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_total_fare->Visible) { // fld_total_fare ?>
	<tr id="r_fld_total_fare">
		<td><span id="elh_tbl_booking_detail_fld_total_fare"><?php echo $tbl_booking_detail->fld_total_fare->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_total_fare->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_total_fare" class="control-group">
<input type="text" data-field="x_fld_total_fare" name="x_fld_total_fare" id="x_fld_total_fare" size="30" placeholder="<?php echo $tbl_booking_detail->fld_total_fare->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_total_fare->EditValue ?>"<?php echo $tbl_booking_detail->fld_total_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_total_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_booked_driver_id->Visible) { // fld_booked_driver_id ?>
	<tr id="r_fld_booked_driver_id">
		<td><span id="elh_tbl_booking_detail_fld_booked_driver_id"><?php echo $tbl_booking_detail->fld_booked_driver_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_booked_driver_id->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_booked_driver_id" class="control-group">
<select data-field="x_fld_booked_driver_id" id="x_fld_booked_driver_id" name="x_fld_booked_driver_id"<?php echo $tbl_booking_detail->fld_booked_driver_id->EditAttributes() ?>>
<?php
if (is_array($tbl_booking_detail->fld_booked_driver_id->EditValue)) {
	$arwrk = $tbl_booking_detail->fld_booked_driver_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_booked_driver_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `fld_driver_ai_id`, `fld_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_driver_info`";
$sWhereWrk = "";

// Call Lookup selecting
$tbl_booking_detail->Lookup_Selecting($tbl_booking_detail->fld_booked_driver_id, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_fld_booked_driver_id" id="s_x_fld_booked_driver_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`fld_driver_ai_id` = {filter_value}"); ?>&amp;t0=19">
</span>
<?php echo $tbl_booking_detail->fld_booked_driver_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_approved->Visible) { // fld_is_approved ?>
	<tr id="r_fld_is_approved">
		<td><span id="elh_tbl_booking_detail_fld_is_approved"><?php echo $tbl_booking_detail->fld_is_approved->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_approved->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_approved" class="control-group">
<div id="tp_x_fld_is_approved" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_approved" id="x_fld_is_approved" value="{value}"<?php echo $tbl_booking_detail->fld_is_approved->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_approved" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_is_approved->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_is_approved->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_approved" name="x_fld_is_approved" id="x_fld_is_approved_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_is_approved->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_is_approved->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_completed->Visible) { // fld_is_completed ?>
	<tr id="r_fld_is_completed">
		<td><span id="elh_tbl_booking_detail_fld_is_completed"><?php echo $tbl_booking_detail->fld_is_completed->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_completed->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_completed" class="control-group">
<div id="tp_x_fld_is_completed" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_completed" id="x_fld_is_completed" value="{value}"<?php echo $tbl_booking_detail->fld_is_completed->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_completed" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_is_completed->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_is_completed->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_completed" name="x_fld_is_completed" id="x_fld_is_completed_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_is_completed->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_is_completed->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_booking_detail_fld_is_active"><?php echo $tbl_booking_detail->fld_is_active->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_active" class="control-group">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_booking_detail->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_is_active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_active" name="x_fld_is_active" id="x_fld_is_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_is_active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_booking_detail_fld_created_on"><?php echo $tbl_booking_detail->fld_created_on->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_created_on" class="control-group">
<input type="text" data-field="x_fld_created_on" name="x_fld_created_on" id="x_fld_created_on" placeholder="<?php echo $tbl_booking_detail->fld_created_on->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_created_on->EditValue ?>"<?php echo $tbl_booking_detail->fld_created_on->EditAttributes() ?>>
<?php if (!$tbl_booking_detail->fld_created_on->ReadOnly && !$tbl_booking_detail->fld_created_on->Disabled && @$tbl_booking_detail->fld_created_on->EditAttrs["readonly"] == "" && @$tbl_booking_detail->fld_created_on->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_fld_created_on" name="cal_x_fld_created_on" class="btn" type="button"><img src="phpimages/calendar.png" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_booking_detailadd", "x_fld_created_on", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $tbl_booking_detail->fld_created_on->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_dropoff_point->Visible) { // fld_dropoff_point ?>
	<tr id="r_fld_dropoff_point">
		<td><span id="elh_tbl_booking_detail_fld_dropoff_point"><?php echo $tbl_booking_detail->fld_dropoff_point->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_dropoff_point->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_dropoff_point" class="control-group">
<input type="text" data-field="x_fld_dropoff_point" name="x_fld_dropoff_point" id="x_fld_dropoff_point" size="30" maxlength="100" placeholder="<?php echo $tbl_booking_detail->fld_dropoff_point->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_dropoff_point->EditValue ?>"<?php echo $tbl_booking_detail->fld_dropoff_point->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_dropoff_point->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_estimated_time->Visible) { // fld_estimated_time ?>
	<tr id="r_fld_estimated_time">
		<td><span id="elh_tbl_booking_detail_fld_estimated_time"><?php echo $tbl_booking_detail->fld_estimated_time->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_estimated_time->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_estimated_time" class="control-group">
<input type="text" data-field="x_fld_estimated_time" name="x_fld_estimated_time" id="x_fld_estimated_time" size="30" maxlength="100" placeholder="<?php echo $tbl_booking_detail->fld_estimated_time->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_estimated_time->EditValue ?>"<?php echo $tbl_booking_detail->fld_estimated_time->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_estimated_time->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_estimated_fare->Visible) { // fld_estimated_fare ?>
	<tr id="r_fld_estimated_fare">
		<td><span id="elh_tbl_booking_detail_fld_estimated_fare"><?php echo $tbl_booking_detail->fld_estimated_fare->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_estimated_fare->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_estimated_fare" class="control-group">
<input type="text" data-field="x_fld_estimated_fare" name="x_fld_estimated_fare" id="x_fld_estimated_fare" size="30" placeholder="<?php echo $tbl_booking_detail->fld_estimated_fare->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_estimated_fare->EditValue ?>"<?php echo $tbl_booking_detail->fld_estimated_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_estimated_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_brn_no->Visible) { // fld_brn_no ?>
	<tr id="r_fld_brn_no">
		<td><span id="elh_tbl_booking_detail_fld_brn_no"><?php echo $tbl_booking_detail->fld_brn_no->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_brn_no->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_brn_no" class="control-group">
<input type="text" data-field="x_fld_brn_no" name="x_fld_brn_no" id="x_fld_brn_no" size="30" maxlength="100" placeholder="<?php echo $tbl_booking_detail->fld_brn_no->PlaceHolder ?>" value="<?php echo $tbl_booking_detail->fld_brn_no->EditValue ?>"<?php echo $tbl_booking_detail->fld_brn_no->EditAttributes() ?>>
</span>
<?php echo $tbl_booking_detail->fld_brn_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_journey_type->Visible) { // fld_journey_type ?>
	<tr id="r_fld_journey_type">
		<td><span id="elh_tbl_booking_detail_fld_journey_type"><?php echo $tbl_booking_detail->fld_journey_type->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_journey_type->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_journey_type" class="control-group">
<div id="tp_x_fld_journey_type" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_journey_type" id="x_fld_journey_type" value="{value}"<?php echo $tbl_booking_detail->fld_journey_type->EditAttributes() ?>></div>
<div id="dsl_x_fld_journey_type" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_journey_type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_journey_type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_journey_type" name="x_fld_journey_type" id="x_fld_journey_type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_journey_type->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_journey_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_vehicle_type->Visible) { // fld_vehicle_type ?>
	<tr id="r_fld_vehicle_type">
		<td><span id="elh_tbl_booking_detail_fld_vehicle_type"><?php echo $tbl_booking_detail->fld_vehicle_type->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_vehicle_type->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_vehicle_type" class="control-group">
<div id="tp_x_fld_vehicle_type" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_vehicle_type" id="x_fld_vehicle_type" value="{value}"<?php echo $tbl_booking_detail->fld_vehicle_type->EditAttributes() ?>></div>
<div id="dsl_x_fld_vehicle_type" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_vehicle_type->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_vehicle_type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_vehicle_type" name="x_fld_vehicle_type" id="x_fld_vehicle_type_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_vehicle_type->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_vehicle_type->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_vehicle_mode->Visible) { // fld_vehicle_mode ?>
	<tr id="r_fld_vehicle_mode">
		<td><span id="elh_tbl_booking_detail_fld_vehicle_mode"><?php echo $tbl_booking_detail->fld_vehicle_mode->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_vehicle_mode->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_vehicle_mode" class="control-group">
<div id="tp_x_fld_vehicle_mode" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_vehicle_mode" id="x_fld_vehicle_mode" value="{value}"<?php echo $tbl_booking_detail->fld_vehicle_mode->EditAttributes() ?>></div>
<div id="dsl_x_fld_vehicle_mode" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_vehicle_mode->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_vehicle_mode->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_vehicle_mode" name="x_fld_vehicle_mode" id="x_fld_vehicle_mode_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_vehicle_mode->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_booking_detail->fld_vehicle_mode->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_booking_detailadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_booking_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_booking_detail_add->Page_Terminate();
?>
