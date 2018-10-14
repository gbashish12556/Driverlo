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

$tbl_booking_detail_view = NULL; // Initialize page object first

class ctbl_booking_detail_view extends ctbl_booking_detail {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_booking_detail';

	// Page object name
	var $PageObjName = 'tbl_booking_detail_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["fld_booking_ai_id"] <> "") {
			$this->RecKey["fld_booking_ai_id"] = $_GET["fld_booking_ai_id"];
			$KeyUrl .= "&amp;fld_booking_ai_id=" . urlencode($this->RecKey["fld_booking_ai_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_booking_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_booking_detaillist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->fld_booking_ai_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["fld_booking_ai_id"] <> "") {
				$this->fld_booking_ai_id->setQueryStringValue($_GET["fld_booking_ai_id"]);
				$this->RecKey["fld_booking_ai_id"] = $this->fld_booking_ai_id->QueryStringValue;
			} else {
				$sReturnUrl = "tbl_booking_detaillist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tbl_booking_detaillist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "tbl_booking_detaillist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

			// fld_booking_ai_id
			$this->fld_booking_ai_id->LinkCustomAttributes = "";
			$this->fld_booking_ai_id->HrefValue = "";
			$this->fld_booking_ai_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "tbl_booking_detaillist.php", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, ew_CurrentUrl());
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_booking_detail_view)) $tbl_booking_detail_view = new ctbl_booking_detail_view();

// Page init
$tbl_booking_detail_view->Page_Init();

// Page main
$tbl_booking_detail_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_booking_detail_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_booking_detail_view = new ew_Page("tbl_booking_detail_view");
tbl_booking_detail_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_booking_detail_view.PageID; // For backward compatibility

// Form object
var ftbl_booking_detailview = new ew_Form("ftbl_booking_detailview");

// Form_CustomValidate event
ftbl_booking_detailview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_booking_detailview.ValidateRequired = true;
<?php } else { ?>
ftbl_booking_detailview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_booking_detailview.Lists["x_fld_booked_driver_id"] = {"LinkField":"x_fld_driver_ai_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fld_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<div class="ewViewExportOptions">
<?php $tbl_booking_detail_view->ExportOptions->Render("body") ?>
<?php if (!$tbl_booking_detail_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($tbl_booking_detail_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php $tbl_booking_detail_view->ShowPageHeader(); ?>
<?php
$tbl_booking_detail_view->ShowMessage();
?>
<form name="ftbl_booking_detailview" id="ftbl_booking_detailview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_booking_detail">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_booking_detailview" class="table table-bordered table-striped">
<?php if ($tbl_booking_detail->fld_booking_ai_id->Visible) { // fld_booking_ai_id ?>
	<tr id="r_fld_booking_ai_id">
		<td><span id="elh_tbl_booking_detail_fld_booking_ai_id"><?php echo $tbl_booking_detail->fld_booking_ai_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_booking_ai_id->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_booking_ai_id" class="control-group">
<span<?php echo $tbl_booking_detail->fld_booking_ai_id->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booking_ai_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_pickup_point->Visible) { // fld_pickup_point ?>
	<tr id="r_fld_pickup_point">
		<td><span id="elh_tbl_booking_detail_fld_pickup_point"><?php echo $tbl_booking_detail->fld_pickup_point->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_pickup_point->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_pickup_point" class="control-group">
<span<?php echo $tbl_booking_detail->fld_pickup_point->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_pickup_point->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_customer_name->Visible) { // fld_customer_name ?>
	<tr id="r_fld_customer_name">
		<td><span id="elh_tbl_booking_detail_fld_customer_name"><?php echo $tbl_booking_detail->fld_customer_name->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_customer_name->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_customer_name" class="control-group">
<span<?php echo $tbl_booking_detail->fld_customer_name->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_customer_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_mobile_no->Visible) { // fld_mobile_no ?>
	<tr id="r_fld_mobile_no">
		<td><span id="elh_tbl_booking_detail_fld_mobile_no"><?php echo $tbl_booking_detail->fld_mobile_no->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_mobile_no->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_mobile_no" class="control-group">
<span<?php echo $tbl_booking_detail->fld_mobile_no->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_mobile_no->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_booking_datetime->Visible) { // fld_booking_datetime ?>
	<tr id="r_fld_booking_datetime">
		<td><span id="elh_tbl_booking_detail_fld_booking_datetime"><?php echo $tbl_booking_detail->fld_booking_datetime->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_booking_datetime->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_booking_datetime" class="control-group">
<span<?php echo $tbl_booking_detail->fld_booking_datetime->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booking_datetime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_coupon_code->Visible) { // fld_coupon_code ?>
	<tr id="r_fld_coupon_code">
		<td><span id="elh_tbl_booking_detail_fld_coupon_code"><?php echo $tbl_booking_detail->fld_coupon_code->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_coupon_code->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_coupon_code" class="control-group">
<span<?php echo $tbl_booking_detail->fld_coupon_code->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_coupon_code->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_driver_rating->Visible) { // fld_driver_rating ?>
	<tr id="r_fld_driver_rating">
		<td><span id="elh_tbl_booking_detail_fld_driver_rating"><?php echo $tbl_booking_detail->fld_driver_rating->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_driver_rating->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_driver_rating" class="control-group">
<span<?php echo $tbl_booking_detail->fld_driver_rating->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_driver_rating->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_customer_feedback->Visible) { // fld_customer_feedback ?>
	<tr id="r_fld_customer_feedback">
		<td><span id="elh_tbl_booking_detail_fld_customer_feedback"><?php echo $tbl_booking_detail->fld_customer_feedback->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_customer_feedback->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_customer_feedback" class="control-group">
<span<?php echo $tbl_booking_detail->fld_customer_feedback->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_customer_feedback->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_cancelled->Visible) { // fld_is_cancelled ?>
	<tr id="r_fld_is_cancelled">
		<td><span id="elh_tbl_booking_detail_fld_is_cancelled"><?php echo $tbl_booking_detail->fld_is_cancelled->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_cancelled->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_cancelled" class="control-group">
<span<?php echo $tbl_booking_detail->fld_is_cancelled->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_cancelled->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_total_fare->Visible) { // fld_total_fare ?>
	<tr id="r_fld_total_fare">
		<td><span id="elh_tbl_booking_detail_fld_total_fare"><?php echo $tbl_booking_detail->fld_total_fare->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_total_fare->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_total_fare" class="control-group">
<span<?php echo $tbl_booking_detail->fld_total_fare->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_total_fare->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_booked_driver_id->Visible) { // fld_booked_driver_id ?>
	<tr id="r_fld_booked_driver_id">
		<td><span id="elh_tbl_booking_detail_fld_booked_driver_id"><?php echo $tbl_booking_detail->fld_booked_driver_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_booked_driver_id->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_booked_driver_id" class="control-group">
<span<?php echo $tbl_booking_detail->fld_booked_driver_id->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booked_driver_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_approved->Visible) { // fld_is_approved ?>
	<tr id="r_fld_is_approved">
		<td><span id="elh_tbl_booking_detail_fld_is_approved"><?php echo $tbl_booking_detail->fld_is_approved->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_approved->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_approved" class="control-group">
<span<?php echo $tbl_booking_detail->fld_is_approved->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_approved->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_completed->Visible) { // fld_is_completed ?>
	<tr id="r_fld_is_completed">
		<td><span id="elh_tbl_booking_detail_fld_is_completed"><?php echo $tbl_booking_detail->fld_is_completed->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_completed->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_completed" class="control-group">
<span<?php echo $tbl_booking_detail->fld_is_completed->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_completed->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_booking_detail_fld_is_active"><?php echo $tbl_booking_detail->fld_is_active->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_is_active" class="control-group">
<span<?php echo $tbl_booking_detail->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_active->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_booking_detail_fld_created_on"><?php echo $tbl_booking_detail->fld_created_on->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_created_on" class="control-group">
<span<?php echo $tbl_booking_detail->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_created_on->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_dropoff_point->Visible) { // fld_dropoff_point ?>
	<tr id="r_fld_dropoff_point">
		<td><span id="elh_tbl_booking_detail_fld_dropoff_point"><?php echo $tbl_booking_detail->fld_dropoff_point->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_dropoff_point->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_dropoff_point" class="control-group">
<span<?php echo $tbl_booking_detail->fld_dropoff_point->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_dropoff_point->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_estimated_time->Visible) { // fld_estimated_time ?>
	<tr id="r_fld_estimated_time">
		<td><span id="elh_tbl_booking_detail_fld_estimated_time"><?php echo $tbl_booking_detail->fld_estimated_time->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_estimated_time->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_estimated_time" class="control-group">
<span<?php echo $tbl_booking_detail->fld_estimated_time->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_estimated_time->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_estimated_fare->Visible) { // fld_estimated_fare ?>
	<tr id="r_fld_estimated_fare">
		<td><span id="elh_tbl_booking_detail_fld_estimated_fare"><?php echo $tbl_booking_detail->fld_estimated_fare->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_estimated_fare->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_estimated_fare" class="control-group">
<span<?php echo $tbl_booking_detail->fld_estimated_fare->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_estimated_fare->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_brn_no->Visible) { // fld_brn_no ?>
	<tr id="r_fld_brn_no">
		<td><span id="elh_tbl_booking_detail_fld_brn_no"><?php echo $tbl_booking_detail->fld_brn_no->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_brn_no->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_brn_no" class="control-group">
<span<?php echo $tbl_booking_detail->fld_brn_no->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_brn_no->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_journey_type->Visible) { // fld_journey_type ?>
	<tr id="r_fld_journey_type">
		<td><span id="elh_tbl_booking_detail_fld_journey_type"><?php echo $tbl_booking_detail->fld_journey_type->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_journey_type->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_journey_type" class="control-group">
<span<?php echo $tbl_booking_detail->fld_journey_type->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_journey_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_vehicle_type->Visible) { // fld_vehicle_type ?>
	<tr id="r_fld_vehicle_type">
		<td><span id="elh_tbl_booking_detail_fld_vehicle_type"><?php echo $tbl_booking_detail->fld_vehicle_type->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_vehicle_type->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_vehicle_type" class="control-group">
<span<?php echo $tbl_booking_detail->fld_vehicle_type->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_vehicle_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_booking_detail->fld_vehicle_mode->Visible) { // fld_vehicle_mode ?>
	<tr id="r_fld_vehicle_mode">
		<td><span id="elh_tbl_booking_detail_fld_vehicle_mode"><?php echo $tbl_booking_detail->fld_vehicle_mode->FldCaption() ?></span></td>
		<td<?php echo $tbl_booking_detail->fld_vehicle_mode->CellAttributes() ?>>
<span id="el_tbl_booking_detail_fld_vehicle_mode" class="control-group">
<span<?php echo $tbl_booking_detail->fld_vehicle_mode->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_vehicle_mode->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
ftbl_booking_detailview.Init();
</script>
<?php
$tbl_booking_detail_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_booking_detail_view->Page_Terminate();
?>
